<?php
class Block_Salesman_Address_Grid extends Block_Core_Abstracts
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('salesman/address.phtml');
	}
}