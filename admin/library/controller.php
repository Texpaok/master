<?php
/**
* @ author Jose A. Luque
* @ Copyright (c) 2013 - Jose A. Luque
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// No Permission
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

if(!class_exists('JoomlaCompatController')) {
	if(interface_exists('JController')) {
		abstract class JoomlaCompatController extends JControllerLegacy {}
	} else {
		class JoomlaCompatController extends JController {}
	}
}

class JoommarkController extends JoomlaCompatController {
	
function __construct()
{
parent::__construct();
}

/* Redirecciona las peticiones al Panel de Control */
function redireccion_control_panel()
{
	$this->setRedirect( 'index.php?option=com_joommark' );
}


}