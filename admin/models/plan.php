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
 * class Joommark Model Plan
 *
 * @since  1.0
 */
class JoommarkModelPlan extends JModelAdmin
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
	public function getTable($type = 'Plans', $prefix = 'JoommarkTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed   A JForm object on success, false on failure
	 *
	 * @since   1.0
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_joommark.plan', 'plan', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return      mixed   The data for the form.
	 *
	 * @since       2.5
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
	$data = JFactory::getApplication()->getUserState('com_joommark.edit.plan.data', array());

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

					if (!empty($data->menuitems))
					{
						$menus = json_decode($data->menuitems);
					}

					/* Check if box is assigned to all pages */
					if (!empty($menus) && in_array("-1", $menus))
					{
						$data->allmenus = true;
					}

					// Assign menuitems
					$data->menuitems = $menus;
				}
			}
		}

		return $data;
	}

	/**
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   1.0
	 */
	public function save($data)
	{
		// Check if the menú must be showed to all pages
		$AllMenus = ($data["allmenus"] == "1") ? true : false;

		if ( $AllMenus )
		{
			$data["menuitems"] = array();
			array_push($data["menuitems"], "-1");
		}

		// Json_encode menuitems
		$data["menuitems"] = json_encode($data["menuitems"]);

		if (parent::save($data))
		{
			return true;
		}
	}
}
