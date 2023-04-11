<?php

class Block_Category_Edit extends Block_Core_Abstracts
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('category/edit.phtml');
	}
}