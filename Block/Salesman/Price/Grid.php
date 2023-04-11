<?php
class Block_Salesman_Price_Edit extends Block_Core_Abstracts
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('salesman/salesman_price.phtml');
	}
}