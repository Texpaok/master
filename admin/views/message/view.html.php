<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jommark
 *
 * @copyright   Copyright (C) 2014-2015 Jose A. Luque and Astrid Günther. All rights reserved.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die('Restricted access');

// Import Joomla view library
jimport('joomla.application.component.view');
/**
 * class Joommark View Message
 *
 * @since  1.0
 */
class JoommarkViewMessage extends JViewLegacy
{
	/**
	 * Methode display
	 *
	 * @param   tpl  $tpl  The layout
	 *
	 * @return Object
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
	 * @return Object
	 */
	protected function addToolBar()
	{
		$isNew = $this->item->id == 0;

		if ($isNew)
		{
			JToolBarHelper::title(JText::_('Joommark') . ' | ' . JText::_('COM_JOOMMARK_MESSAGES_NEW'), 'joommark');
		}
		else
		{
			JToolBarHelper::title(JText::_('Joommark') . ' | ' . JText::_('COM_JOOMMARK_MESSAGES_EDIT'), 'joommark');
		}

		JToolbarHelper::apply('message.apply');
		JToolBarHelper::save('message.save');
		JToolbarHelper::save2new('message.save2new');
		JToolBarHelper::cancel('message.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
}
