<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jommark
 *
 * @copyright   Copyright (C) 2014-2015 Jose A. Luque and Astrid Günther. All rights reserved.
 * @license     GNU General Public License version 2
 */
defined('_JEXEC') or die();

// JLoader::register('clas', JPATH_ADMINISTRATOR . 'path'); ??
jimport('joomla.application.component.modellist');

/**
 * class Joommark Model Messages - Modelo Vulninfo
 *
 * @since  1.0
 */
class JoommarkModelMessages extends JModelList
{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param   type  $config  The table type to instantiate
	 *
	 * @since   1.0
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'published', 'title', 'asset_id'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param   type  $ordering   The table type to instantiate
	 * @param   type  $direction  The table type to instantiate
	 *
	 * @return boolean
	 *
	 * @since   1.0
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Inicializamos las variables
		$app = JFactory::getApplication();

		$messages_search = $app->getUserStateFromRequest('filter_messages.search', 'filter_messages_search');
		$this->setState('filter_messages.search', $messages_search);


		// List state information.
		parent::populateState('title', 'desc');
	}

	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return  JDatabaseQuery   A JDatabaseQuery object to retrieve the data set. Return all data filtered (if there is a search term)
	 */
	public function getListQuery()
	{
		$jfilter = JFilterInput::getInstance();

		$params = JComponentHelper::getComponent('com_joommark')->params;

		$query = parent::getListQuery();

		$list = $this->getState('filter.list');

		// Meh, someone tries to trick us
		if (empty($list->id))
		{
			$query->where('1!=1');
		}
		// Creamos el nuevo objeto query
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Sanitizamos la entrada
		$search = $this->state->get('filter_messages.search');
		$search = $db->Quote('%' . $db->escape($search, true) . '%');

		$query->select('a.*');
		$query->from('#__joommark_messages AS a');

		// $query->where('(a.title LIKE ' . $search . ' OR a.asset_id LIKE ' . $search . ')');
		// $query->join('LEFT', $db->quoteName('#__viewlevels', 'vl') . ' ON (' . $db->quoteName('a.assed_id') . ' = ' . $db->quoteName('vl.id') . ')');

		// Add the list ordering clause.
		$query->order($db->escape($this->getState('list.ordering', 'title')) . ' ' . $db->escape($this->getState('list.direction', 'desc')));

		return $query;
	}
}
