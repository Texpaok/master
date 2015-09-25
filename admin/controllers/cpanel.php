<?php
/**
* Securitycheck Pro Cpanel Controller
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

// Load framework base classes
jimport('joomla.application.component.controller');

/**
 * The Control Panel controller class
 *
 */
class JoommarksControllerCpanel extends JControllerLegacy
{
	public function  __construct() {
		parent::__construct();
		
	}

	/**
	 * Displays the Control Panel 
	 */
	public function display($cachable = false, $urlparams = Array())
	{
		JRequest::setVar( 'view', 'cpanel' );
		
		// Display the panel
		parent::display();
	}

	
}