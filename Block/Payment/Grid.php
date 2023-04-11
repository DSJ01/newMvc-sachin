<?php

class Block_Payment_Grid extends Block_Core_Abstracts
{
	function __construct()
	{
	$this->setTemplate('payment/grid.phtml');
	}

	public function getCollection()
	{
	$paymentModel = Ccc::getModel('Payment');
	$sql = "SELECT * FROM `payment`";
	$payments = $paymentModel->fetchAll($sql);
	$this->setData(['payments' => $payments]);
	return $payments;
	}
}
?>