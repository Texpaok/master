<?php
/**
* @ Copyright (c) 2011 - Jose A. Luque
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// Protect from unauthorized access
defined('_JEXEC') or die();

class JoommarksControllerMessages extends JoommarkController
{
	public function __construct($config = array()) {
		
		parent::__construct($config);
		
		
	}
	
	/* Function to delete joommark_stats entries */
	function delete()
	{
		$model = $this->getModel("messages");
		$model->delete();
		
		JRequest::setVar( 'view', 'messages' );
		
		parent::display();
	}
				
}
