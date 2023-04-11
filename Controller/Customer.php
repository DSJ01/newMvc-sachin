<?php
class Controller_Customer extends Controller_Core_Action{

	public $customer = [];
	public $customerAddress = [];
	public $customerRow = null;
	public $customerAddressRow = null;

	public function gridAction()
	{
		try {
			$grid = new Block_Customer_grid();
			$layout = $this->getLayout();
			$layout ->getChild('content')->addChilde('grid',$grid);
			$layout->render();
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function addAction()
	{
		try {
			$customerModel = Ccc::getModel('Customer');
			$customerAddressModel = Ccc::getModel('Customer_Address');

			$layout = $this->getLayout();
			$edit = new Block_Customer_Edit();
			$edit->setData(['customer' => $customerModel, 'customerAddress' => $customerAddressModel]);
			$layout->getChild('content')->addChilde('edit',$edit);
			$layout->render();
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}	

	public function editAction()
	{
		try {
			$customerId = $this->getRequest()->getParams('id');
			if (!$customerId) {
					$this->error('Request deniad...');
				}	
			$customerModel = Ccc::getModel('Customer');
			$customer = $customerModel->load($customerId);

			$billingAddress = Ccc::getModel('Customer_Address')->load($customer->billing_address_id);
			$shippingAddress = Ccc::getModel('Customer_Address')->load($customer->shipping_address_id);
			$layout = $this->getLayout();
			$edit = new Block_Customer_Edit();
			$edit->setData(['customer' => $customer, 'billingAddress' => $billingAddress, 'shippingAddress' => $shippingAddress]);
			$layout->getChild('content')->addChilde('edit',$edit);
			$layout->render();

			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
		

	}

	public function saveAction()
		{
			try {

				if (!$this->getRequest()->ispost()) {
					throw new Exception("Data not Posted..", 1);			
				}

				$customerData = $this->getRequest()->getPost('customer');
				if (!$customerData) {
					throw new Exception("Data not Posted..", 1);			
				}

				$shippingAddressData = $this->getRequest()->getPost('shipping_address');
				if (!$shippingAddressData) {
					throw new Exception("Data not Posted..", 1);			
				}

				$billingAddressData = $this->getRequest()->getPost('billing_address');
				if (!$billingAddressData) {
					throw new Exception("Data not Posted..", 1);			
				}

				$id = $this->getRequest()->getParams('id');
				$customerModel = Ccc::getModel('Customer');
				$shippingModel = Ccc::getModel('Customer_Address');
				$billingModel = Ccc::getModel('Customer_Address');

				if ($id) {
					$customerModel->load($id);
					$sql = "SELECT * FROM `customer_address` WHERE `customer_id` = '{$id} AND `` '";
					$customerAddressModel->fetchRow($sql);
					$customerAddressModel-> updated_at = date("Y-m-d h:i:sa");
					$customerModel -> updated_at = date("Y-m-d h:i:sa");

				}
				else{
				$customerModel -> created_at = date("Y-m-d h:i:sa");
				$customerAddressModel-> created_at = date("Y-m-d h:i:sa");
				}
				$customerModel->setData($customerData);
				$customerId = $customerModel->save();
				$customerAddressModel->setData($customerAddressData);
				if (!$customerAddressModel->customer_id) {
				$customerAddressModel-> customer_id = $customerId;
				}
				$result = $customerAddressModel->save();

				if ($customerId && $result ) {
					throw new Exception("DATA SAVED...", 1);
					
				}
				// $this->redirect('customer','grid',null,true);
				
			} catch (Exception $e) {
				$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
				$this->redirect('customer','grid',null,true);
			}
		}

	

	public function deleteAction()
	{
		$request = $this->getRequest();
		$customerId = $request->getParams('id');
		if (!$customerId) {
			$this->error('Request deniad...');
		}
		$customerModel = Ccc::getModel('Customer');
		$customer = $customerModel->load($customerId);
		if (!$customer) {
			$this->error('Data not found...');
		}
		$result = $customerModel->delete();
		if ($result) {
		$message = new Model_Core_Message();
		$message->addMessages("customer delete success","message");
		}

		$this->redirect('customer','grid',null,true);
	}

	public function addressAction()
	{	

		try {
				$id = $this->getRequest()->getParams('id');
				$sql = "SELECT * FROM `customer_address` WHERE `customer_id` = '{$id}'";
				$vendorModel = Ccc::getModel('Customer_Address');
				$address = $vendorModel->fetchRow($sql);
				$layout = $this->getLayout();
				$grid = new Block_Customer_Address_Grid();
				$grid->setData(['address' => $address]);
				$layout->getChild('content')->addChilde('grid',$grid);
				$layout->render();
				
			} catch (Exception $e) {
					$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
					$this->redirect('vendor','grid',null,true);
			}

		
	}

	
}



?>