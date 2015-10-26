<?php
/**
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

// Chequeamos si el archivo está incluido en Joomla!
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
jimport( 'joomla.plugin.helper' );

/**
* Logs View
*
*/
class JoommarkViewMessages extends JViewLegacy
{

	protected $items;
    protected $pagination;
    protected $state;

/**
* Securitycheckpros view método 'display'
**/
	function display($tpl = null)
	{

		// Model data
			
		$this->state= $this->get('State');
		$this->items = $this->get('Items');
					
		$this->pagination = $this->get('Pagination');
		$filter_messages_search = $this->state->get('filter_messages.search');
					
		$listDirn = $this->state->get('list.direction');
		$listOrder =  $this->state->get('list.ordering');
							
		 // Set the toolbar
        $this->addToolBar();

		parent::display($tpl);
	}

/**
     * Setting the toolbar
     */
    protected function addToolBar() 
    {
        
		JToolBarHelper::title( JText::_( 'Joommark' ).' | ' .JText::_('COM_JOOMMARK_VISITORS_INFO'), 'joommark' );
		JToolBarHelper::custom('redireccion_control_panel','arrow-left','arrow-left','COM_JOOMMARK_REDIRECT_CONTROL_PANEL');
		JToolBarHelper::addNew('message.add');
		JToolBarHelper::editList('message.edit');
		JToolBarHelper::deleteList('', 'messages.delete');
		JToolbarHelper::publish('messages.publish', 'JTOOLBAR_PUBLISH', true);
		JToolbarHelper::unpublish('messages.unpublish', 'JTOOLBAR_UNPUBLISH', true);
    }
}