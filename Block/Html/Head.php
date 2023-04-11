<?php
class Block_Html_Head extends Block_Core_Abstracts
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('html/head.phtml');
	}
}
?>