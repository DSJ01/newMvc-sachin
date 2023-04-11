<?php

class Block_Shipping_Grid extends Block_Core_Abstracts
{
	
	function __construct()
	{
		$this->setTemplate('shipping/grid.phtml');
	}

	public function getCollection()
	{
		$sql = "SELECT * FROM `shipping`";
		$shippingModel = Ccc::getModel('Shipping');
		$sql = "SELECT * FROM `shipping`";
		$shippings = $shippingModel->fetchAll($sql);
		$this->setData(['shippings' => $shippings]);
		return $shippings;
	}
}


