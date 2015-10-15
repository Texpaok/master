<?php 
// namespace administrator\components\com_jrealtime\views\stream;

/**
 * @subpackage views
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 * View for JS client
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
	public function display($flowData = null) {
		echo json_encode($flowData);  
	}
}