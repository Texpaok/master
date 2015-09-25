<?php

// Chequeamos si el archivo está incluído en Joomla!
defined('_JEXEC') or die();

// Load library
require_once(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_joommark'.DIRECTORY_SEPARATOR.'library'.DIRECTORY_SEPARATOR.'loader.php');

class DatabaseAux extends JoommarkModel
{
	
	 /**
     * Add data to a database
     * @param string $database The database name.
     * @param string $data The data to store.     
     */
    public function add_to_database($database, $data)
    {
	
		// New database object
		$db = JFactory::getDBO();
		
		/*$query = $db->getQuery(true)
			->delete($db->quoteName('#__securitycheckpro_storage'))
			->where($db->quoteName('storage_key').' = '.$db->quote('filemanager_resume'));
		$db->setQuery($query);
		$db->execute();
		
		$object = (object)array(
			'storage_key'	=> 'filemanager_resume',
			'storage_value'	=> utf8_encode(json_encode(array(
				'files_scanned'		=> $this->files_scanned,
				'files_with_incorrect_permissions'	=> $this->files_with_incorrect_permissions,
				'last_check'	=> $this->currentDateTime_func(),
				'filename'		=> $filename
			)))
		);
		
		try {
			$result_permissions_resume = $db->insertObject('#__securitycheckpro_storage', $object);
		} catch (Exception $e) {		
			$this->set_campo_filemanager('estado','DATABASE_ERROR');
			$result_permissions_resume = false;
		}*/
		
		return ("kk");
	
	}
	
	
	
}