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


<form action="<?php echo JRoute::_('index.php?option=com_joommark&view=visitors');?>" method="post" name="adminForm" id="adminForm">

<div id="filter-bar" class="btn-toolbar">
	<div class="filter-search btn-group pull-left">
		<input type="text" name="filter_visitors_search" placeholder="<?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>" id="filter_visitors_search" value="<?php echo $this->escape($this->state->get('filter_visitors.search')); ?>" title="<?php echo JText::_('JSEARCH_FILTER'); ?>" />
	</div>
	<div class="btn-group pull-left">
		<button class="btn tip" type="submit" rel="tooltip" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
		<button class="btn tip" type="button" onclick="document.getElementById('filter_visitors_search').value='';this.form.submit();" rel="tooltip" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
	</div>
</div>

<div class="clearfix"> </div>

<div>
	<span class="badge" style="background-color: #A9BCF5; padding: 10px 10px 10px 10px; float:right;"><?php echo JText::_('COM_JOOMMARK_VISITORS_INFO');?></span>
</div>

	<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th class="logs" align="center">
				<?php echo JHtml::_('grid.sort', 'Session', 'session_id_person', $listDirn, $listOrder); ?>
			</th>
			<th class="logs" align="center">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_LAST_PAGE_VISITED', 'nowpage', $listDirn, $listOrder); ?>
			</th>
			<th class="logs" align="center">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_TIME', 'lastupdate_time', $listDirn, $listOrder); ?>
			</th>
			<th class="logs" align="center">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_USER', 'current_name', $listDirn, $listOrder); ?>
			</th>
			<th class="logs" align="center">
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
	<td align="center">
			<?php echo $row->session_id_person; ?>
			<span title="<?php echo JText::_('COM_JOOMMARK_VISITOR_INFO'); ?>">
                <a href="<?php echo JRoute::_( 'index.php?option=com_joommark&controller=visitorsinfo&view=visitorsinfo&filter=' . $row->session_id_person . '&'. JSession::getFormToken() .'=1' );?>" ">
					<i class="icon-eye-open"></i>
                </a>
            </span>
	</td>
	<td align="center">
			<?php echo $row->nowpage; ?>
	</td>
	<td align="center">
			<?php //echo gmdate("Y-m-d\T H:i:s\Z",$row->lastupdate_time); ?>
			<?php echo JHtml::_('date', $row->lastupdate_time, JText::_('DATE_FORMAT_LC2'));?>
	</td>
	<td align="center">
			<?php
				if ( empty($row->current_name) ) {
					$span = "<span class=\"label \">";
					$row->current_name = JText::_('COM_JOOMMARK_NONE');
				} else {
					$span = "<span class=\"label label-success\">";
				}
			?>
			<?php echo $span . $row->current_name; ?>
			</span>
	</td>
	<td align="center">
			<?php echo JHtml::_('grid.id', $k, $row->session_id_person, '', 'session_id_person_array'); ?>
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
<input type="hidden" name="controller" value="visitors" />
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />

</form>