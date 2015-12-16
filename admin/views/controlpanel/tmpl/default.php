<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jommark
 *
 * @copyright   Copyright (C) 2014-2015 Jose A. Luque and Astrid Günther. All rights reserved.
 * @license     GNU General Public License version 2
 */
defined('_JEXEC') or die('Restricted Access');

// Load language
$lang = JFactory::getLanguage();
$lang->load('com_joommark.sys');

$review = sprintf($lang->_('COM_SECURITYCHECKPRO_REVIEW'), '<a href="http://extensions.joomla.org/extensions/extension/access-a-security/site-security/securitycheck-pro" target="_blank">', '</a>');
$translator_name = $lang->_('COM_SECURITYCHECKPRO_TRANSLATOR_NAME');
$translator_url = $lang->_('COM_SECURITYCHECKPRO_TRANSLATOR_URL');

if (!file_exists(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . "language" . DIRECTORY_SEPARATOR . $lang->get("tag") . DIRECTORY_SEPARATOR . $lang->get("tag") . ".com_joommark.ini"))
{
	// No existe traduccion
	$translator_name = "<blink>" . $lang->get("name") . " translation is missing.</blink> Please contribute writing this translation. It's easy. Click to see how.";
	$translator_url = "http://securitycheck.protegetuordenador.com/index.php/forum/13-news-and-announcement/4-contribute-send-us-your-translation";
}

/*JHTML::_('behavior.framework');
JHtml::_('behavior.modal');*/

// Add style declaration
$media_url = "media/com_joommark/stylesheets/cpanelui.css";
JHTML::stylesheet($media_url);

$bootstrap_css = "media/com_joommark/stylesheets/bootstrap.min.css";
JHTML::stylesheet($bootstrap_css);

$opa_icons = "media/com_joommark/stylesheets/opa-icons.css";
JHTML::stylesheet($opa_icons);
?>

<form action="<?php echo JRoute::_('index.php?option=com_joommark'); ?>" method="post" name="adminForm" id="adminForm">

	<div class="securitycheck-bootstrap">


		<div class="row-fluid" id="cpanel">
			<div class="box span6">
				<div class="box-header well" data-original-title>
					<i class="icon-home"></i><?php echo ' ' . JText::_('COM_JOOMMARK_MAIN_MENU'); ?>
				</div>
				<div class="box-content">
					<fieldset>
						<legend><?php echo JText::_('COM_JOOMMARK_OPTIONS'); ?></legend>
						<div class="icon">
							<a href="<?php echo JRoute::_('index.php?option=com_joommark&controller=visitors&view=visitors&' . JSession::getFormToken() . '=1'); ?>">
								<div class="joommark-icon-visitors">&nbsp;</div>
								<span><?php echo JText::_('COM_JOOMMARK_VISITORS'); ?></span>
							</a>
						</div>

						<div class="icon">
							<a href="<?php echo JRoute::_('index.php?option=com_joommark&controller=visitorsinfo&view=visitorsinfo&' . JSession::getFormToken() . '=1'); ?>">
								<div class="joommark-icon-visitors_info">&nbsp;</div>
								<span><?php echo JText::_('COM_JOOMMARK_VISITORS_INFO'); ?></span>
							</a>
						</div>

						<div class="icon">
							<a href="<?php echo JRoute::_('index.php?option=com_joommark&controller=messages&view=messages&' . JSession::getFormToken() . '=1'); ?>">
								<div class="joommark-icon-messages">&nbsp;</div>
								<span><?php echo JText::_('COM_JOOMMARK_MESSAGES'); ?></span>
							</a>
						</div>

						<div class="icon">
							<a href="<?php echo JRoute::_('index.php?option=com_joommark&controller=plans&view=plans&' . JSession::getFormToken() . '=1'); ?>">
								<i class="icon-wand"></i>
								<span><?php echo JText::_('COM_JOOMMARK_PLANS'); ?></span>
							</a>
						</div>

						<div class="icon">
							<a href="<?php echo JRoute::_('index.php?option=com_categories&extension=com_joommark'); ?>">
								<i class="icon-wand"></i>
								<span><?php echo JText::_('COM_JOOMMARK_CATEGORIES'); ?></span>
							</a>
						</div>

						<div class="icon">
							<a href="index.php?option=com_config&view=component&component=com_joommark&path=&return=<?php echo base64_encode(JURI::getInstance()->toString()) ?>">
								<div class="joommark-icon-configure">&nbsp;</div>
								<span><?php echo JText::_('COM_JOOMMARK_CONFIGURE'); ?></span>
							</a>
						</div>
					</fieldset>

				</div>
			</div>

			<div class="box span6">
				<div class="box-header well" data-original-title>
					<i class="icon-list"></i><?php echo ' ' . JText::_('COM_JOOMMARK_STATS') . ' (' . DATE('Y-m-d') . ')'; ?>
				</div>
				<div class="box-content">

					<div class="well span6 top-block">
						<span class="sc-icon32 sc-icon-blue sc-icon-user"></span>

						<div><?php echo JText::_('COM_JOOMMARK_TOTAL_VISITORS'); ?></div>
						<div><span class="label label-info"><?php echo $this->total_visitors; ?></span></div>

					</div>

					<div class="well span6 top-block">
						<span class="sc-icon32 sc-icon-green sc-icon-document"></span>
						<div><?php echo JText::_('COM_JOOMMARK_TOTAL_VISITED_PAGES'); ?></div>
						<div><span class="label label-info"><?php echo $this->visited_pages; ?></span></div>
					</div>

				</div>
				<div class="box-content">

					<div class="well span6 top-block">
						<span class="sc-icon32 sc-icon-red sc-icon-pin"></span>

						<div><?php echo JText::_('COM_JOOMMARK_EVENTS'); ?></div>
						<div><span class="label label-info"><?php echo "20"; ?></span></div>

					</div>

				</div>

			</div>
		</div>
		
		<div class="row-fluid" id="cpanel">
		
			<div class="span6">
			
			</div>
			
			<div class="box span6">
				<div class="box-header well" data-original-title>
					<i class="icon-flag"></i><?php echo ' ' . JText::_('COM_JOOMMARK_VISITED_PAGES_PER_COUNTRY'); ?>
				</div>
				<div id="vmap" style="width: 600px; height: 400px;" >
				
					<link href="/administrator/components/com_joommark/helpers/map/dist/jqvmap.css" media="screen" rel="stylesheet" type="text/css"/>

					<script type="text/javascript" src="/administrator/components/com_joommark/helpers/map/dist/jquery-1.11.3.min.js"></script>
					<script type="text/javascript" src="/administrator/components/com_joommark/helpers/map/dist/jquery.vmap.js"></script>
					<script type="text/javascript" src="/administrator/components/com_joommark/helpers/map/dist/maps/jquery.vmap.world.js" charset="utf-8"></script>									
					
					<script>						
					var countries_data = <?php echo $this->total_visitors_per_country; ?>;
					  jQuery(document).ready(function () {
						jQuery('#vmap').vectorMap({
						  map: 'world_en',
						  backgroundColor: '#333333',
						  color: '#ffffff',
						  hoverOpacity: 0.7,
						  selectedColor: '#666666',
						  enableZoom: true,
						  showTooltip: true,
						  scaleColors: ['#C8EEFF', '#006491'],
						  values: countries_data,
						  normalizeFunction: 'polynomial',
						  onLabelShow: function (event,label,code) {
							if (countries_data[code]>0) {
								label.append(': ' + countries_data[code]);
							}			
						  }						 
						});
					  });
					</script>					

				</div>
			</div>
		</div>


	</div>

	<input type="hidden" name="option" value="com_joommark" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="1" />
	<input type="hidden" name="controller" value="cpanel" />
</form>
