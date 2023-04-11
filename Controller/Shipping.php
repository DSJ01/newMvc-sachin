<?php
class Controller_Shipping extends Controller_Core_Action{

	public function gridAction()
	{
		try {

			$grid = new Block_Shipping_grid();
			$layout = $this->getLayout();
			$layout->getChild('content')->addChilde('grid',$grid);
			$layout->render();

		} catch (Exception $e) {
			$this->getMessage()->addMessage($e->getMessage(), MODEL_CORE_MESSAGE::FAILURE);
		}
	}

	public function editAction()
	{
		try {
			$request = $this->getRequest();
			$shippingId = $request->getParams('id');
			if (!$shippingId) {
				$this->error('Request deniad...');
			}
			$shippingModel = Ccc::getModel('Shipping');
			$shipping = $shippingModel->load($shippingId);
			$edit = new Block_Shipping_Edit();
			$layout = $this->getLayout();
			$edit->setData(['shipping' => $shipping]);
			$layout->getChild('content')->addChilde('edit', $edit);
			$layout->render();
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}


	public function addAction()
	{
		try {

			$shippingModel = Ccc::getModel('Shipping');
			if (!$shippingModel) {
			throw new Exception("Object Not Found", 1);
			}
			$shippingModel = Ccc::getModel('Shipping');
			$edit = new Block_Shipping_Edit();
			$layout = $this->getLayout();
			$edit->setData(['shipping' => $shippingModel]);
			$layout->getChild('content')->addChilde('edit', $edit);
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

			$data = $this->getRequest()->getPost('shipping');
			if (!$data) {
			throw new Exception("Data not Posted..", 1);			
			}

			$id = $this->getRequest()->getParams('id');
			$shippingModel = Ccc::getModel('Shipping');
			if ($id) {
				$shippingModel->load($id);
				$shippingModel-> updated_at = date("Y-m-d h:i:sa");
			}
			$shippingModel-> created_at = date("Y-m-d h:i:sa");
			$shippingModel->setData($data);
			$result = $shippingModel->save();
			if (!$result) {
				throw new Exception("DATA NOT SAVED...", 1);
				
			}
			throw new Exception("DATA SAVED", 1);
			$this->redirect('shipping','grid',null,true);
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('shipping','grid',null,true);
		}
	}

	public function deleteAction()
	{
		try {
		$request = $this->getRequest();
		$shippingId = $request->getParams('id');
		if (!$shippingId) {
			$this->error('Request deniad...');
		}
		$shippingModel = Ccc::getModel('Shipping');
		$shipping = $shippingModel->load($shippingId);
		$result = $shippingModel->delete();

		if (!$result) {
			throw new Exception("DATA NOT DELETED..", 1);
		}
			throw new Exception("DATA DELETED..", 1);
			$this->redirect('shipping','grid',null,true);
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('shipping','grid',null,true);
		}
	}
}



?>	