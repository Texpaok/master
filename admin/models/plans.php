<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jommark
 *
 * @copyright   Copyright (C) 2014-2015 Jose A. Luque and Astrid Günther. All rights reserved.
 * @license     GNU General Public License version 2
 */
defined('_JEXEC') or die();
/**
 * class Joommark Model Plans
 *
 * @since  1.0
 */
class JoommarkModelPlans extends JModelList
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
				'id', 'published', 'title'
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

		$plans_search = $app->getUserStateFromRequest('filter_plans.search', 'filter_plans_search');
		$this->setState('filter_plans.search', $plans_search);

		// List state information.
		parent::populateState('title', 'desc');
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @return boolean
	 *
	 * @since   1.0
	 */
	public function getListQuery()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$search = $this->state->get('filter_plans.search');
		$search = $db->Quote('%' . $db->escape($search, true) . '%');

		$query->select('*');
		$query->from('#__joommark_plansstats AS a');

		return $query;
	}
}
