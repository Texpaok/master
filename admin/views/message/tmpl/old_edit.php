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
    <form action="<?php echo JRoute::_('index.php?option=com_joommark&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">

        <div class="row-fluid">
            <div class="span9">

				<?php foreach ($this->form->getFieldset("general") as $field)
				{ ?>
					<div class="control-group clearfix <?php echo $field->name ?>">
						<div class="control-label"><?php echo $field->label ?></div>
						<div class="controls">
							<?php echo $field->input ?>
						</div>
					</div>
				<?php } ?>

            </div>
        </div>
        <input type="hidden" name="task" value="joommark.edit" />
		<?php echo JHtml::_('form.token'); ?>
    </form>
</div>


