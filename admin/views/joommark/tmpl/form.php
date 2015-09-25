<?php 

/*
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access'); 

// Add style declaration
$media_url = "media/com_joommark/stylesheets/cpanelui.css";
JHTML::stylesheet($media_url);

$bootstrap_css = "media/com_joommark/stylesheets/bootstrap.min.css";
JHTML::stylesheet($bootstrap_css);

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="securitycheck-bootstrap">

</div>



<input type="hidden" name="option" value="com_joommark" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="1" />
<input type="hidden" name="controller" value="joommark" />
</form>