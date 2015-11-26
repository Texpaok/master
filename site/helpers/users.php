<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_joommark
 *
 * @copyright   Copyright (C) 2014-2015 Astrid Günther and Jose A. Luque. All rights reserved.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die ();

/**
 * Joommark Helper class
 *
 * @since  1.0
 */
class JoommarkHelpersUsers
{
	/**
	 * Return current user session table object with singleton
	 *
	 * @access private
	 * @static
	 *
	 * @return Object
	 */
	public static function getSessionTable()
	{
		// Lazy loading user session
		static $userSessionTable;

		if (!is_object($userSessionTable))
		{
			$userSessionTable = JTable::getInstance('session');
			$userSessionTable->load(session_id());
		}

		return $userSessionTable;
	}
}
