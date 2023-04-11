<?php
class Controller_Salesman extends Controller_Core_Action{

	public function gridAction()
	{
		try {
			$grid = new Block_Salesman_grid();
			$layout = $this->getLayout();
			$layout ->getChild('content')->addChilde('grid',$grid);
			$layout->render();
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(), MODEL_CORE_MESSAGE::FAILURE);
		}
	}

	public function editAction()
	{
		try {
			$salesmanId = $this->getRequest()->getParams('id');
			if (!$salesmanId) {
					$this->error('Request deniad...');
				}	
			$salesmanModel = Ccc::getModel('Salesman');
			$salesman = $salesmanModel->load($salesmanId);

			$salesmanAddressModel = Ccc::getModel('salesman_Address');
			$sql = "SELECT * FROM `salesman_address` WHERE `salesman_id` = '{$salesmanId}'";
			$salesmanAddress = $salesmanAddressModel->fetchRow($sql);		
			$layout = $this->getLayout();
			$edit = new Block_Salesman_Edit();
			$edit->setData(['salesman' => $salesman, 'salesmanAddress' => $salesmanAddress]);
			$layout->getChild('content')->addChilde('edit',$edit);
			$layout->render();
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function addAction()
	{
		try {
			$salesmanModel = Ccc::getModel('Salesman');
			$salesmanAddressModel = Ccc::getModel('salesman_Address');
			$layout = $this->getLayout();
			$add = new Block_Salesman_Edit();
			$add->setData(['salesman' => $salesmanModel, 'salesmanAddress' => $salesmanAddressModel]);
			$layout->getChild('content')->addChilde('add',$add);
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

				$salesmanData = $this->getRequest()->getPost('salesman');
				if (!$salesmanData) {
					throw new Exception("Data not Posted..", 1);			
				}

				$salesmanAddressData = $this->getRequest()->getPost('salesman_address');
				if (!$salesmanAddressData) {
					throw new Exception("Data not Posted..", 1);			
				}

				$id = $this->getRequest()->getParams('id');
				$salesmanModel = Ccc::getModel('Salesman');
				$salesmanAddressModel = Ccc::getModel('Salesman_Address');
				if ($id) {
					$salesmanModel->load($id);
					$sql = "SELECT * FROM `salesman_address` WHERE `salesman_id` = '{$id}' ";
					$salesmanAddressModel->fetchRow($sql);
					$salesmanAddressModel-> updated_at = date("Y-m-d h:i:sa");
					$salesmanModel -> updated_at = date("Y-m-d h:i:sa");
				}
				else{
				$salesmanModel -> created_at = date("Y-m-d h:i:sa");
				$salesmanAddressModel-> created_at = date("Y-m-d h:i:sa");
				}
				$salesmanModel->setData($salesmanData);
				$salesmanId = $salesmanModel->save();
				if (!$salesmanAddressModel-> salesman_id) {
				$salesmanAddressModel-> salesman_id = $salesmanId;
				}
				$salesmanAddressModel->setData($salesmanAddressData);
				$result = $salesmanAddressModel->save();
				if ($salesmanId && $result ) {
					throw new Exception("DATA SAVED...", 1);
				}
				$this->redirect('salesman','grid',null,true);
				
			} catch (Exception $e) {
				$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
				$this->redirect('salesman','grid',null,true);
			}
		}	

	public function addressAction()
	{
		try {
				$id = $this->getRequest()->getParams('id');
				$vendorModel = Ccc::getModel('Salesman_Address');
				$sql = "SELECT * FROM `salesman_address` WHERE `salesman_id` = '{$id}' ";
				$data = $vendorModel->fetchRow($sql);
				$layout = $this->getLayout();
				$address = new Block_Salesman_Address_Grid();
				$address->setData(['address' => $data]);
				$layout->getChild('content')->addChilde('grid',$address);
				$layout->render();
				
			} catch (Exception $e) {
					$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
					$this->redirect('salesman','grid',null,true);
			}
		
	}

	public function deleteAction()
	{
		$request = $this->getRequest();
		$salesmanId = $request->getParams('id');
		if (!$salesmanId) {
			$this->error('Request deniad...');
		}
		$salesmanModel = Ccc::getModel('Salesman');
		$salesman = $salesmanModel->load($salesmanId);
		if (!$salesman) {
			$this->error('Data not found...');
		}
		$result = $salesmanModel->delete();
		if ($result) {
		$message = new Model_Core_Message();
		$message->addMessages("salesman delete success","message");
		}

		$this->redirect('salesman','grid',null,true);
	}
}

?>