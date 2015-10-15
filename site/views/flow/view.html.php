<?php 

/**
 * @subpackage views
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 * View for dummy tracking
 *
 * @subpackage views
 * @since 3.0
 */
class JoommarkViewFlow extends JViewLegacy {
	/**
	 * Return application/json response to JS client APP
	 * Replace $tpl optional param with $userData contents to inject
	 *        	
	 * @access public
	 * @return void
	 */
	public function display($streamData = null) {
	}
}