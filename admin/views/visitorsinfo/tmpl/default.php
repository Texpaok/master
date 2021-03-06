﻿<?php 

/*
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access'); 


JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));

// Add style declaration
$css = "media/com_joommark/css/JoommarkStyles.css";
JHTML::stylesheet($css);

?>


<form action="<?php echo JRoute::_('index.php?option=com_joommark&view=visitorsinfo');?>" method="post" name="adminForm" id="adminForm">

<div id="filter-bar" class="btn-toolbar">
	<div class="filter-search btn-group pull-left">
		<input type="text" name="filter_visitors_info_search" placeholder="<?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>" id="filter_visitors_info_search" value="<?php echo $this->escape($this->state->get('filter_visitors_info.search')); ?>" title="<?php echo JText::_('JSEARCH_FILTER'); ?>" />
	</div>
	<div class="btn-group pull-left">
		<button class="btn tip" type="submit" rel="tooltip" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
		<button class="btn tip" type="button" onclick="document.getElementById('filter_visitors_info_search').value='';this.form.submit();" rel="tooltip" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
	</div>
</div>

<div class="clearfix"> </div>

<div>
	<span class="badge" style="background-color: #A9BCF5; padding: 10px 10px 10px 10px; float:right;"><?php echo JText::_('COM_JOOMMARK_VISITORS_INFO');?></span>
</div>
	
	<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th class="logs">				
				<?php echo JHtml::_('grid.sort', 'Ip', 'ip', $listDirn, $listOrder); ?>
			</th>
			<th class="logs">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_CUSTOMER_NAME', 'customer_name', $listDirn, $listOrder); ?>				
			</th>
			<th class="logs">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_VISITDATE', 'visitdate', $listDirn, $listOrder); ?>
			</th>
			<th class="logs">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_VISITEDPAGES', 'visitedpage', $listDirn, $listOrder); ?>
			</th>
			<th class="logs">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_GEOLOCATION', 'geolocation', $listDirn, $listOrder); ?>
			</th>
			<th class="logs">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_BROWSER', 'browser', $listDirn, $listOrder); ?>
			</th>
			<th class="logs">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_OS', 'os', $listDirn, $listOrder); ?>
			</th>			
			<th class="logs">
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
	<td>
			<?php echo $row->ip; ?>			
	</td>
	<td>
			<?php
				if ( empty($row->customer_name) ) {
					$span = "<span class=\"label \">";
					$row->customer_name = JText::_('COM_JOOMMARK_NONE');
				} else if ( strstr($row->customer_name,"Guest") ) {
					$span = "<span class=\"label \">";
				} else {
					$span = "<span class=\"label label-success\">";
				}
			?>
			<?php echo $span . $row->customer_name; ?>
			</span>			
	</td>
	<td>
			<?php echo $row->visit_timestamp; ?>
	</td>
	<td>
			<?php echo $row->visitedpage; ?>
	</td>
	<td>
			<?php 
			$geolocation_json_decode = json_decode($row->geolocation,true);
			$country_code = strtolower($geolocation_json_decode['country_code']);
			$country_name = $geolocation_json_decode['country_name'];
			$flag = "/media/com_joommark/flags/" . $country_code . ".png";			
			?>
			<img src=<?php echo $flag; ?> alt="<?php echo $country_name; ?>" title="<?php echo $country_name; ?>">			
	</td>
	<td>
			<?php echo $row->browser; ?>	
	</td>
	<td>
			<?php echo $row->os; ?>	
	</td>
	<td>			
			<?php echo JHtml::_('grid.id', $k, $row->visit_timestamp, '', 'visit_timestamp_array'); ?>
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
<input type="hidden" name="controller" value="visitorsinfo" />
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />

</form>