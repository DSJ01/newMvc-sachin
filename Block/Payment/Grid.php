<?php

class Block_Payment_Grid extends Block_Core_Grid
{
	function __construct()
	{
		parent::__construct();
	}


	public function getCollection()
	{
		$paymentModel = Ccc::getModel('Payment');
		$sql = "SELECT * FROM `payment`";
		$payments = $paymentModel->fetchAll($sql);
		$this->setData(['payments' => $payments]);
		return $payments;
	}


	protected function _prepareCollumns()
	{
		$this->addCollumn('payment_method_id',[
			'title' => 'payment_method_id'
		]);
		$this->addCollumn('name',[
			'title' => 'name'
		]);
		$this->addCollumn('status',[
			'title' => 'status'
		]);
	}

	protected function _prepareActions(){
		$this->addCollumn('edit',[
			'title' => 'edit',
			'url'  => ('edit')
		]);
		$this->addCollumn('delete',[
			'title' => 'delete',
			'url'  => ('edit')
		]);

	}

	protected function _prepareButtons(){
		$this->addCollumn('add',[
			'title' => 'add',
			'url'  => ('add')
		]);
	}

	public function getCollumnValue($key,$row)
	{
		if ($key == 'status') {
			return $row->getStatusText();
		}
		return $row->$key;
	}

}
?>