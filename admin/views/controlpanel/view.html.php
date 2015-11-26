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

		// Get an instance of the Message model
		$model = JmodelLegacy::getInstance("message", "JoommarkModel");

		// Get the data
		$visited_pages = $model->total_visited_pages();
		$total_visitors = $model->total_visitors();

		// Put them available
		$this->assignRef('visited_pages', $visited_pages);
		$this->assignRef('total_visitors', $total_visitors);

		parent::display();
	}
}
