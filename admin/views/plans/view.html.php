<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jommark
 *
 * @copyright   Copyright (C) 2014-2015 Jose A. Luque and Astrid Günther. All rights reserved.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die();

/**
 * class Joommark View Plans
 *
 * @since  1.0
 */
class JoommarkViewPlans extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	/**
	 * Methode display
	 *
	 * @param   tpl  $tpl  The layout
	 *
	 * @return Object
	 */
	function display($tpl = null)
	{
		// Model data

		$this->state = $this->get('State');
		$this->items = $this->get('Items');

		$this->pagination = $this->get('Pagination');
		$filter_plans_search = $this->state->get('filter_plans.search');

		$listDirn = $this->state->get('list.direction');
		$listOrder = $this->state->get('list.ordering');

		// Set the toolbar
		$this->addToolBar();

		parent::display($tpl);
	}

	/**
	 * Setting the toolbar
	 *
	 * @return Object
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('Joommark') . ' | ' . JText::_('COM_JOOMMARK_VISITORS_INFO'), 'joommark');
		JToolBarHelper::custom('redireccion_control_panel', 'arrow-left', 'arrow-left', 'COM_JOOMMARK_REDIRECT_CONTROL_PANEL');
		JToolBarHelper::addNew('plan.add');
		JToolBarHelper::editList('plan.edit');
		JToolBarHelper::deleteList('', 'plans.delete');
		JToolbarHelper::publish('plans.publish', 'JTOOLBAR_PUBLISH', true);
		JToolbarHelper::unpublish('plans.unpublish', 'JTOOLBAR_UNPUBLISH', true);
	}
}
