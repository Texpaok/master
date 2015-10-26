<?php
/**
* @ Copyright (c) 2011 - Jose A. Luque
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// Protect from unauthorized access
defined('_JEXEC') or die();

class JoommarkControllerVisitors extends JoommarkAuxController
{
	public function __construct($config = array()) {
		
		parent::__construct($config);				
		
	}
	
	/* Function to delete joommark_stats entries */
	function delete()
	{
		$model = $this->getModel("visitors");
		$model->delete();
		
		JRequest::setVar( 'view', 'visitors' );
		
		parent::display();
	}
			
}
