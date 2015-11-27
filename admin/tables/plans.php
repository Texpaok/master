<?php
/**
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/
// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Joommark Table class
 */
class JoommarkTablePlans extends JTable
{
	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  &$db  A database connector object
	 */
	function __construct(&$db)
	{
		parent::__construct('#__joommark_plansstats', 'id', $db);
	}
}
