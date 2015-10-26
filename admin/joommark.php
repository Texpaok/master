<?php
/**
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Load library
require_once(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_joommark'.DIRECTORY_SEPARATOR.'library'.DIRECTORY_SEPARATOR.'loader.php');

// We need to control which controller must be loaded
if ( $controller = JRequest::getWord('controller') ) {
	$path = JPATH_COMPONENT.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$controller.'.php';
	if ( file_exists($path) && ($controller != 'messages') ) {
		require_once $path;	
		// Create the controller
		$classname = 'JoommarkController'.$controller;
		$controller = new $classname( );
		// Perform the Request task
		$controller->execute(JRequest::getCmd('task','display'));
		// Redirect if set by the controller
		$controller->redirect();
	} else {
		$controller = JControllerLegacy::getInstance('Joommark');

		// Perform the Request task
		$input = JFactory::getApplication()->input;
		$controller->execute($input->getCmd('task'));

		// Redirect if set by the controller
		$controller->redirect();
	}
} else {
	$controller = JControllerLegacy::getInstance('Joommark');

	// Perform the Request task
	$input = JFactory::getApplication()->input;
	$controller->execute($input->getCmd('task'));

	// Redirect if set by the controller
	$controller->redirect();	
}

