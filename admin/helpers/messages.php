<?php 

/*
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

abstract class MessagesHelper {

	public static function getMessageInfo($menuitemid, $userAccessLevels) {
		
		// Message to be shown: title and message
		$data_to_show = array(
                'title', 'message'
            );
		
		$user = JFactory::getUser();
       
        $accesslevel = implode(",", $userAccessLevels);

		// Select messages published, with an accesslevel egual or higher than the user and/or asigned to all pages
        $query = "select a.* from #__joommark_messages a ";
        $query .= "where a.published = 1 ";
        $query .= "AND ((a.accesslevel IN ($accesslevel)) OR (a.accesslevel IS NULL))";
		$query .= "AND ( (a.menuitems LIKE '%$menuitemid%') OR (a.menuitems LIKE '%-1%') )";
        		
		$db = JFactory::getDBO();
        $db->setQuery($query);
        $messages = $db->loadObjectList();
				
        foreach ($messages as $message) {
			/*$message_items_id = json_decode($message->menuid,true);
			if ( is_array($message_items_id) ) {			
				if ( !(array_search($menuitemid,$message_items_id) === false) ) {
					$message_to_show = $message->message;
				}
			}*/
			
			$data_to_show['title'] = $message->title;
			$data_to_show['message'] = $message->message;
        }
		
		return $data_to_show;        
    }
}