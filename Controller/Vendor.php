<?php
	require_once 'view/html/header.phtml';
	require_once 'Controller/Core/Action.php';
	require_once 'Model/vendor.php';

	class Controller_Vendor extends Controller_Core_Action{

		public $vendro = [];
		public $vendorAddress = [];

		public function gridAction()
		{

			try {
				$layout = $this->getLayout();
				$grid = new Block_Vendor_grid();
				$layout->getChild('content')->addChilde('grid',$grid);
				$layout->render();
				
			} catch (Exception $e) {
					$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
					$this->redirect('vendor','grid',null,true);
			}
		}

		public function addAction()
		{
			try{
				$vendor = Ccc::getModel('Vendor');
				if (!$vendor) {
					throw new Exception("Object not found", 1);
				}
				$address = Ccc::getModel('Vendor_Address');

				$layout = $this->getLayout();
				$edit = new Block_Vendor_Edit();
				$edit->setData(['vendor' => $vendor, 'address' => $address ]);
				$layout->getChild('content')->addChilde('edit',$edit);
				$layout->render();
				
				
			} catch (Exception $e) {
				$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
				$this->redirect('vendor','grid',null,true);
			}
		}


		public function editAction()
		{
			try {
				$request = $this->getRequest();
				$vendorId = $request->getParams('id');
				if (!$vendorId) {
					$this->error('Request deniad...');
				}
				$vendorModel = Ccc::getModel('Vendor');
				$vendor = $vendorModel->load($vendorId);
				
				$vendorAddressModel = Ccc::getModel('vendor_Address');
				$sql = "SELECT * FROM `vendor_address` WHERE `vendor_id` = '{$vendorId}'";
				$address = $vendorAddressModel->fetchRow($sql);

				$layout = $this->getLayout();
				$edit = new Block_Vendor_Edit();
				$edit->setData(['vendor' => $vendor, 'address' => $address ]);
				$layout->getChild('content')->addChilde('edit',$edit);
				$layout->render();

			} catch (Exception $e) {
				$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
				$this->redirect('vendor','grid',null,true);
			}
			
		}

		public function saveAction()
		{
			try {

				if (!$this->getRequest()->ispost()) {
					throw new Exception("Data not Posted..", 1);			
				}

				$vendorData = $this->getRequest()->getPost('vendor');
				if (!$vendorData) {
					throw new Exception("Data not Posted..", 1);			
				}

				$vendorAddressData = $this->getRequest()->getPost('vendor_address');
				if (!$vendorAddressData) {
					throw new Exception("Data not Posted..", 1);			
				}

				$id = $this->getRequest()->getParams('id');
				$vendorModel = Ccc::getModel('Vendor');
				$vendorAddressModel = Ccc::getModel('Vendor_Address');
				if ($id) {
					$vendorModel->load($id);
					$sql = "SELECT * FROM `vendor_address` WHERE `vendor_id` = '{$id}' ";
					$data =$vendorAddressModel->fetchRow($sql);
					$vendorAddressModel-> updated_at = date("Y-m-d h:i:sa");
					$vendorModel -> updated_at = date("Y-m-d h:i:sa");

				}
				else{
				$vendorModel -> created_at = date("Y-m-d h:i:sa");
				$vendorAddressModel-> created_at = date("Y-m-d h:i:sa");
				}
				$vendorModel->setData($vendorData);
				$vendorId = $vendorModel->save();

				if (!$vendorAddressModel-> vendor_id ) {
				$vendorAddressModel-> vendor_id = $vendorId;
				}
				echo "<pre>";
				$vendorAddressModel->setData($vendorAddressData);

				$result = $vendorAddressModel->save();
				
				if ($vendorId && $result ) {
					throw new Exception("DATA SAVED...", 1);
					
				}
				$this->redirect('vendor','grid',null,true);
				
			} catch (Exception $e) {
				$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
				// $this->redirect('vendor','grid',null,true);
			}
		}	

		public function deleteAction()
		{
			try {

				$request = $this->getRequest();
				$vendorId = $request->getParams('id');
				if (!$vendorId) {
					error('Request deniad...');
				}
				$vendorModel = Ccc::getModel('Vendor');
				$vendorModel->load($vendorId);
				$vendorAddressModel->delete();
				$result = $vendorModel->delete();
				if (!$result) {
					throw new Exception("DATA NOT DELETED...", 1);
				}
					throw new Exception("DATA DELETED...", 1);
				$this->redirect('vendor','grid',null,true);	
				
			} catch (Exception $e) {
				$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
				$this->redirect('vendor','grid',null,true);
			}
			
						
		}

		public function addressAction()
		{

			try {
				$id = $this->getRequest()->getParams('id');
				if (!$id) {
					$this->error('Request deniad...');
				}
				$sql = "SELECT * FROM `vendor_address` WHERE `vendor_id` = '{$id}'";
				$vendorModel = Ccc::getModel('Vendor_Address');
				$address = $vendorModel->fetchRow($sql);
				$layout = $this->getLayout();
				$grid = new Block_Vendor_Address_Grid();
				$grid->setData(['address' => $address]);
				$layout->getChild('content')->addChilde('address',$grid);
				$layout->render();

			} catch (Exception $e) {
					$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
					$this->redirect('vendor','grid',null,true);
			}

		}

		
	}




?>	