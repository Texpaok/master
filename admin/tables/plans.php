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
class JoommarkTablePlans extends JoommarkAuxJoommarktable
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
}
