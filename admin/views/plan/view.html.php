<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jommark
 *
 * @copyright   Copyright (C) 2014-2015 Jose A. Luque and Astrid Günther. All rights reserved.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die('Restricted access');

/**
 * class Joommark View Plan
 *
 * @since  1.0
 */
class JoommarkViewPlan extends JViewLegacy
{
	/**
	 * Methode display
	 *
	 * @param   tpl  $tpl  The layout
	 *
	 * @access public
	 * @return Object The response object to be encoded for JS app
	 */
	public function display($tpl = null)
	{
		// Get the Data
		$form = $this->get('Form');
		$item = $this->get('Item');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}
		// Assign the Data
		$this->form = $form;
		$this->item = $item;

		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);
	}

	/**
	 * Setting the toolbar
	 *
	 * @return Object The response object to be encoded for JS app
	 */
	protected function addToolBar()
	{
		$isNew = $this->item->id == 0;

		JToolbarHelper::apply('plan.apply');
		JToolBarHelper::save('plan.save');
		JToolbarHelper::save2new('plan.save2new');
		JToolBarHelper::cancel('plan.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
}
