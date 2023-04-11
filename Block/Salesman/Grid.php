<?php
class Block_Salesman_Grid extends Block_Core_Abstracts
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('salesman/grid.phtml');
	}

	public function getCollection()
	{
		$sql = "SELECT * FROM `salesman`";
		$salesmanModel = Ccc::getModel('salesman');
		$salesmans = $salesmanModel->fetchAll($sql);
		$this->setData(['salesmans' => $salesmans]);
		return $salesmans;
	}
}