<?php

class Block_Product_Edit extends Block_Core_Abstracts
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('product/edit.phtml');
	}
}