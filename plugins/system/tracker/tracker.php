<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.joommark
 *
 * @copyright   Copyright (c) 2015 - Jose A. Luque.
 * @license     GNU General Public License version 2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
defined('_JEXEC') or die('Restricted access');

// We need the BrowserDetection class; if it's not loaded, we load it
if (!class_exists('BrowserDetection'))
{
	include_once JPATH_ADMINISTRATOR . '/components/com_joommark/helpers/BrowserDetection.php';
}

/**
 * Joommark Tracker Plugin
 *
 * @since  1.0
 */
class PlgSystemTracker extends JPlugin
{
	/**
	 * Database reference
	 *
	 * @access protected
	 * @var Object
	 */
	protected $db;

	/**
	 * App reference
	 *
	 * @access protected
	 * @var Object
	 */
	protected $app;

	/**
	 * User reference
	 *
	 * @access protected
	 * @var Object
	 */
	protected $user;

	/**
	 * Session reference
	 *
	 * @access protected
	 * @var Object
	 */
	protected $session;

	protected $media_path = "media/com_joommark";

	/**
	 * Constructor
	 *
	 * @param   object  &$subject  The object to observe
	 * @param   array   $config    An optional associative array of configuration settings.
	 *                             Recognized key values include 'name', 'group', 'params', 'language'
	 *                             (this list is not meant to be comprehensive).
	 *
	 * @since   1.0
	 */
	public function __construct(&$subject, $config = array())
	{
		parent::__construct($subject, $config);

		/* Load the language of the component */
		$lang = JFactory::getLanguage();
		$lang->load('com_joommark', JPATH_ADMINISTRATOR);
		$this->session = JFactory::getSession();
		$this->db = JFactory::getDbo();
		$this->app = JFactory::getApplication();
		$this->user = JFactory::getUser();
		$this->params = JComponentHelper::getParams('com_joommark');

		/* Load the auxiliary methods */
		require_once JPATH_ADMINISTRATOR . '/components/com_joommark/helpers/database.php';
	}

	/**
	 * onAfterInitialise
	 *
	 * @return Exception object otherwise boolean true
	 *
	 * @since   1.0
	 */
	public function onAfterInitialise()
	{
		// We store only front-end visits
		if ($this->app->getName() !== 'site')
		{
			return;
		}

		/*
		 * Collecting the data
		 * Extract info from BrowserDetection
		 */
		$browser_data = new BrowserDetection;

		if (!empty($browser_data))
		{
			$this->browser = $browser_data->getBrowser();
			$this->browser_version = $browser_data->getVersion();
			$this->platform = $browser_data->getPlatform();
			$this->is_mobile = $browser_data->isMobile();
			$this->is_robot = $browser_data->isRobot();
			$this->uri = JRequest::getVar('REQUEST_URI', ' ', 'server', 'STRING');
			$this->ip = JRequest::getVar('REMOTE_ADDR', ' ', 'server', 'STRING');
		}
		else
		{
			$this->browser = JText::_('COM_JOOMMARK_UNKNOW');
			$this->browser_version = JText::_('COM_JOOMMARK_UNKNOW');
			$this->platform = JText::_('COM_JOOMMARK_UNKNOW');
		}
		// Get the user name
		$this->userName = $this->user->name;

		// Get the user id
		$this->userId = $this->user->id;

		if (!$this->userName)
		{
			// Todo we have to think about this - perhaps we can use a random username
			$this->userName = JText::_('COM_JOOMMARK_GUEST_PREFIX') . '_' . $this->generateSuffixFromSessionId($this->session->getId());
			$this->userId = 0;
		}

		// Update
		$this->updateReferer();
		$this->updateServerstats();
		$this->updateStats();
		$this->tidyingup();
	}

	/**
	 * Methode generateSuffixFromSessionId
	 *
	 * @param   String  $sessionID  The session id
	 *
	 * @return	 String
	 *
	 * @since   1.0
	 */
	public function generateSuffixFromSessionId($sessionID)
	{
		$matches = array();

		// Take all digits from session id
		preg_match_all('/\d/i', $sessionID, $matches);

		// Implode the digits
		$SuffixFromSessionId = 0000;
		if (is_array($matches [0]) && count($matches [0]))
		{
			$SuffixFromSessionId = (float) (implode('', $matches [0]));
		}

		//Take the first four digits
		$SuffixFromSessionId = substr($SuffixFromSessionId, 0, 4);

		return $SuffixFromSessionId;
	}

	/**
	 * Update #__joommark_referral
	 *
	 * @access protected
	 * @return Exception object otherwise boolean true
	 */
	protected function updateReferer()
	{
		// Collecting the data
		// ToDo if (isset($GLOBALS['_JREQUEST'][$name]['SET.' . $hash]) && ($GLOBALS['_JREQUEST'][$name]['SET.' . $hash] === true))
		if (null != JRequest::getVar('HTTP_REFERER', ' ', 'server', 'STRING'))
		{
			$this->referer = trim(JRequest::getVar('HTTP_REFERER', ' ', 'server', 'STRING'));
		}
		else
		{
			/* No Referer if
			 *
			 * - entered the site URL in browser address bar itself
			 * - visited the site by a browser-maintained bookmark.
			 * - visited the site as first page in the window/tab
			 * - switched from a https URL
			 * - has security software installed, or behind a proxi that strips the referrer
			 * - visited the site programmatically without setting the header
			 *
			 */
			$this->referer = JText::_('COM_JOOMMARK_UNKNOW');
		}

		// Are the referrer external
		$uriReferral = JUri::getInstance($this->referer);
		$hostReferral = $uriReferral->toString(array('scheme', 'host', 'port'));
		$uriCurrentpage = JUri::getInstance();
		$baseCurrentPage = $uriCurrentpage->base();

		if (stripos($baseCurrentPage, $hostReferral) === 0 && !empty($hostReferral))
		{
			return true;
		}
		else
		{
			/*
			 * do we need our own intern refers;
			 */
		}

		// Create and populate an object.
		$RefererObject = new stdClass;
		$RefererObject->referral = $this->referer;
		$RefererObject->record_date = date("Y-m-d");
		$RefererObject->ip = $this->ip;

		try
		{
			// Insert the object into the #__joommark_referral table.
			JFactory::getDbo()->insertObject('#__joommark_referral', $RefererObject);
		}
		catch (Exception $e)
		{
			/*
			 *  Todo exception handling
			 *  JFactory::getApplication()->enqueueMessage('Your Message', 'error');
			 *  JLog::add(JText::_('JTEXT_ERROR_MESSAGE'), JLog::WARNING, 'jerror');
			 *  Dump($e->getMessage(),"exception");
			 */
			JFactory::getApplication()->enqueueMessage($e->getMessage());
		}
	}

	/**
	 * Update #__joommark_serverstats
	 *
	 * @access protected
	 * @return Exception object otherwise boolean true
	 */
	protected function updateServerstats()
	{
		// Url is not set, because onafterroute is not yet ready
		if ($this->app->input->post->getString('nowpage', null) === null)
		{
			// Return;
		}
		else
		{
			// Do we have to do something special here?
		}

		// Create and populate an object.
		$ServerstatsObject = new stdClass;
		$ServerstatsObject->session_id = $this->session->getId();
		$ServerstatsObject->user_id_person = $this->userId;
		$ServerstatsObject->customer_name = $this->userName;
		$ServerstatsObject->visitdate = date("Y-m-d");
		$ServerstatsObject->visit_timestamp = date("Y-m-d H:i:s");
		$ServerstatsObject->visitedpage = urldecode($this->app->input->post->getString('nowpage', null));
		$ServerstatsObject->geolocation = 'todo';
		$ServerstatsObject->ip = $this->ip;
		$ServerstatsObject->browser = $this->browser . ' ' . $this->browser_version;
		$ServerstatsObject->os = $this->platform;
		$ServerstatsObject->seconds = 0;

		try
		{
			// Test if the user visited this page in this session
			$query = $this->db->getQuery(true);
			$query->select($this->db->quoteName('session_id'))
					->from($this->db->quoteName('#__joommark_serverstats'))
					->where($this->db->quoteName('session_id') . " = " . $this->db->quote($ServerstatsObject->session_id))
					->where($this->db->quoteName('visitdate') . " = " . $this->db->quote($ServerstatsObject->visitdate))
					->where($this->db->quoteName('visitedpage') . " = " . $this->db->quote(urldecode($this->app->input->post->getString('nowpage', null))));

			// Set the query and execute
			$this->db->setQuery($query);
			$exists = (bool) $this->db->loadResult();

			if ($this->db->getErrorNum())
			{
				// Todo
				throw new Exception(
				JText::sprintf('PLG_TRACKER_COM_JOOMMLAMARK_ERROR_READING_INSERTING_NEW_STAT', $this->db->getErrorMsg()), 'error', 'Server stats');
			}

			// Insert the object into the #__joommark_serverstats table. Otherwise update the time tracker
			if (!$exists)
			{
				// The record not exists, so insert a new record, it is the first time that in this session this visitor visits this page
				$result = JFactory::getDbo()->insertObject('#__joommark_serverstats', $ServerstatsObject);

				if ($this->db->getErrorNum())
				{
					/* Todo
					 * Throw new Exception(JText::sprintf('COM_JOOMMLAMARK_ERROR_READING_INSERTING_NEW_SERVERSTAT',
					 * $this->db->getErrorMsg()), 'error', 'Server stats');
					 *
					 */
					throw new Exception(
					JText::sprintf('PLG_TRACKER_COM_JOOMMLAMARK_ERROR_READING_INSERTING_NEW_STAT', $this->db->getErrorMsg()), 'error', 'Server stats');
				}
			}
			else
			{
				// In the case, that the user logged in the meantime, we have to update the username!
				$ServerstatsObjectOnlyName = new stdClass;
				$ServerstatsObjectOnlyName->session_id = $this->session->getId();
				$ServerstatsObjectOnlyName->customer_name = $this->userName;
				$ServerstatsObjectOnlyName->user_id_person = $this->userId;
				$result = $this->db->updateObject('#__joommark_serverstats', $ServerstatsObjectOnlyName, 'session_id');
			}
		}
		catch (Exception $e)
		{
			// Dump($e->getMessage(),"exception");
			// Todo special exeption handling ...
			JFactory::getApplication()->enqueueMessage($e->getMessage());
		}
		return true;
	}

	/**
	 * Delete expired records
	 *
	 * @access protected
	 * @return Exception object otherwise boolean true
	 */
	protected function tidyingup()
	{
		// ToDo nur einmal am Tag ausführen
		$gcenabled = $this->params->get('gcenabled', 0);
		$expiredays = $this->params->get('gc_serverstats_period', 99);

		/* @var $date type */
		$date = strtotime('-' . $expiredays . ' day');

		/* @var $dateString type */
		$dateString = date('Y-m-d', $date);
		$db = JFactory::getDbo();

		if (isset($gcenabled) && $gcenabled)
		{
			/*
			 * REFERER
			 */
			try
			{
				$query = $db->getQuery(true);
				$conditions = array(
					$db->quoteName('record_date') . ' <= ' . $db->quote($dateString)
				);

				$query->delete($db->quoteName('#__joommark_referral'));
				$query->where($conditions);

				$db->setQuery($query);

				$result = $db->execute();
			}
			catch (Exception $e)
			{
				JFactory::getApplication()->enqueueMessage($e->getMessage());

				// Todo special exeption handling
			}

			/*
			 * SEARCH
			 */
			try
			{
				$query = $db->getQuery(true);
				$conditions = array(
					$db->quoteName('record_date') . ' <= ' . $db->quote($dateString)
				);

				$query->delete($db->quoteName('#__joommark_searches'));
				$query->where($conditions);

				$db->setQuery($query);

				$result = $db->execute();
			}
			catch (Exception $e)
			{
				JFactory::getApplication()->enqueueMessage($e->getMessage());

				// Todo special exeption handling
			}

			/*
			 * SERVERSTATS
			 */
			try
			{
				$query = $db->getQuery(true);
				$conditions = array(
					$db->quoteName('visitdate') . ' <= ' . $db->quote($dateString)
				);

				$query->delete($db->quoteName('#__joommark_serverstats'));
				$query->where($conditions);

				$db->setQuery($query);

				$result = $db->execute();
			}
			catch (Exception $e)
			{
				JFactory::getApplication()->enqueueMessage($e->getMessage());

				// Todo special exeption handling
			}

			/*
			 * STATS
			 */
			try
			{
				$query = $db->getQuery(true);
				$conditions = array(
					$db->quoteName('lastupdate_time') . ' <= ' . $db->quote($date)
				);

				$query->delete($db->quoteName('#__joommark_stats'));
				$query->where($conditions);

				$db->setQuery($query);

				$result = $db->execute();
			}
			catch (Exception $e)
			{
				JFactory::getApplication()->enqueueMessage($e->getMessage());

				// Todo special exeption handling
			}
		}

		return true;
	}

	/**
	 * Update #__joommark_stats (current sessions)
	 *
	 * @access protected
	 * @return Exception object otherwise boolean true
	 */
	protected function updateStats()
	{
		// Create and populate an object.
		$StatsObject = new stdClass;
		$StatsObject->session_id_person = $this->session->getId();
		$StatsObject->nowpage = urldecode($this->app->input->post->getString('nowpage', null));
		$StatsObject->lastupdate_time = time();
		$StatsObject->current_name = $this->userName;

		try
		{
			// Test if the session is open
			$query = $this->db->getQuery(true);
			$query->select($this->db->quoteName("session_id_person"))
					->from($this->db->quoteName("#__joommark_stats"))
					->where($this->db->quoteName("session_id_person") . " = " . $this->db->quote($StatsObject->session_id_person));

			// Set the query and execute
			$this->db->setQuery($query);
			$exists = (bool) $this->db->loadResult();

			if ($this->db->getErrorNum())
			{
				// Todo
				throw new Exception(
				JText::sprintf('PLG_TRACKER_COM_JOOMMLAMARK_ERROR_READING_INSERTING_NEW_STAT', $this->db->getErrorMsg()), 'error', 'Server stats');
			}

			// Insert the object into the #__joommark_serverstats table. Otherwise update the time tracker
			if (!$exists)
			{
				// Insert the object into the #__joommark_stats table.
				$result = JFactory::getDbo()->insertObject('#__joommark_stats', $StatsObject);

				if ($this->db->getErrorNum())
				{
					// Todo
					throw new Exception(
					JText::sprintf('PLG_TRACKER_COM_JOOMMLAMARK_ERROR_READING_INSERTING_NEW_STAT', $this->db->getErrorMsg()), 'error', 'Server stats');
				}
			}
			else
			{
				// In the case, that the session exists we have to update nowpage and lastupdate_time!
				// Todo or have we do this only on afterroute?
				$StatsObjectOnlyName = new stdClass;
				$StatsObjectOnlyName->session_id_person = $this->session->getId();
				$StatsObjectOnlyName->lastupdate_time = time();
				$StatsObjectOnlyName->nowpage = urldecode($this->app->input->post->getString('nowpage', null));
				$StatsObjectOnlyName->current_name = $this->userName;
				$result = $this->db->updateObject('#__joommark_stats', $StatsObjectOnlyName, 'session_id_person');
			}
		}
		catch (Exception $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage());

			// Todo special exeption handling
		}
		return true;
	}

	/**
	 * onAfterRoute
	 *
	 * @return Exception object otherwise boolean true
	 *
	 * @since   1.0
	 */
	public function onAfterRoute()
	{
		$this->app->input->post->set('nowpage', JUri::getInstance()->current());

		// Shows pop-up only to front-end visits
		if ($this->app->getName() == 'site')
		{
			$doc = JFactory::getDocument();
			JHTML::_('behavior.modal');
			JHtml::_('jquery.framework');
			$doc->addScript($this->media_path . '/javascript/messages.js');

			$doc->addScript($this->media_path . '/javascript/js.cookie.js');
			$doc->addScript($this->media_path . '/javascript/JoommarkSetTimeout.js');
			JHtml::script('com_joommark/javascript/JoommarkSetTimeout.js', false, true);

			$doc->addStyleSheet($this->media_path . '/stylesheets/JoommarkStyles.css');
			$doc->addStyleSheet('/templates/protostar/css/template.css');
		}
	}

	/**
	 * onAfterDispatch
	 *
	 * Main plugin hook
	 *
	 * @access public
	 * @return void
	 */
	public function onAfterDispatch()
	{
		// Shows pop-up only to front-end visits
		if ($this->app->getName() == 'site')
		{
			$doc = JFactory::getDocument();
			$base = JURI::root();
			$doc->addScriptDeclaration("var joommarkBaseURI='$base';");
		}
	}

	/**
	 * onAfterRender
	 *
	 * Main plugin hook
	 *
	 * @access public
	 * @return void
	 */
	public function onAfterRender()
	{
		// Shows pop-up only to front-end visits
		if ($this->app->getName() == 'site')
		{
			// Only in html and feeds
			if (JFactory::getDocument()->getType() !== 'html' && JFactory::getDocument()->getType() !== 'feed')
			{
				return;
			}

			// Get active menu id or default page
			$menuDefault = $this->app->getMenu()->getDefault();
			$menuActive = $this->app->getMenu()->getActive();

			if ($menuActive)
			{
				$menuid = $menuActive->id;
			}
			else
			{
				$menuid = $menuDefault->id;
			}

			// We need the MessagesHelper class to retrieve message info
			JLoader::register('MessagesHelper', JPATH_ADMINISTRATOR . '/components/com_joommark/helpers/messages.php');

			// Get message using the menuid and user view levels
			$message = MessagesHelper::getMessageInfo($menuid, $this->user->getAuthorisedViewLevels());

			// There is a message to show in this menu
			if (!empty($message['message']))
			{
				$html = JResponse::getBody();

				if ($html == '')
				{
					return;
				}

				$to_replace = '<div class="modal fade joommark-percentage" id="Joommark_modal" data-percentage="' . $message['percentage'] . '">' . PHP_EOL;
				$to_replace .= '<div class="modal-header joommark-id" data-id="' . $message['id'] . '">' . PHP_EOL;
				$to_replace .= '<a class="close" data-dismiss="modal">×</a>' . PHP_EOL;
				$to_replace .= '<h3>' . $message['title'] . '</h3>' . PHP_EOL;
				$to_replace .= '</div>' . PHP_EOL;
				$to_replace .= '<div class="modal-body">' . PHP_EOL;
				$to_replace .= '<p>' . $message['message'] . '</p>' . PHP_EOL;
				$to_replace .= '</div>' . PHP_EOL;
				$to_replace .= '<div class="modal-footer">' . PHP_EOL;

				/* $to_replace .= '<a href="#Joommark_modal" role="button" class="btn btn-primary" id="close_button"
				  data-toggle="modal">' . JText::_( 'COM_JOOMMARK_CLOSE' ) .'</a>' . PHP_EOL; */
				$to_replace .= '<a href="#Joommark_modal" role="button" class="btn btn-primary" id="not_show_button" '
						. 'data-toggle="modal">' . JText::_('COM_JOOMARK_DONT_SHOW') . '</a>' . PHP_EOL;
				$to_replace .= '</div>' . PHP_EOL;
				$to_replace .= '</div>' . PHP_EOL;

				$to_replace .= '<script type="text/javascript">';
				$to_replace .= "jQuery('#not_show_button').on('click', function(event) {";
				$to_replace .= 'Cookies.set("joommark_message_' . $message['id'] . '", "all", { expires: ' . $message['cookie'] . '});';
				$to_replace .= '});';
				/* $to_replace .= "jQuery('#close_button').on('click', function(event) {";
				  $to_replace .= 'Cookies.set("message_' . $message['id'] . '", "true", { expires: ' . $message['cookie'] . '});';
				  $to_replace .= '});'; */
				$to_replace .= '</script>';

				$to_replace .= '</body>';

				$html = str_replace("</body>", $to_replace, $html);

				JResponse::setBody($html);
			}
		}
	}

	/**
	 * OnContentSearch
	 *
	 * @param   string  $text  Target search string.
	 *
	 * @return  array  Search results.
	 *
	 * @since   1.0
	 */
	public function onContentSearch($text)
	{
		// Exclude always for backend
		if ($this->app->getName() == 'admin')
		{
			return false;
		}

		$doc = JFactory::getDocument();

		if ($doc->getType() !== 'html')
		{
			return false;
		}

		// Discard other params and take only text keywords
		if (trim($text))
		{
			$this->saveSearchword(trim($text));

			// TODOReturn notifications/Exception if called from this plugin
		}
	}

	/**
	 * Set text searched by users in frontent,
	 * TODO both for old search and com_finder smart search?
	 *
	 * @param   string  $text  The phrase searched keyword to store/increment
	 *
	 * @access   protected
	 * @return   mixed  If some exceptions occur return an Exception object otherwise boolean true
	 */
	protected function saveSearchword($text)
	{
		// Create and populate an object.
		$SearchObject = new stdClass;
		$SearchObject->user_id_person = $this->userId;
		$SearchObject->record_date = date("Y-m-d");
		$SearchObject->searchword = $text;

		try
		{
			// Insert the object into the #__joommark_stats table.
			JFactory::getDbo()->insertObject('#__joommark_searches', $SearchObject);
		}
		catch (Exception $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage());

			// Todo special exeption handling
		}
		return true;
	}
}