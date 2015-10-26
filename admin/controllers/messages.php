<?php
/**
* @ Copyright (c) 2011 - Jose A. Luque
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// Protect from unauthorized access
defined('_JEXEC') or die();

class JoommarkControllerMessages extends JControllerAdmin
{
	
	 public function getModel($name = 'Message', $prefix = 'JoommarkModel', $config = array('ignore_request' => true)) 
    {
        $model = parent::getModel($name, $prefix, $config);
        return $model;
    }
		
}
