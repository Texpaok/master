<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_jommark
 *
 * @copyright   Copyright (C) 2014-2015 Jose A. Luque and Astrid Günther. All rights reserved.
 * @license     GNU General Public License version 2
 */
defined('_JEXEC') or die('Restricted access');

/**
 * class Joommark Model Flow
 *
 * @since  1.0
 */
class JoommarkModelFlow extends JModelLegacy
{
	/**
	 * Session Object
	 *
	 * @access private
	 * @var Object &
	 */
	private $session;

	/**
	 * User Object
	 *
	 * @access private
	 * @var Object &
	 */
	private $myUser;

	/**
	 * Component config
	 *
	 * @access private
	 * @var Object &
	 */
	private $config;

	/**
	 * Max lifetime
	 *
	 * @access private
	 * @var int
	 */
	private $maxInactivityTime;

	/**
	 * Array
	 *
	 * @access private
	 * @var array
	 */
	private $response;

	/**
	 * Component params with view override
	 *
	 * @access protected
	 * @var Object
	 */
	protected $componentParams;

	/**
	 * Execute
	 *
	 * @access public
	 * @return Object The response object to be encoded for JS app
	 */
	public function getData()
	{
		$initialize = $this->getState('initialize', false);

		// Store server stats con dependency injected object
		$userName = $this->myUser->name;

		if (!$userName)
		{
			$userName = 'Guest';
		}

		$this->setState('username', $userName);
		$this->setState('userid', $this->myUser->id);

		if ($initialize)
		{
			// Take the parameters for JoommarkSetTimeout.js
			if (!empty($this->cParams))
			{
				$this->response ['configparams'] = $this->cParams->toObject();
				unset($this->response['configparams']->rules);
			}
		}

		return $this->response;
	}

	/**
	 * Class constructor
	 *
	 * @param   array  $config  The config
	 */
	public function __construct($config = array())
	{
		// Hold JS client app response
		$this->response = array();

		// Session table
		$this->session = $config ['sessiontable'];

		// User object
		$this->myUser = JFactory::getUser();

		// Component config with override management by model
		$this->cParams = $this->getComponentParams();

		// Set max life time for valid session on Realtime display stats
		$this->maxInactivityTime = '8';

		parent::__construct($config);
	}

	/**
	 * Get the component params width view override/merge
	 *
	 * @return Object
	 */
	public function getComponentParams()
	{
		if (is_object($this->componentParams))
		{
			return $this->componentParams;
		}

		// Todo Do we need view overrides ??
		// Get the configuration options.
		$app = JFactory::getApplication();
		$this->componentParams = $app->getParams('com_joommark');

		return $this->componentParams;
	}

	/**
	 * Save the seconds depending on the parameter
	 *
	 * @return Object
	 */
	public function saveSeconds()
	{
		try
		{
			$this->session = JFactory::getSession();
			$this->app = JFactory::getApplication();
			$this->user = JFactory::getUser();

			// Create a new query object.
			$this->db = $this->getDbo();

			$this->input = new JInput;

			// Die $_POST Superglobale beziehen.

			$nowpage = str_replace(JUri::getInstance()->base(), '', urldecode($this->app->input->post->getString('nowpage', null)));

			// Create a new query object.
			$query = $this->db->getQuery(true);

			// Fields to update.
			$fields = array(
				$this->db->quoteName('seconds') . ' = ' . '(' . $this->_db->quoteName('seconds') . ' + 1)'
			);

			// Conditions for which records should be updated.
			$conditions = array(
				$this->db->quoteName('session_id') . " like " . $this->db->quote($this->session->getId()),
				$this->db->quoteName('visitdate') . " like " . $this->db->quote(date('Y-m-d')),
				$this->db->quoteName('visitedpage') . " like " . $this->db->quote($nowpage)
			);

			$query->update($this->db->quoteName('#__joommark_serverstats'))->set($fields)->where($conditions);

			$this->db->setQuery($query);

			$result = $this->db->execute();
		}
		catch (Exception $e)
		{
			// Dump($e->getMessage(),"exception");
			// Todo special exeption handling ...
		}
	}
}
