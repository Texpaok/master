<?php

defined('_JEXEC') or die('Restricted access');

/**
 * 
 * @subpackage controllers
 * @since 3.0
 */
class JoommarkControllerFlow extends JControllerLegacy
{

	/**
	 * Set model state always getting fresh vars from POST request
	 *
	 * @access protected
	 * @param string $scope        	
	 * @param Object $explicitModel        	
	 * @return void
	 */
	protected function setModelState($scope = 'default', $explicitModel = null)
	{
		// Set model state for basic flow
				// Get the configuration options.
		$this->app = JFactory::getApplication();
		$explicitModel->setState('initialize', $this->app->input->getBool('initialize', false));
		$explicitModel->setState('nowpage', urldecode($this->app->input->post->getString('nowpage', null)));
		$explicitModel->setState('module_available', $this->app->input->post->getBool('module_available', false));
		$explicitModel->setState('clicked_element', urldecode($this->app->input->post->getString('clicked_element', null)));
	}

	/**
	 * Display data for JS client on flow read/write by POST JS app
	 *
	 * @access public
	 * @return void
	 */
	public function display($cachable = false, $urlparams = false)
	{
		// Initialization
		$document = JFactory::getDocument();
		$viewType = $document->getType();

		$path = JPATH_COMPONENT . '/helpers/users.php';
		if (file_exists($path))
		{
			require_once $path;
		} else
		{
			$app->enqueueMessage(JText::_('No helper file'), 'error');
			return false;
		}
		// Instantiate session object for Dependency Injection into main model
		$userSessionTable = JoommarkHelpersUsers::getSessiontable();

		// Main Flow model, implements Observable role
		$model = $this->getModel('Flow', 'JoommarkModel', array(
			'sessiontable' => $userSessionTable
				));

		// Populate model state
		$this->setModelState('Flow', $model);

		// Try to load record from model
		$flowData = $model->getData();
		$model->saveSeconds();

		// Get view and pushing model
		$view = $this->getView('Flow', $viewType, '', array(
			'base_path' => $this->basePath
				));
		// Format response for JS client as requested
		$view->display($flowData);
		
		
	}

}
