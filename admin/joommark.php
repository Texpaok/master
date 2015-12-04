<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_joommark
 * @ author Jose A. Luque
 *
 * @copyright   Copyright (C) 2014-2015 Jose A. Luque and Astrid Günther. All rights reserved.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die('Restricted access');

// Load library
require_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_joommark' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'loader.php';

JHtml::script('com_joommark/JoommarkForm.admin.js', false, true);
JHtml::stylesheet('com_joommark/JoommarkStyles.admin.css', array(), true);

// We need to control which controller must be loaded
if ($controller = JRequest::getWord('controller'))
{
	$path = JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $controller . '.php';

	if (file_exists($path) && ($controller != 'messages') && ($controller != 'plans'))
	{
		require_once $path;

		// Create the controller
		$classname = 'JoommarkController' . $controller;
		$controller = new $classname;

		// Perform the Request task
		$controller->execute(JRequest::getCmd('task', 'display'));

		// Redirect if set by the controller
		$controller->redirect();
	}
	else
	{
		$controller = JControllerLegacy::getInstance('Joommark');

		// Perform the Request task
		$input = JFactory::getApplication()->input;
		$controller->execute($input->getCmd('task'));

		// Redirect if set by the controller
		$controller->redirect();
	}
}
else
{
	$controller = JControllerLegacy::getInstance('Joommark');

	// Perform the Request task
	$input = JFactory::getApplication()->input;
	$controller->execute($input->getCmd('task'));

	// Redirect if set by the controller
	$controller->redirect();
}

