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

/**
 * General Controller of Joommark component
 *
 * @since  1.0
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
		$this->setRedirect('index.php?option=com_joommark');
	}
}
