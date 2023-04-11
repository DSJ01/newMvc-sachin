<?php

class Block_Category_Grid extends Block_Core_Abstracts
{
	function __construct()
	{
	$this->setTemplate('category/grid.phtml');
	}
	public function getCollection()
	{
	$categoryModel = Ccc::getModel('Category');
	$sql = "SELECT * FROM `category` WHERE `parent_id` IS NOT NULL";
	$categorys = $categoryModel->fetchAll($sql);
	$this->setData(['categorys' => $categorys]);
	return $categorys;
	}
}
?>