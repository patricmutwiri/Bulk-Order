<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_bulkorder
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

/**
 * Bulkorder Component Controller
 *
 * @since  0.0.1
 */
class BulkorderController extends JControllerLegacy
{
	function save(){
 	$app 	= JFactory::getApplication();
    $user 	= JFactory::getUser();
	if ($user->id) {
		//pullhikashop stuff
		if(!defined('DS'))
		define('DS', DIRECTORY_SEPARATOR);
		include_once(rtrim(JPATH_ADMINISTRATOR,DS).DS.'components'.DS.'com_hikashop'.DS.'helpers'.DS.'helper.php');
		$checkout = JRoute::_('index.php?option=com_hikashop&view=checkout&layout=step&Itemid=635');
		$class = hikashop::get('class.cart');

		$product_id = isset($_POST['pid']) ? $_POST['pid'] : '';
		$quantity   = isset($_POST['pquantity']) ? $_POST['pquantity'] : '';

	    $class->update($product_id, $quantity);
	    //save bulk order here
	    
	}
 }
}
