<?php
class Block_Customer_Edit extends Block_Core_Abstracts
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('customer/edit.phtml');
		$this->setData(['customer' => Ccc::getModel('Customer'), 'billingAddress' => Ccc::getModel('Customer_Address'), 'shippingAddress' => Ccc::getModel('Customer_Address')]);
	}

}