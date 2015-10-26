
<?php
/**
* Modelo Logs para el Componente Securitycheckpro
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

// Chequeamos si el archivo est includo en Joomla!
defined('_JEXEC') or die();
jimport( 'joomla.application.component.model' );

/**
* Modelo Vulninfo
*/
class JoommarkModelVisitors extends JModelList
{


public function __construct($config = array()) {
	
	if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'session_id_person', 'nowpage', 'lastupdate_time', 'current_name'
            );
        }

    parent::__construct($config);		
}

/***/
protected function populateState($ordering = null, $direction = null) 
{
	// Inicializamos las variables
	$app		= JFactory::getApplication();
	
	$visitors_search = $app->getUserStateFromRequest('filter_visitors.search', 'filter_visitors_search');
	$this->setState('filter_visitors.search', $visitors_search);
	
		
	 // List state information.
        parent::populateState('session_id_person', 'desc');
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
	$search = $this->state->get('filter_visitors.search');
	$search = $db->Quote('%'.$db->escape($search, true).'%');
		
	$query->select('*');
	$query->from('#__joommark_stats AS a');
	
	
	$query->where('(a.session_id_person LIKE '.$search.' OR a.nowpage LIKE '.$search.' OR a.lastupdate_time LIKE '.$search.' OR a.current_name LIKE '.$search.')');
	
	// Add the list ordering clause.
    $query->order($db->escape($this->getState('list.ordering', 'session_id_person')) . ' ' . $db->escape($this->getState('list.direction', 'desc')));
	
	return $query;
}

/* Function to delete joommark_stats entries */
function delete(){
		
	// Create the JInput object to retrieve form variables
	$jinput = JFactory::getApplication()->input;
	
	// Array of session_id_persons to delete
	$session_id_persons_to_delete = $jinput->get('session_id_person_array',null,'array');
		
	$db = $this->getDbo();
	foreach($session_id_persons_to_delete as $session_id_person) {
		$sql = "DELETE FROM `#__joommark_stats` WHERE session_id_person='{$session_id_person}'";
		$db->setQuery($sql);
		$db->execute();	
	}
}


}