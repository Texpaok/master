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
 * class Joommark Tabele Plans
 *
 * @since  1.0
 */
class JoommarkTablePlans extends JTable
{
	/**
	 * Object constructor
	 *
	 * @param   JDatabaseDriver  $db  JDatabaseDriver object.
	 *
	 * @since   1.0
	 */
	function __construct($db)
	{
		parent::__construct('#__joommark_plansstats', 'id', $db);
	}

	/**
	 * Method to return the name
	 *
	 * @return  string  The string to use as the title in the asset table.
	 *
	 * @since   1.0
	 */
	protected function _getAssetName()
	{
		$k = $this->_tbl_key;

		return 'com_joommark.plan.' . (int) $this->$k;
	}

	/**
	 * Method to return the title to use for the asset table.  In
	 * tracking the assets a title is kept for each asset so that there is some
	 * context available in a unified access manager.  Usually this would just
	 * return $this->title or $this->name or whatever is being used for the
	 * primary name of the row. If this method is not overridden, the asset name is used.
	 *
	 * @return  string  The string to use as the title in the asset table.
	 *
	 * @link    https://docs.joomla.org/JTable/getAssetTitle
	 * @since   1.0
	 */
	protected function _getAssetTitle()
	{
		return $this->name;
	}

	/**
	 * Method to get the parent asset under which to register this one.
	 * By default, all assets are registered to the ROOT node with ID,
	 * which will default to 1 if none exists.
	 * The extended class can define a table and id to lookup.  If the
	 * asset does not exist it will be created.
	 *
	 * @return  integer
	 *
	 * @since   1.0
	 */
	protected function _getAssetParentId()
	{
		$assetParent = JTable::getInstance('asset');
		$assetParentId = $assetParent->getRootId();

		if (($this->catid) && !empty($this->catid))
		{
			$assetParent->loadByName('com_joommark.category.' . (int) $this->catid);
		}
		else
		{
			$assetParent->loadByName('com_joommark');
		}

		if ($assetParent->id)
		{
			$assetParentId = $assetParent->id;
		}

		return $assetParentId;
	}

	/**
	 * Method to load a row from the database by primary key and bind the fields
	 * to the JTable instance properties.
	 *
	 * @param   mixed    $array   An optional primary key value to load the row by, or an array of fields to match.  If not
	 *                            set the instance property value is used.
	 * @param   boolean  $ignore  True to reset the default values before loading the new row.
	 *
	 * @return  boolean  True if successful. False if row not found.
	 *
	 * @link    https://docs.joomla.org/JTable/load
	 * @since   1.0
	 * @throws  InvalidArgumentException
	 * @throws  RuntimeException
	 * @throws  UnexpectedValueException
	 */
	public function bind($array, $ignore = '')
	{
		if (isset($array['params']) && is_array($array['params']))
		{
			$parameter = new JRegistry;
			$parameter->loadArray($array['params']);
			$array['params'] = (string) $parameter;
		}

		if (isset($array['rules']) && is_array($array['rules']))
		{
			$rules = new JAccessRules($array['rules']);
			$this->setRules($rules);
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * Method to load a row from the database by primary key and bind the fields
	 * to the JTable instance properties.
	 *
	 * @param   mixed    $pk     An optional primary key value to load the row by, or an array of fields to match.  If not
	 *                           set the instance property value is used.
	 * @param   boolean  $reset  True to reset the default values before loading the new row.
	 *
	 * @return  boolean  True if successful. False if row not found.
	 *
	 * @link    https://docs.joomla.org/JTable/load
	 * @since   1.0
	 * @throws  InvalidArgumentException
	 * @throws  RuntimeException
	 * @throws  UnexpectedValueException
	 */
	public function load($pk = null, $reset = true)
	{
		if (parent::load($pk, $reset))
		{
			$params = new JRegistry;

			if (isset($this->params))
			{
				$params->loadString($this->params, 'JSON');
			}

			$this->params = $params;

			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param   mixed    $pks     An optional array of primary key values to update.
	 *                            If not set the instance property value is used.
	 * @param   integer  $state   The publishing state. eg. [0 = unpublished, 1 = published]
	 * @param   integer  $userId  The user id of the user performing the operation.
	 *
	 * @return  boolean  True on success; false if $pks is empty.
	 *
	 * @link    https://docs.joomla.org/JTable/publish
	 * @since   1.0
	 */
	public function publish($pks = null, $state = 1, $userId = 0)
	{
		$k = $this->_tbl_key;

		JArrayHelper::toInteger($pks);
		$state = (int) $state;

		if (empty($pks))
		{
			if ($this->$k)
			{
				$pks = array($this->$k);
			}
			else
			{
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));

				return false;
			}
		}

		$where = $k . '=' . implode(' OR ' . $k . '=', $pks);

		$query = $this->_db->getQuery(true)
			->update($this->_db->quoteName($this->_tbl))
			->set($this->_db->quoteName('state') . ' = ' . (int) $state)
			->where($where);
		$this->_db->setQuery($query);

		try
		{
			$this->_db->execute();
		}
		catch (RuntimeException $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		if (in_array($this->$k, $pks))
		{
			$this->state = $state;
		}

		$this->setError('');

		return true;
	}
}
