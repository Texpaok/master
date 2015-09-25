<?php
/**
* @ Copyright (c) 2011 - Jose A. Luque
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// Protect from unauthorized access
defined('_JEXEC') or die();
jimport( 'joomla.application.component.model' );

class JoommarksControllerVisitorsInfo extends JoommarkController
{
	public function __construct($config = array()) {
		
		// Let's see if the query comes from visitors view. In this case, there is a variable set at the user scope.
		$input		= JFactory::getApplication()->input;
		$ip_to_search = $input->get("filter",null);	
		$app = JFactory::getApplication();		
		$app->setUserState('ip_to_search', $ip_to_search);
		
		
		parent::__construct($config);
		
		
	}
	
	/* Function to delete joommark_stats entries */
	function delete()
	{
		$model = $this->getModel("visitorsinfo");
		$model->delete();
		
		JRequest::setVar( 'view', 'visitorsinfo' );
		
		parent::display();
	}
			
}
