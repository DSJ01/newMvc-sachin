<?php

class Block_Eav_Attribute_Edit extends Block_Core_Abstracts
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('eav/attribute/edit.phtml');		
	}

	public function getOption()
	{
		$sql = "SELECT * FROM `eav_attribute_option`";
		$model = Ccc::getModel('Eav_Attribute');
		$data = $model->fetchAll($sql);
		return $data;
	}
}