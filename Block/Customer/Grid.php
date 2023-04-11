<?php
class Block_Customer_Grid extends Block_Core_Abstracts
{
	function __construct()
	{
		$this->setTemplate('customer/grid.phtml');
	}

	public function getCollection()
	{
		$sql = "SELECT * FROM `customer`";
		$customerModel = Ccc::getModel('customer');
		$customers = $customerModel->fetchAll($sql);
		$this->setData(['customers' => $customers]);
		return $customers;
	}
}