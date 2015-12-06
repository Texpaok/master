<?php

/*
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.model' );

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));

?>


<form action="index.php?option=com_joommark&view=plans" method="post" name="adminForm" id="adminForm">

<div id="filter-bar" class="btn-toolbar">
	<div class="filter-search btn-group pull-left">
		<input type="text" name="filter_plans_search" placeholder="<?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>" id="filter_plans_search" value="<?php echo $this->escape($this->state->get('filter_plans.search')); ?>" title="<?php echo JText::_('JSEARCH_FILTER'); ?>" />
	</div>
	<div class="btn-group pull-left">
		<button class="btn tip" type="submit" rel="tooltip" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
		<button class="btn tip" type="button" onclick="document.getElementById('filter_plans_search').value='';this.form.submit();" rel="tooltip" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
	</div>
</div>

<div class="clearfix"> </div>

<div>
	<span class="badge" style="background-color: #A9BCF5; padding: 10px 10px 10px 10px; float:right;"><?php echo JText::_('COM_JOOMMARK_PLANS');?></span>
</div>

	<table class="table table-striped">
	<thead>
		<tr>
			<th class="center" width="7%">
				<?php echo JHtml::_('grid.sort', 'ID', 'id', $listDirn, $listOrder); ?>
			</th>
			<th class="center" width="7%">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_PUBLISHED', 'published', $listDirn, $listOrder); ?>
			</th>
			<th class="center">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_TITLE', 'title', $listDirn, $listOrder); ?>
			</th>
			<th class="center" width="15%">
				<?php echo JText::_('COM_JOOMMARK_ITEM_COOKIE'); ?>
			</th>
			<th class="center"width="15%">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_ACCESSLEVEL', 'accesslevel', $listDirn, $listOrder); ?>
			</th>
			<th class="center" width="2%">
				<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)" />
			</th>
		</tr>
	</thead>
<?php
$k = 0;
if (!empty($this->items)) {
foreach ($this->items as &$row) {
?>
<tr>
	<td class="center">
		<?php echo $row->id; ?>
		</a>
	</td>
	<td class="center">
			<?php
			echo JHtml::_('jgrid.published', $row->state, $k, 'plans.', true);
			?>
	</td>
	<td class="center">
		<a href="<?php echo JRoute::_('index.php?option=com_joommark&task=plan.edit&id='.$row->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
		<?php echo $row->name; ?>
	</td>
	<td class="center">
		<?php echo $row->description; ?>
	</td>
	<td class="center">
		<?php echo $row->state; ?>
	</td>
	<td class="center">
			<?php echo JHtml::_('grid.id', $k, $row->id); ?>
	</td>
</tr>
<?php
$k = $k+1;
}
}
?>

</table>

<?php
if ( !empty($this->items) ) {
?>
<div class="pagination">
<tfoot>
	<tr>
		<td colspan="9"><?php echo $this->pagination->getListFooter(); ?>
		<?php echo $this->pagination->getLimitBox(); ?>
		</td>
	</tr>
</tfoot>
</div>
<?php
}
?>


<input type="hidden" name="option" value="com_joommark" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="1" />
<?php echo JHtml::_('form.token'); ?>
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />

</form>