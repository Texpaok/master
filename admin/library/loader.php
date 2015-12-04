<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jommark
 *
 * @copyright   Copyright (C) 2014-2015 Jose A. Luque and Astrid Günther. All rights reserved.
 * @license     GNU General Public License version 2
 */
defined('_JEXEC') or die('Restricted access');

// Import Joomla Libraries
jimport('joomla.html.parameter');

$library = dirname(__FILE__);

// Todo I think this is easier with JLoader::discover('MYExtension', __DIR__);
// JLoader::registerPrefix('joommark', $library);

JLoader::register('JoommarkAuxController', $library . '/controller.php');
JLoader::register('JoommarkAuxModel', $library . '/model.php');
JLoader::register('JoommarkAuxView', $library . '/view.php');
JLoader::register('JoommarkAuxJoommarktable', $library . '/joommarktable.php');
