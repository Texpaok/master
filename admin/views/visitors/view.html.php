<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jommark
 *
 * @copyright   Copyright (C) 2014-2015 Jose A. Luque and Astrid Günther. All rights reserved.
 * @license     GNU General Public License version 2
 */
defined('_JEXEC') or die();
jimport('joomla.application.component.view');
jimport('joomla.plugin.helper');
/**
 * class Joommark View Visitors Info
 *
 * @since  1.0
 */
class JoommarkViewVisitors extends JViewLegacy
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
		JToolBarHelper::title(JText::_('Joommark') . ' | ' . JText::_('COM_JOOMMARK_VISITORS_INFO'), 'joommark');
		JToolBarHelper::custom('redireccion_control_panel', 'arrow-left', 'arrow-left', 'COM_JOOMMARK_REDIRECT_CONTROL_PANEL');
		JToolBarHelper::custom('delete', 'delete', 'delete', 'COM_JOOMMARK_DELETE');

		// Model data
		$this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$filter_search = $this->state->get('filter_visitors.search');

		$listDirn = $this->state->get('list.direction');
		$listOrder = $this->state->get('list.ordering');
		parent::display($tpl);
	}
}
