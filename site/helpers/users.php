<?php

defined ( '_JEXEC' ) or die ();

/**
 * Helper static class
 * 
 * @since 3.0
 */
class JoommarkHelpersUsers {
	
	/**
	 * Return current user session table object with singleton
	 * 
	 * @access private
	 * @static
	 *
	 * @return Object
	 */
	public static function getSessionTable() {
		// Lazy loading user session
		static $userSessionTable;
		
		if (! is_object ( $userSessionTable )) {
			$userSessionTable = JTable::getInstance ( 'session' );
			$userSessionTable->load ( session_id () );
		}
		
		return $userSessionTable;
	}
	
}