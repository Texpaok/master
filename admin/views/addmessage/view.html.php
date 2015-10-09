<?php
/**
* Logs View para el Componente Securitycheckpro
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
class JoommarksViewAddmessage extends JViewLegacy
{

	protected $items;
    protected $pagination;
    protected $state;

/**
* Securitycheckpros view método 'display'
**/
function display($tpl = null)
{

	JToolBarHelper::title( JText::_( 'Joommark' ).' | ' .JText::_('COM_JOOMMARK_VISITORS_INFO'), 'joommark' );
	JToolBarHelper::custom('redireccion_control_panel','arrow-left','arrow-left','COM_JOOMMARK_REDIRECT_CONTROL_PANEL');
	JToolBarHelper::apply();
	JToolBarHelper::save();	

	parent::display($tpl);
}
}