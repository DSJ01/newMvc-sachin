<?php
class Block_Customer_Address_Grid extends Block_Core_Abstracts
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('customer/address.phtml');
	}
}