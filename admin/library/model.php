<?php
/**
* @version		1.5.0
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// No Permission
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

if(!class_exists('JoomlaCompatModel')) {
	if(interface_exists('JModel')) {
		abstract class JoomlaCompatModel extends JModelLegacy {}
	} else {
		class JoomlaCompatModel extends JModel {}
	}
}

class JoommarkModel extends JoomlaCompatModel
{


function __construct()
{
	parent::__construct();

	global $mainframe, $option;
		
	$mainframe = JFactory::getApplication();
 
	// Obtenemos las variables de paginación de la petición
	$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
	
	// En el caso de que los límites hayan cambiado, los volvemos a ajustar
	$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
	
	$this->setState('limit', $limit);
	$this->setState('limitstart', $limitstart);	
	
}


}