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

/**
* Modelo Vulninfo
*/
class JoommarksModelVisitors extends JModelList
{


public function __construct($config = array()) {
	
	if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'ip', 'nowpage', 'lastupdate_time', 'current_name'
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
        parent::populateState('ip', 'desc');
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
	
	
	$query->where('(a.ip LIKE '.$search.' OR a.nowpage LIKE '.$search.' OR a.lastupdate_time LIKE '.$search.' OR a.current_name LIKE '.$search.')');
	
	// Add the list ordering clause.
    $query->order($db->escape($this->getState('list.ordering', 'ip')) . ' ' . $db->escape($this->getState('list.direction', 'desc')));
	
	return $query;
}

/* Function to delete joommark_stats entries */
function delete(){
	/*$uids = JRequest::getVar('cid', 0, '', 'array');
	
	JArrayHelper::toInteger($uids, array());
	
	dump($uids,"uids");*/
	
	// Create the JInput object to retrieve form variables
	$jinput = JFactory::getApplication()->input;
	
	// Array of IPs to delete
	$ips_to_delete = $jinput->get('ip_array',null,'array');
		
	$db = $this->getDbo();
	foreach($ips_to_delete as $ip) {
		$sql = "DELETE FROM `#__joommark_stats` WHERE ip='{$ip}'";
		$db->setQuery($sql);
		$db->execute();	
	}
}


}