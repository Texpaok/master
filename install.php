<?php

/**
 * Securitycheck Pro package
 * @ author Jose A. Luque
 * @ Copyright (c) 2011 - Jose A. Luque
 * @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.installer.installer');

/**
 * Script file of Securitycheck Pro component
 */
class com_JoommarkInstallerScript
{

	// Check if we are calling update method. It's used in 'install_message' function
	public $update = false;

	/**
	 * Joomla! pre-flight event
	 * 
	 * @param string $type Installation type (install, update, discover_install)
	 * @param JInstaller $parent Parent object
	 */
	public function preflight($type, $parent)
	{
		// Only allow to install on PHP 5.3.0 or later
		if (!version_compare(PHP_VERSION, '5.3.0', 'ge'))
		{
			Jerror::raiseWarning(null, JText::_('COM_JOOMMARK_ERROR_INSTALLING_PHP_VERSION'));
			return false;
		} else if (version_compare(JVERSION, '3.0.0', 'lt'))
		{
			// Only allow to install on Joomla! 3.0.0 or later, but not in 2.5 branch
			Jerror::raiseWarning(null, JText::_('COM_JOOMMARK_ERROR_INSTALLING_JOOMLA_VERSION'));
			return false;
		}

		// Check if the 'mb_strlen' function is enabled
		if (!function_exists("mb_strlen"))
		{
			Jerror::raiseWarning(null, JText::_('COM_JOOMMARK_ERROR_INSTALLING_FUNCTION_MB_STRLEN'));
			return false;
		}
	}

	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent)
	{
		// General settings
		$status = new JObject();
		$status->modules = array();

		// Array to store module and plugin installation results
		$result = array();
		$indice = 0;

		$installer = new JInstaller();

		$manifest = $parent->get("manifest");
		$parent = $parent->getParent();
		$source = $parent->getPath("source");

		foreach ($manifest->plugins->plugin as $plugin)
		{
			$installer = new JInstaller();
			$attributes = $plugin->attributes();
			$plg = $source . DIRECTORY_SEPARATOR . $attributes['folder'] . DIRECTORY_SEPARATOR . $attributes['plugin'];
			$result[$indice] = $installer->install($plg);
			$indice++;
		}

		$db = JFactory::getDbo();
		$tableExtensions = $db->quoteName("#__extensions");
		$columnElement = $db->quoteName("element");
		$columnType = $db->quoteName("type");
		$columnEnabled = $db->quoteName("enabled");

		// Enable Tracker plugin
		$db->setQuery(
				"UPDATE 
				$tableExtensions
			SET
				$columnEnabled=1
			WHERE
				$columnElement='tracker'
			AND
				$columnType='plugin'"
		);

		$db->execute();
	}

	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent)
	{

		// General settings
		$status = new JObject();
		$status->modules = array();

		// Array to store uninstall results
		$result = array();

		$db = JFactory::getDbo();

		$columnName = $db->quoteName("extension_id");
		$tableExtensions = $db->quoteName("#__extensions");
		$type = $db->quoteName("type");
		$columnElement = $db->quoteName("element");
		$columnType = $db->quoteName("folder");
		$result = '';

		// Uninstall Tracker plugin
		$db->setQuery(
				"SELECT 
				$columnName
			FROM
				$tableExtensions
			WHERE
				$type='plugin'
			AND
				$columnElement='tracker'
			AND
				$columnType='system'"
		);

		$id = $db->loadResult();

		if ($id)
		{
			$installer = new JInstaller();
			$result[1] = $installer->uninstall('plugin', $id, 1);
		}
	}

	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent)
	{
		// This variable is updated.
		$this->update = true;
		$this->install($parent);
	}

	/*
	 * $parent is the class calling this method.
	 * $type is the type of change (install, update or discover_install, not uninstall).
	 * postflight is run after the extension is registered in the database.
	 */

	function postflight($type, $parent)
	{
		// General preferences
		$params ['refresh'] = '4';
	}

}

?>