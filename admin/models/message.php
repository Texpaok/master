<?php
/**
 * @package     Responsive Scroll Triggered Box
 * @subpackage  com_rstbox
 *
 * @copyright   Copyright (C) 2014 Tassos Marinos - http://www.tassos.gr
 * @license     GNU General Public License version 2 or later; see http://www.tassos.gr/license
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * Item Model
 */
class JoommarkModelMessage extends JModelAdmin
{
    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param       type    The table type to instantiate
     * @param       string  A prefix for the table class name. Optional.
     * @param       array   Configuration array for model. Optional.
     * @return      JTable  A database object
     * @since       2.5
     */
    public function getTable($type = 'Message', $prefix = 'JoommarkTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param       array   $data           Data for the form.
     * @param       boolean $loadData       True if the form is to load its own data (default case), false if not.
     * @return      mixed   A JForm object on success, false on failure
     * @since       2.5
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
     * @return      mixed   The data for the form.
     * @since       2.5
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_joommark.edit.message.data', array());

        if (empty($data))
        {
            $data = $this->getItem();
			$isNew = (!$data->id) ? true : false;

            if (!$isNew) {
                /* Fetch Menu Items */
                if ($data->id) {
					// Extract the array of menuitems, previously json_encoded
					$menus = array();

					if (!empty($data->menuitems))
					{
						$menus = json_decode($data->menuitems);
					}


					 /* Check if box is assigned to all pages */
					if (!empty($menus) && in_array("-1", $menus)) {
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
     * @param   array  The form data.
     *
     * @return  boolean  True on success.
     * @since   1.6
     */

    public function save($data)
    {
		// Check if the menú must be showed to all pages
		$AllMenus = ($data["allmenus"] == "1") ? true : false;

		if ( $AllMenus ) {
			$data["menuitems"] = array();
			array_push($data["menuitems"],"-1");
		}

		// Json_encode menuitems
		$data["menuitems"] = json_encode($data["menuitems"]);


		 if (parent::save($data))
        {
            return true;
        }
	}
	
	/* Function to get total visited pages by day */
	public function total_visited_pages() {
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query 
			->select('COUNT(*)')
			->from($db->quoteName('#__joommark_serverstats'))
			->where('DATE(NOW()) = DATE(`visitdate`)');				
		$db->setQuery($query);
		$res = $db->loadResult();
		
		return $res;		
	
	}
	
	/* Function to get total visitors by day */
	public function total_visitors() {
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query 
			->select('COUNT(DISTINCT session_id)')
			->from($db->quoteName('#__joommark_serverstats'));				
		$db->setQuery($query);
		$res = $db->loadResult();
		
		return $res;		
	
	}



}

