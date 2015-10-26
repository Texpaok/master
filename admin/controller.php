<?php
/**
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * General Controller of Joommark component
 *
 */
class JoommarkController extends JControllerLegacy
{
	// Set default view
	protected $default_view = 'Controlpanel';
	 
	public function display($cachable = false, $urlparams = false) {
		parent::display($cachable, $urlparams);
	}
	
	/* Redirects to Control Panel */
	function redireccion_control_panel()
	{
		$this->setRedirect( 'index.php?option=com_joommark' );
	}
}
