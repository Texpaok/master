
<?php
/**
* Modelo Logs para el Componente Securitycheckpro
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

// Chequeamos si el archivo est includo en Joomla!
defined('_JEXEC') or die();
jimport('joomla.application.component.modellist');

/**
* Modelo Vulninfo
*/
class JoommarkModelMessages extends JModelList
{


public function __construct($config = array()) {
	
	if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'published', 'title', 'accesslevel'
            );
        }

    parent::__construct($config);		
}

/***/
protected function populateState($ordering = null, $direction = null) 
{
	// Inicializamos las variables
	$app		= JFactory::getApplication();
	
	$messages_search = $app->getUserStateFromRequest('filter_messages.search', 'filter_messages_search');
	$this->setState('filter_messages.search', $messages_search);
	
		
	 // List state information.
        parent::populateState('title', 'desc');
}


/*
* Return all data filtered (if there is a search term)
*/
public function getListQuery()
{
	// Creamos el nuevo objeto query
	$db = $this->getDbo();
	$query = $db->getQuery(true);
	
	// Sanitizamos la entrada
	$search = $this->state->get('filter_messages.search');
	$search = $db->Quote('%'.$db->escape($search, true).'%');
		
	$query->select('a.*, vl.title as accessleveltitle');
	$query->from('#__joommark_messages AS a');
	
	
	$query->where('(a.title LIKE '.$search.' OR a.accesslevel LIKE '.$search.')');
	$query->join('LEFT', $db->quoteName('#__viewlevels', 'vl') . ' ON (' . $db->quoteName('a.accesslevel') . ' = ' . $db->quoteName('vl.id') . ')');
	
	// Add the list ordering clause.
    $query->order($db->escape($this->getState('list.ordering', 'title')) . ' ' . $db->escape($this->getState('list.direction', 'desc')));
	
	return $query;
}



}