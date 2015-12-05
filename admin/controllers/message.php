<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jommark
 *
 * @copyright   Copyright (C) 2014-2015 Jose A. Luque and Astrid Günther. All rights reserved.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die();
/**
 * class Joommark Controller Message
 *
 * @since  1.0
 */
class JoommarkControllerMessage extends JControllerForm
{
	/**
	 * Method to check if you can add a new record.
	 *
	 * Extended classes can override this if necessary.
	 *
	 * @param   array  $data  An array of input data.
	 *
	 * @return  boolean
	 */
	protected function allowAdd($data = array())
	{
		$user = JFactory::getUser();

		return $user->authorise('core.create', 'com_joommark.message') || count($user->getAuthorisedCategories('com_joommark', 'message.create'));
	}

	/**
	 * Method to check if you edit a record.
	 *
	 * Extended classes can override this if necessary.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key; default is id.
	 *
	 * @return  boolean
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		$user = JFactory::getUser();

		$model = $this->getModel();

		$item = $model->getItem($data[$key]);

		$allowed = $user->getAuthorisedCategories('com_joommark.message', 'message.edit');

		$categories = !empty($item->sections) && is_array($item->sections) ? array_intersect($item->sections, $allowed) : array();

		return $user->authorise('core.edit', 'com_joommark.message') || count($categories);
	}
}
