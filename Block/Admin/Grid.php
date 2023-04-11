<?php
class Block_Admin_Grid extends Block_Core_Abstracts
{
	function __construct()
	{
	$this->setTemplate('admin/grid.phtml');
	}
	public function getCollection()
	{
	$adminModel = Ccc::getModel('Category');
	$sql = "SELECT * FROM `admin` ";
	$admins = $adminModel->fetchAll($sql);
	$this->setData(['admins' => $admins]);
	return $admins;
	}
}
?>