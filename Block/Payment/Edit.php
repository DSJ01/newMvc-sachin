<?php

class Block_Payment_Edit extends Block_Core_Abstracts
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('payment/edit.phtml');
	}
}