<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_advent
 *
 * @copyright  Copyright (C) 2014-2015 astrid-guenther.de. All rights reserved.
 * @license    GNU General Public License version 2
 */
defined('_JEXEC') or die;

jimport('joomla.form.formrule');

/**
 * Obj Rule
 *
 * @since  0.0.12
 */
class JFormRuleObj extends JFormRule
{
	/**
	 * A regex string
	 *
	 * @var    string
	 * @since  0.0.12
	 */
	protected $regex = '^[^0-9]+$';
}
