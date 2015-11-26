<?php
/**
 * @package     Responsive Scroll Triggered Box
 * @subpackage  com_rstbox
 *
 * @copyright   Copyright (C) 2014 Tassos Marinos - http://www.tassos.gr
 * @license     GNU General Public License version 2 or later; see http://www.tassos.gr/license
 */

// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.formvalidation');

JHtml::_('formbehavior.chosen', 'select');
?>

<div class="form-horizontal">
    <form action="<?php echo JRoute::_('index.php?option=com_joommark&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">
        
        <div class="row-fluid">
            <div class="span9">
                
                <?php foreach ($this->form->getFieldset("general") as $field) { ?>					
					<div class="control-group clearfix <?php echo $field->name ?>">
                        <div class="control-label"><?php echo $field->label ?></div>
                        <div class="controls">
                            <?php if ($field->name == "jform[menuitems][]") { ?>
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
        <input type="hidden" name="task" value="joommark.edit" />
		<?php echo JHtml::_('form.token'); ?>
    </form>

<script type="text/javascript">
    Joomla.submitbutton = function(task)
    {
        if (task == 'item.cancel' || document.formvalidator.isValid(document.id('adminForm')))
        {
            Joomla.submitform(task, document.getElementById('adminForm'));
        }
    }
</script>

<script type="text/javascript" language="javascript">
	// Check if the "assign to all pages" checkbox is true
	;(function($,undefined){
		$(function() {
	
		  
		/* All menus assignment */
			$("#jform_allmenus").click(function() {
				checked = $(this).is(':checked');
		   
				if (checked) {
					disableElement($("#jform_menuitems"), true);
					disableElement($("#jform_menuitems_chzn"), true);					
				} else {
					disableElement($("#jform_menuitems"), false);
					disableElement($("#jform_menuitems_chzn"), false);
				}
			});

			function disableElement(element, state) {
				if (state) {
					element.addClass("hide");	
				} else {
					element.removeClass("hide");					
				}
			}
			
			window.addEvent('domready', function() {
				allMenusIsChecked = $("#jform_allmenus").is(':checked');				
				disableElement($("#jform_menuitems_chzn"),allMenusIsChecked);
			});
	    });
	})(jQuery);
</script>

</div>


