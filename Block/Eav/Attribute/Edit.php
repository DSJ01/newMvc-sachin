<?php

class Block_Eav_Attribute_Edit extends Block_Core_Abstracts
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('eav/attribute/edit.phtml');		
	}
}