<?php 

/*
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

abstract class MessagesHelper {

	public static function getMessageInfo($menuitemid, $userAccessLevels) {
		$message_to_show = "";
        $user = JFactory::getUser();
       
        $accesslevel = implode(",", $userAccessLevels);

        $query = "select a.* from #__joommark_messages a ";
        $query .= "where a.published = 1 ";
        $query .= "AND ((a.accesslevel IN ($accesslevel)) OR (a.accesslevel IS NULL))";
        		
		$db = JFactory::getDBO();
        $db->setQuery($query);
        $messages = $db->loadObjectList();

        foreach ($messages as $message) {
			$message_items_id = json_decode($message->menuid,true);
			if ( is_array($message_items_id) ) {			
				if ( !(array_search($menuitemid,$message_items_id) === false) ) {
					$message_to_show = $message->message;
				}
			}
        }

        return $message_to_show;
    }
}