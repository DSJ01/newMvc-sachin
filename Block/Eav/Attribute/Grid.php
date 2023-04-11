<?php

class Block_Eav_Attribute_Grid extends Block_Core_Abstracts
{
	
	function __construct()
	{
		$this->setTemplate('eav/attribute/grid.phtml');
	}

	public function getCollection()
	{
		$sql = "SELECT * FROM `eav_attribute`";
		$attributeModel = Ccc::getModel('Eav_Attribute');
		$attribute = $attributeModel->fetchAll($sql);
		return $attribute;
	}

}