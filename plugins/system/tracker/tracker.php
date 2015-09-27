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
	
	function onAfterDispatch()
	{
			//$buffer = JFactory::getDocument()->getBuffer('component');
			//$kk = JFactory::getDocument()->addScriptDeclaration(';/* START: Modals scripts */ /* END: Modals scripts */','text/javascript');
			
			//$content = 'alert(\'Hola\')';
			
			//$content = '$(".group2").colorbox({rel:\'group2\', transition:"fade"});';
			//$content = 'jQuery(window).on(\'load\',  function() {';
			//$content = '$(window).load(function(){';
			
			/*$content = '$(document).ready(function(){';			
			$content .= '$("#Joommark_modal").modal(\'show\');';
			$content .= '});';*/
			
			$content = 'window.addEvent("domready", function() {';
			$content .= '$("#Joommark_modal").modal(\'show\');';
			$content .= '});';
			//$content = 'alert("hola")';
			
			/*$content = 'addEvent(document.getElementById(\'Joommark_modal\'), \'mousemove\', function(event) {';
			$content .= '$(\'#Joommark_modal\').modal(\'show\');';
			$content .= '});';*/
			$doc =& JFactory::getDocument();
			$doc->addScriptDeclaration($content);
			//$doc->addScript('/media/com_joommark/javascript/bootstrap-modal.js');

						
			$kk = $doc->getBuffer();
			//dump($kk,"kk");
			
			/*$doc->addScript('modals/jquery.colorbox.js');
			$doc->addScript('modals/script.min.js');*/
			
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
		
		
		$to_replace = '<div class="modal hide fade" id="Joommark_modal">' . PHP_EOL;
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
		$to_replace .= '</div>' . PHP_EOL;
		$to_replace .= '<a href="#Joommark_modal" role="button" class="btn btn-inverse btn-mini" data-toggle="modal">kk</a>' . PHP_EOL;
		
		/*$to_replace .= '<script type="text/javascript">';
		$to_replace .= 'jQuery(window).on(\'load\',  function() {';
		$to_replace .= '$(\'#Joommark_modal\').modal(\'show\');';
		$to_replace .= '});';
		$to_replace .= '</script>';*/
		
		$to_replace .= '</body>' ;

		$html = str_replace("</body>",$to_replace,$html);

		JResponse::setBody($html);
		
		
		
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
		
		$kk = JFactory::getUser();
		
		//dump($kk,"kk");
		
		
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