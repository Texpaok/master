<?php
/**
* Modelo Logs para el Componente Securitycheckpro
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

// Chequeamos si el archivo está incluído en Joomla!
defined('_JEXEC') or die();
jimport( 'joomla.application.component.model' );
jimport( 'joomla.access.rule' );

class JoommarksModelVisitorsInfo extends JModelList
{


public function __construct($config = array()) {
	
	if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'ip', 'visitdate', 'visitedpages', 'browser', 'os'
            );
        }

    parent::__construct($config);		
}

/***/
protected function populateState($ordering = null, $direction = null) 
{
	// Inicializamos las variables
	$app		= JFactory::getApplication();
	
	$visitors_info_search = $app->getUserStateFromRequest('filter_visitors_info.search', 'filter_visitors_info_search');
	$this->setState('filter_visitors_info.search', $visitors_info_search);
	
	// Let's see if we need to filter data. This happens when a query comes from icon-eye pf visitors view.
	$ip_to_search = $app->getUserState("ip_to_search");
	$this->setState('filter_visitors_info.search', $ip_to_search);
				
	 // List state information.
        parent::populateState('visitdate', 'desc');
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
	$search = $this->state->get('filter_visitors_info.search');
	$search = $db->Quote('%'.$db->escape($search, true).'%');
		
	$query->select('*');
	$query->from('#__joommark_serverstats AS a');
	
	
	$query->where('(a.ip LIKE '.$search.' OR a.visitdate LIKE '.$search.' OR a.visitedpages LIKE '.$search.' OR a.browser LIKE '.$search.' OR a.os LIKE '.$search.')');
	
	// Add the list ordering clause.
    $query->order($db->escape($this->getState('list.ordering', 'visitdate')) . ' ' . $db->escape($this->getState('list.direction', 'desc')));
	
	return $query;
}

/* Function to delete joommark_stats entries */
function delete(){
	
	// Create the JInput object to retrieve form variables
	$jinput = JFactory::getApplication()->input;
	
	// Array of IPs to delete
	$entries_to_delete = $jinput->get('cid',null,'array');
	
	$db = $this->getDbo();
	foreach($entries_to_delete as $id) {
		$sql = "DELETE FROM `#__joommark_serverstats` WHERE id='{$id}'";
		$db->setQuery($sql);
		$db->execute();	
	}
}


}