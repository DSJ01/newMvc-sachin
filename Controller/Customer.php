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
					echo "<pre>";
					$customerModel->load($id);
					$shippingAddress = $customerModel->getShippingAddress();
					// print_r($shippingAddress); die();
					$sql = "SELECT * FROM `customer_address` WHERE `customer_id` = '{$id}' AND `customer_address_id` = '{$shippingAddress->customer_address_id}' ";
					$shippingModel->fetchRow($sql);
					$shippingModel-> updated_at = date("Y-m-d h:i:sa");
					$customerModel -> updated_at = date("Y-m-d h:i:sa");

					$billingAddress = $customerModel->getBillingAddress();
					$sql = "SELECT * FROM `customer_address` WHERE `customer_id` = '{$id}' AND `customer_address_id` = '{$billingAddress->customer_address_id}' ";
					$billingModel->fetchRow($sql);
					$billingModel-> updated_at = date("Y-m-d h:i:sa");
					unset($customerModel->billing_address_id);
					unset($customerModel->shipping_address_id);

				}
				else{
				$customerModel -> created_at = date("Y-m-d h:i:sa");
				$shippingModel-> created_at = date("Y-m-d h:i:sa");
				$billingModel-> created_at = date("Y-m-d h:i:sa");
				}
				$customerModel->setData($customerData);
				$customerId = $customerModel->save();

				$shippingModel->setData($shippingAddressData);
				if (!$shippingModel->customer_id) {
				$shippingModel-> customer_id = $customerId;
				}
				$shippingId = $shippingModel->save();

				$billingModel->setData($billingAddressData);
				if (!$billingModel->customer_id) {
				$billingModel-> customer_id = $customerId;
				}
				$billingId = $billingModel->save();

				if (!$billingModel->customer_address_id) {
					$customerModel->shipping_address_id = $shippingId;
				}

				if (!$shippingModel->customer_address_id) {
					$customerModel->billing_address_id = $billingId;
				}

				if (!$customerModel->customer_id) {
					$customerModel->customer_id = $customerId;
				}
				
				if (!$customerModel->save()) {
					$this->error('data not saved');
				}
				$this->getMessage()->addMessages('Data Saved..');
				
				$this->redirect('customer','grid',null,true);
				
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