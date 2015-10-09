<?php 

/*
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access'); 
JRequest::checkToken( 'get' ) or die( 'Invalid Token' );

//JHTML::_('behavior.framework');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');


function booleanlist( $name, $attribs = null, $selected = null, $id=false )
{
	$arr = array(
		JHTML::_('select.option',  '0', JText::_( 'COM_SECURITYCHECKPRO_CONTROL_CENTER_WEBSITE_TYPE_FREE' ) ),
		JHTML::_('select.option',  '1', JText::_( 'COM_SECURITYCHECKPRO_CONTROL_CENTER_WEBSITE_TYPE_PRO' ) )
	);
	return JHTML::_('select.genericlist',  $arr, $name, $attribs, 'value', 'text', (int) $selected, $id );
}

$this->form = JForm::getInstance('jform',JPATH_COMPONENT. DIRECTORY_SEPARATOR .'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'message.xml');
?>

<div class="form-horizontal">
<form class="form-validate" action="<?php echo JRoute::_('index.php?option=com_joommark&view=addmessage&controller=messages&'. JSession::getFormToken() .'=1');?>" method="post" name="adminForm" id="adminForm">



	<div class="row-fluid">
            <div class="span9">
                
                <?php foreach ($this->form->getFieldset("general") as $field) { ?>
                    <div class="control-group clearfix <?php echo $field->name ?>">
                        <div class="control-label"><?php echo $field->label ?></div>
                        <div class="controls">
                            <?php if ($field->name == "menuitems[]") { 	?>							
                            <div class="helpcontrol clearfix">
                                <span style="float:left; margin-right:6px; margin-top:-3px;">
                                    <?php echo $this->form->getField("allmenus")->input; ?>
                                </span>
                                <?php echo $this->form->getField("allmenus")->label; ?>
                            </div>
                            <?php } ?>
                            <?php echo $field->input ?>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
</div>

<input type="hidden" name="option" value="com_joommark" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="1" />
<input type="hidden" name="controller" value="messages" />
</form>