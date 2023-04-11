<?php
class Block_Vendor_Address_Grid extends Block_Core_Abstracts
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('vendor/address.phtml');
	}
}