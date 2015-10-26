<?php
/**
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

// Load framework base classes
jimport('joomla.application.component.view');


class JoommarkViewControlPanel extends JViewLegacy
{
	function display($tpl = NULL)
	{
		JToolBarHelper::title( JText::_( 'Joommark' ).' | ' .JText::_('COM_JOOMMARK_CONTROLPANEL'), 'joommark' );
							
		parent::display();
	}
}