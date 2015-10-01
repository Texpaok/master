<?php
/*
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.helper');
jimport( 'joomla.plugin.plugin' );

// We need the BrowserDetection class; if it's not loaded, we load it
if(!class_exists('BrowserDetection')){
    include_once JPATH_ADMINISTRATOR . '/components/com_joommark/helpers/BrowserDetection.php';
}
	
class plgSystemTracker extends JPlugin
{
	// Variables initialization
	private $visitors = array();
	
	function plgSystemTracker( &$subject, $config ){
		parent::__construct( $subject, $config );

		/* Load the language of the component */
		$lang = JFactory::getLanguage();
		$lang->load('com_joommark',JPATH_ADMINISTRATOR);		
			
		/* Load the auxiliary methods */
		require_once JPATH_ADMINISTRATOR . '/components/com_joommark/helpers/database.php';
	}
	
	
	
	function onAfterInitialise(){
		
		$db = JFactory::getDbo();				
		$app = JFactory::getApplication();

        // We store only front-end visits
        if ($app->getName() !== 'site') {	
            return;
        }
		
		// Extract info from BrowserDetection
        $browser_data = new BrowserDetection();
        if (!empty($browser_data)) {
            $this->browser = $browser_data->getBrowser();
			$this->browser_version = $browser_data->getVersion();
			$this->platform = $browser_data->getPlatform();
			$this->is_mobile = $browser_data->isMobile();
			$this->is_robot = $browser_data->isRobot();
			$this->uri = $_SERVER['REQUEST_URI'];	
			$this->ip = $_SERVER['REMOTE_ADDR'];			
        } else {
            $this->browser = JText::_('COM_JOOMMARK_UNKNOW');
            $this->browser_version = JText::_('COM_JOOMMARK_UNKNOW');
            $this->platform = JText::_('COM_JOOMMARK_UNKNOW');
        }

		// We need the referer to track where is the user
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "") {
            $this->referer = $_SERVER['HTTP_REFERER'];			
        } else {
            $this->referer = JText::_('COM_JOOMMARK_UNKNOW');
        }
		
		// Get the user name
		$user = JFactory::getUser()->name;
		
		// Update 'joommark_stats' table
		$query = "INSERT INTO #__joommark_stats (ip, nowpage, lastupdate_time,  current_name)" .
				"VALUES ( '" . $this->ip . "','" . $this->referer . "',NOW(),'" . $user . "') ON DUPLICATE KEY UPDATE nowpage = '" . $this->referer . "', lastupdate_time = NOW(), current_name = '" . $user . "' ";
		$db->setQuery($query);
				
		try
		{
			$db->execute();			
		} catch (Exception $e)
		{
			//dump($e->getMessage(),"exception");
		}
		
		// Update 'joommark_serverstats' table
		$query = "INSERT INTO #__joommark_serverstats (ip, visitdate, visitedpages, browser, os)" .
				"VALUES ( '" . $this->ip . "', NOW(), '" . $this->referer . "', '" . $this->browser . "', '" . $this->platform . "')";
		$db->setQuery($query);
		
		try
		{
			$db->execute();			
		} catch (Exception $e)
		{
			//dump($e->getMessage(),"exception");
		}
		

	}
	
	function onAfterRoute()
	{
			
	}
	
	
		
}