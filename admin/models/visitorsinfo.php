<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_advent
 *
 * @copyright   Copyright (C) 2014-2015 Jose A. Luque and Astrid Günther. All rights reserved.
 * @license     GNU General Public License version 2
 */
defined('_JEXEC') or die();
jimport('joomla.application.component.model');
jimport('joomla.access.rule');

/**
 * Joommark Model VisitorsInfo
 *
 * @since  1.0
 */
class JoommarkModelVisitorsInfo extends JModelList
{
	/**
	 * Method __costruct ovverride JModelList
	 *
	 * @param   array  $config  the data
	 *
	 * @since   1.0
	 */
	public function __construct($config = array())
	{
		if ( empty ( $config['filter_fields'] ) )
		{
			$config['filter_fields'] = array(
				'ip', 'visitdate', 'visitedpage', 'browser', 'os'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method populateState
	 *
	 * @param   boolean  $ordering   the data
	 * @param   boolean  $direction  the data
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Inicializamos las variables
		$app = JFactory::getApplication();

		$visitors_info_search = $app->getUserStateFromRequest('filter_visitors_info.search', 'filter_visitors_info_search');
		$this->setState('filter_visitors_info.search', $visitors_info_search);

		// Let's see if we need to filter data. This happens when a query comes from icon-eye of visitors view.
		$ip_to_search = $app->getUserState("ip_to_search");

		if ( !empty ( $ip_to_search ) )
		{
			$this->setState('filter_visitors_info.search', $ip_to_search);
		}

		// List state information.
		parent::populateState('visitdate', 'desc');
	}

	/**
	 * Method getListQuery Return all data filtered (if there is a search term)
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
	public function getListQuery()
	{
		// Creamos el nuevo objeto query
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Sanitizamos la entrada
		$search = $this->state->get('filter_visitors_info.search');
		$search = $db->Quote('%' . $db->escape($search, true) . '%');

		$query->select('*');
		$query->from('#__joommark_serverstats AS a');
		$query->where('(a.session_id LIKE ' . $search . ' OR a.ip LIKE ' . $search . ' OR a.visitdate LIKE ' . $search . ' OR a.visitedpage LIKE ' . $search . ' OR a.browser LIKE ' . $search . ' OR a.os LIKE ' . $search . ')');

		// Add the list ordering clause.
		$query->order($db->escape($this->getState('list.ordering', 'visitdate')) . ' ' . $db->escape($this->getState('list.direction', 'desc')));

		return $query;
	}

	/**
	 * Method delete() - Function to delete joommark_stats entries
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
	function delete()
	{
		// Create the JInput object to retrieve form variables
		$jinput = JFactory::getApplication()->input;

		// Array of session_id to delete
		$visit_timestamp_to_delete = $jinput->get('visit_timestamp_array', null, 'array');

		// If we have valid values, let's do the job
		if ( !empty($visit_timestamp_to_delete) )
		{
			$db = $this->getDbo();

			foreach ($visit_timestamp_to_delete as $visit_timestamp)
			{
				$sql = "DELETE FROM `#__joommark_serverstats` WHERE visit_timestamp='{$visit_timestamp}'";
				$db->setQuery($sql);
				$db->execute();
			}
		}
		else
		{
			// There is nothing to delete!
			JFactory::getApplication()->enqueueMessage(JText::_('COM_JOOMMARK_SELECT_ONE'), 'warning');
		}
	}
}
