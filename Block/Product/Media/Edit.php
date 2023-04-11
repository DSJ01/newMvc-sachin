<?php
class Block_Product_Media_Edit extends Block_Core_Abstracts
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('product_media/add.phtml');
	}
}