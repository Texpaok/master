<?php
/**
* @ author Astrid Günther
* @ Copyright (c) 2011 - Astrid Günther / Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/
// No direct access
defined('_JEXEC') or die;
 
// Main application object
$app = JFactory::getApplication ();

// Defaults
if (! isset ( $controller_name )) {
	$controller_name = 'flow';
}
if (! isset ( $controller_task )) {
	$controller_task = 'display';
}

$path = JPATH_COMPONENT . '/controllers/' . strtolower ( $controller_name ) . '.php';
if (file_exists ( $path )) {
	require_once $path;
} else {
	$app->enqueueMessage ( JText::_ ( 'No controller file' ), 'error' );
	return false;
}

// Create the controller
$classname = 'JoommarkController' . ucfirst ( $controller_name );
if (class_exists ( $classname )) {
	$controller = new $classname ();
	// Perform the Request task
	$controller->execute ( $controller_task );
	
	// Redirect if set by the controller
	$controller->redirect ();
} else {
	$app->enqueueMessage ( JText::_ ( 'No controller class found' ), 'error' );
	return false;
}
