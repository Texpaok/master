<?php 

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
$media_url = "media/com_securitycheckpro/stylesheets/cpanelui.css";
JHTML::stylesheet($media_url);

$bootstrap_css = "media/com_securitycheckpro/stylesheets/bootstrap.min.css";
JHTML::stylesheet($bootstrap_css);
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
			<th class="logs" align="center">				
				<?php echo JHtml::_('grid.sort', 'Ip', 'ip', $listDirn, $listOrder); ?>
			</th>
			<th class="logs" align="center">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_CUSTOMER_NAME', 'customer_name', $listDirn, $listOrder); ?>				
			</th>
			<th class="logs" align="center">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_VISITDATE', 'visitdate', $listDirn, $listOrder); ?>
			</th>
			<th class="logs" align="center">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_VISITEDPAGES', 'visitedpages', $listDirn, $listOrder); ?>
			</th>
			<th class="logs" align="center">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_GEOLOCATION', 'geolocation', $listDirn, $listOrder); ?>
			</th>
			<th class="logs" align="center">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_BROWSER', 'browser', $listDirn, $listOrder); ?>
			</th>
			<th class="logs" align="center">
				<?php echo JHtml::_('grid.sort', 'COM_JOOMMARK_OS', 'os', $listDirn, $listOrder); ?>
			</th>			
			<th class="logs" align="center">
				<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)" />
			</th>
		</tr>
	</thead>
<?php
$k = 0;
foreach ($this->items as &$row) {	
?>
<tr>
	<td align="center">
			<?php echo $row->ip; ?>			
	</td>
	<td align="center">
			<?php echo $row->customer_name; ?>	
	</td>
	<td align="center">
			<?php echo $row->visitdate; ?>	
	</td>
	<td align="center">
			<?php echo $row->visitedpages; ?>
	</td>
	<td align="center">
			<?php echo $row->geolocation; ?>	
	</td>
	<td align="center">
			<?php echo $row->browser; ?>	
	</td>
	<td align="center">
			<?php echo $row->os; ?>	
	</td>
	<td align="center">			
			<?php echo JHtml::_('grid.id', $k, $row->id); ?>
	</td>	
</tr>
<?php
$k = $k+1;
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