<?php
class Block_Shipping_Edit extends Block_Core_Abstracts
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('shipping/edit.phtml');
	}
}