<?php
class Block_Vendor_Grid extends Block_Core_Abstracts
{
	
	function __construct()
	{
		$this->setTemplate('vendor/grid.phtml');
	}

	public function getCollection()
	{
		$sql = "SELECT * FROM `vendor`";
		$vendorModel = Ccc::getModel('Vendor');
		$vendors = $vendorModel->fetchAll($sql);
		$this->setData(['vendors' => $vendors]);
		return $vendors;
	}
}