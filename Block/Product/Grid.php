<?php
class Block_Product_Grid extends Block_Core_Abstracts
{
	function __construct()
	{
		$this->setTemplate('product/grid.phtml');
	}
	public function getCollection()
	{
		$sql = "SELECT * FROM `product`";
		$productModel = Ccc::getModel('Product');
		$products = $productModel->fetchAll($sql);
		$this->setData(['products' => $products]);
		return $products;
	}
}