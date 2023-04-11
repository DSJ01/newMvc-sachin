<?php
class Block_Admin_Edit extends Block_Core_Abstracts
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('admin/edit.phtml');
	}
}