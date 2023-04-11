<?php
class Block_Vendor_Edit extends Block_Core_Abstracts
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('product_media/add.phtml');
	}
}