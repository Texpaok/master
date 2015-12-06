<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jommark
 *
 * @copyright   Copyright (C) 2014-2015 Jose A. Luque and Astrid Günther. All rights reserved.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die('Restricted access');

// Import Joomla modelform library
jimport('joomla.application.component.modeladmin');
/**
 * class Joomark Model Message (Item Model)
 *
 * @since  1.0
 */

class JoommarkModelMessage extends JModelAdmin
{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param   type    $type    The table type to instantiate
	 * @param   string  $prefix  A prefix for the table class name. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return   JTable  A database object
	 *
	 * @since   1.0
	 */
	public function getTable($type = 'Message', $prefix = 'JoommarkTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return      mixed   A JForm object on success, false on failure
	 *
	 * @since   1.0
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_joommark.message', 'message', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return   mixed  The data for the form.
	 *
	 * @since   1.0
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_joommark.edit.message.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
			$isNew = (!$data->id) ? true : false;

			if (!$isNew)
			{
				/* Fetch Menu Items */
				if ($data->id)
				{
					// Extract the array of menuitems, previously json_encoded
					$menus = array();

					if (!empty($data->menuitems_message))
					{
						$menus = json_decode($data->menuitems_message);
					}

					/* Check if box is assigned to all pages */
					if (is_array($menus) && !empty($menus) && in_array("-1", $menus))
					{
						$data->allmenus = true;
					}
					else
					{
						//JFactory::getApplication()->enqueueMessage(JText::_('COM_JOOMMARK_MESSAGE_LOADFORMDATA_NOARRAY'), 'message');
					}

					// Assign menuitems
					$data->menuitems_message = $menus;
				}
			}
		}

		return $data;
	}

	/**
	 * Method to save the form data.
	 *
	 * @param   array  $data  Data for the form.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   1.0
	 */
	public function save($data)
	{
		// Check if the menú must be showed to all pages
		$AllMenus = ($data["allmenus"] == "1") ? true : false;

		if ($AllMenus)
		{
			$data["menuitems_message"] = array();
			array_push($data["menuitems_message"], "-1");
		}

		// Json_encode menuitems
		$data["menuitems_message"] = json_encode($data["menuitems_message"]);

		if (parent::save($data))
		{
			return true;
		}
	}

	/**
	 * Function to get total visited pages by day.
	 *
	 * @return   Array  Visited pages
	 *
	 * @since   1.0
	 */
	public function total_visited_pages()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query
				->select('COUNT(DISTINCT visitedpage)')
				->from($db->quoteName('#__joommark_serverstats'))
				->where('DATE(NOW()) = DATE(`visitdate`)');
		$db->setQuery($query);
		$res = $db->loadResult();

		return $res;
	}

	/**
	 * unction to get total visitors by day.
	 *
	 * @return   Array  Visited pages
	 *
	 * @since   1.0
	 */
	public function total_visitors()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query
				->select('COUNT(DISTINCT customer_name)')
				->from($db->quoteName('#__joommark_serverstats'))
				->where('DATE(NOW()) = DATE(`visitdate`)');
		$db->setQuery($query);
		$res = $db->loadResult();

		return $res;
	}
}
