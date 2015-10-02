<?php

/*
 * @ author Jose A. Luque
 * @ Copyright (c) 2011 - Jose A. Luque
 * @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
defined('_JEXEC') or die('Restricted access');

// We need the BrowserDetection class; if it's not loaded, we load it
if (!class_exists('BrowserDetection'))
{
	include_once JPATH_ADMINISTRATOR . '/components/com_joommark/helpers/BrowserDetection.php';
}

class plgSystemTracker extends JPlugin
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

	function plgSystemTracker(&$subject, $config)
	{
		parent::__construct($subject, $config);

		/* Load the language of the component */
		$lang = JFactory::getLanguage();
		$lang->load('com_joommark', JPATH_ADMINISTRATOR);
		$this->session = JFactory::getSession();
		$this->db = JFactory::getDbo();
		$this->app = JFactory::getApplication();
		$this->user = JFactory::getUser();



		/* Load the auxiliary methods */
		require_once JPATH_ADMINISTRATOR . '/components/com_joommark/helpers/database.php';
	}

	function onAfterInitialise()
	{

		// We store only front-end visits
		if ($this->app->getName() !== 'site')
		{
			return;
		}


		//Collecting the data
		// Extract info from BrowserDetection
		$browser_data = new BrowserDetection();
		if (!empty($browser_data))
		{
			$this->browser = $browser_data->getBrowser();
			$this->browser_version = $browser_data->getVersion();
			$this->platform = $browser_data->getPlatform();
			$this->is_mobile = $browser_data->isMobile();
			$this->is_robot = $browser_data->isRobot();
			$this->uri = $_SERVER['REQUEST_URI'];
			$this->ip = $_SERVER['REMOTE_ADDR'];
		} else
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
			//todo we have to think about this - perhaps we can use a random username
			$this->userName = 'guest';
			$this->userId = 0;
		}

		// update
		$this->updateReferer();
		$this->updateServerstats();
		$this->updateStats();
		//$this->updateServerstats_Time();
	}

	/**
	 * onBeforeDispatch handler
	 *
	 * Main plugin hook
	 *
	 * @access public
	 * @return void
	 */
	function onAfterRoute()
	{
		$this->app->input->post->set('nowpage', JUri::getInstance()->current());
	}

	/**
	 * Update #__joommarkt_referral
	 *
	 * @access protected
	 * @return Exception object otherwise boolean true
	 */
	protected function updateReferer()
	{

		//Collecting the data

		if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "")
		{
			$this->referer = trim($_SERVER['HTTP_REFERER']);
		} else
		{
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
		} else
		{
			//todo do we need our own (internal) referes
		}

		// Create and populate an object.
		$RefererObject = new stdClass();
		$RefererObject->referral = $this->referer;
		$RefererObject->record_date = date("Y-m-d");
		$RefererObject->ip = $this->ip;

		try
		{
			// Insert the object into the #__joommarkt_referral table.
			$result = JFactory::getDbo()->insertObject('#__joommarkt_referral', $RefererObject);
		} catch (Exception $e)
		{
			//todo exception handling
			//JFactory::getApplication()->enqueueMessage('Your Message', 'error');
			//JLog::add(JText::_('JTEXT_ERROR_MESSAGE'), JLog::WARNING, 'jerror');
			//dump($e->getMessage(),"exception");
		}
	}

	/**
	 * Update #__joommarkt_serverstats
	 *
	 * @access protected
	 * @return Exception object otherwise boolean true
	 */
	protected function updateServerstats()
	{

		// Create and populate an object.
		$ServerstatsObject = new stdClass();
		$ServerstatsObject->session_id = $this->session->getId();
		$ServerstatsObject->user_id_person = $this->userId;
		$ServerstatsObject->customer_name = $this->userName;
		$ServerstatsObject->visitdate = date("Y-m-d");
		$ServerstatsObject->visit_timestamp = 0;
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
			$query->select($this->db->quoteName("session_id"))
					->from($this->db->quoteName("#__joommarkt_serverstats"))
					->where($this->db->quoteName("session_id") . " = " . $this->db->quote($ServerstatsObject->session_id))
					->where($this->db->quoteName("visitdate") . " = " . $this->db->quote($ServerstatsObject->visitdate))
					->where($this->db->quoteName("visitedpage") . " = " . $this->db->quote(urldecode($this->app->input->post->getString('nowpage', null))));

			// Set the query and execute
			$this->db->setQuery($query);
			$exists = (bool) $this->db->loadResult();
			if ($this->db->getErrorNum())
			{
				//todo 
				//throw new Exception(JText::sprintf('COM_JOOMMLAMARK_ERROR_READING_EXISTING_SERVERSTAT', $this->db->getErrorMsg()), 'error', 'Server stats');
			}

			// Insert the object into the #__joommarkt_serverstats table. Otherwise update the time tracker
			if (!$exists)
			{
				// The record not exists, so insert a new record, it is the first time that in theis session this visitor visits this page
				$result = JFactory::getDbo()->insertObject('#__joommarkt_serverstats', $ServerstatsObject);
				if ($this->db->getErrorNum())
				{
					//todo 
					//throw new Exception(JText::sprintf('COM_JOOMMLAMARK_ERROR_READING_INSERTING_NEW_SERVERSTAT', $this->db->getErrorMsg()), 'error', 'Server stats');
				}
			} else
			{
				// In the case, that the user logged in the meantime, we have to update the username!
				$ServerstatsObjectOnlyName = new stdClass ();
				$ServerstatsObjectOnlyName->session_id = $this->session->getId();
				$ServerstatsObjectOnlyName->customer_name = $this->userName;
				$ServerstatsObjectOnlyName->user_id_person = $this->userId;
				$result = $this->db->updateObject('#__joommarkt_serverstats', $ServerstatsObjectOnlyName, 'session_id');
			}
		} catch (Exception $e)
		{
			//dump($e->getMessage(),"exception");
			//todo special exeption handling ...
		}
		return true;
	}

	/**
	 * Update #__joommarkt_stats (current sessions)
	 *
	 * @access protected
	 * @return Exception object otherwise boolean true
	 */
	protected function updateStats()
	{
		// Create and populate an object.
		$StatsObject = new stdClass();
		$StatsObject->session_id_person = $this->session->getId();
		$StatsObject->nowpage = urldecode($this->app->input->post->getString('nowpage', null));
		$StatsObject->lastupdate_time = time();
		$StatsObject->current_name = $this->userName;

		try
		{
			// Test if the session is open
			$query = $this->db->getQuery(true);
			$query->select($this->db->quoteName("session_id_person"))
					->from($this->db->quoteName("#__joommarkt_stats"))
					->where($this->db->quoteName("session_id_person") . " = " . $this->db->quote($StatsObject->session_id_person));

			// Set the query and execute
			$this->db->setQuery($query);
			$exists = (bool) $this->db->loadResult();
			if ($this->db->getErrorNum())
			{
				//todo 
				//throw new Exception(JText::sprintf('COM_JOOMMLAMARK_ERROR_READING_EXISTING_STAT', $this->db->getErrorMsg()), 'error', 'Server stats');
			}

			// Insert the object into the #__joommarkt_serverstats table. Otherwise update the time tracker
			if (!$exists)
			{
				// Insert the object into the #__joommarkt_stats table.
				$result = JFactory::getDbo()->insertObject('#__joommarkt_stats', $StatsObject);
				if ($this->db->getErrorNum())
				{
					//todo 
					//throw new Exception(JText::sprintf('COM_JOOMMLAMARK_ERROR_READING_INSERTING_NEW_STAT', $this->db->getErrorMsg()), 'error', 'Server stats');
				}
			} else
			{
				// In the case, that the session exists we have to update nowpage and lastupdate_time!
				//Todo or have we do this only on afterroute?
				$StatsObjectOnlyName = new stdClass ();
				$StatsObjectOnlyName->session_id_person = $this->session->getId();
				$StatsObjectOnlyName->lastupdate_time = time();
				$StatsObjectOnlyName->nowpage = urldecode($this->app->input->post->getString('nowpage', null));
				$StatsObjectOnlyName->current_name = $this->userName;
				$result = $this->db->updateObject('#__joommarkt_stats', $StatsObjectOnlyName, 'session_id_person');
			}
		} catch (Exception $e)
		{
			//dump($e->getMessage(),"exception");
			//todo special exeption handling
		}
		return true;
	}

	/**
	 * Update #__joommarkt_serverstats
	 *
	 * @access protected
	 * @return Exception object otherwise boolean true
	 */
	protected function updateServerstats_Time()
	{

		try
		{
			// We have to count the time - could we make it like this?
			$ServerstatsObjectOnlyTime = new stdClass ();
			$ServerstatsObjectOnlyTime->session_id = $this->session->getId();
			$ServerstatsObjectOnlyTime->visitdate = date("Y-m-d");
			$ServerstatsObjectOnlyTime->visitedpage = urldecode($this->app->input->post->getString('nowpage', null));
			$ServerstatsObjectOnlyTime->seconds = 0; //todo here we have to find a way for saving the time
			return $this->db->updateObject('#__joommarkt_serverstats', $ServerstatsObjectOnlyTime, 'session_id,visitdate,visitedpage');
		} catch (Exception $e)
		{
			//dump($e->getMessage(),"exception");
			//todo special exeption handling ...
		}
		return true;
	}

	function onAfterDispatch()
	{
		//$buffer = JFactory::getDocument()->getBuffer('component');
		//$kk = JFactory::getDocument()->addScriptDeclaration(';/* START: Modals scripts */ /* END: Modals scripts */','text/javascript');
		//$content = 'alert(\'Hola\')';
		//$content = '$(".group2").colorbox({rel:\'group2\', transition:"fade"});';
		//$content = 'jQuery(window).on(\'load\',  function() {';
		//$content = '$(window).load(function(){';

		/* $content = '$(document).ready(function(){';			
		  $content .= '$("#Joommark_modal").modal(\'show\');';
		  $content .= '});'; */

		$content = 'window.addEvent("domready", function() {';
		$content .= '$("#Joommark_modal").modal(\'show\');';
		$content .= '});';
		//$content = 'alert("hola")';

		/* $content = 'addEvent(document.getElementById(\'Joommark_modal\'), \'mousemove\', function(event) {';
		  $content .= '$(\'#Joommark_modal\').modal(\'show\');';
		  $content .= '});'; */
		$doc = & JFactory::getDocument();
		$doc->addScriptDeclaration($content);
		//$doc->addScript('/media/com_joommark/javascript/bootstrap-modal.js');


		$kk = $doc->getBuffer();
		//dump($kk,"kk");

		/* $doc->addScript('modals/jquery.colorbox.js');
		  $doc->addScript('modals/script.min.js'); */

		//$this->replace($buffer, 'component');
		//dump("llega","llega");
	}

	public function onAfterRender()
	{
		// only in html and feeds
		if (JFactory::getDocument()->getType() !== 'html' && JFactory::getDocument()->getType() !== 'feed')
		{
			return;
		}

		$html = JResponse::getBody();
		if ($html == '')
		{
			return;
		}


		$to_replace = '<div class="modal in fade" id="Joommark_modal">' . PHP_EOL;
		$to_replace .= '<div class="modal-header">' . PHP_EOL;
		$to_replace .= '<a class="close" data-dismiss="modal">×</a>' . PHP_EOL;
		$to_replace .= '  <h3>Modal header</h3>' . PHP_EOL;
		$to_replace .= '</div>' . PHP_EOL;
		$to_replace .= '<div class="modal-body">' . PHP_EOL;
		$to_replace .= '<p>One fine body…</p>' . PHP_EOL;
		$to_replace .= '</div>' . PHP_EOL;
		$to_replace .= '<div class="modal-footer">' . PHP_EOL;
		$to_replace .= '<a href="#" class="btn">Close</a>' . PHP_EOL;
		$to_replace .= '<a href="#" class="btn btn-primary">Save changes</a>' . PHP_EOL;
		$to_replace .= '</div>' . PHP_EOL;
		$to_replace .= '<a href="#Joommark_modal" role="button" class="btn btn-inverse btn-mini" data-toggle="modal">kk</a></div>' . PHP_EOL;

		/* $to_replace .= '<script type="text/javascript">';
		  $to_replace .= 'jQuery(window).on(\'load\',  function() {';
		  $to_replace .= '$(\'#Joommark_modal\').modal(\'show\');';
		  $to_replace .= '});';
		  $to_replace .= '</script>'; */

		$to_replace .= '</body>';

		$html = str_replace("</body>", $to_replace, $html);

		JResponse::setBody($html);
	}

}
