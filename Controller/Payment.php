<?php

require_once 'core/Action.php';
require_once 'model/payment.php';

class Controller_Payment extends Controller_Core_Action{

	
	public function gridAction()
	{
		try {
			$grid = new Block_Payment_grid();
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
			$paymentModel = Ccc::getModel('Payment');
			$add = new Block_Payment_Edit();
			$add->setData(['payment' => $paymentModel]);
			$layout = $this->getLayout();
			$layout->getChild('content')->addChilde('edit',$add);
			$layout->render();
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('payment','grid',null,true);
		}
	}

	public function editAction()
	{
		try {

			$request = $this->getRequest();
			$paymentId = $request->getParams('id');
			if (!$paymentId) {
				$this->error('Request deniad...');
			}
			$paymentModel = Ccc::getModel('Payment');
			$payment = $paymentModel->load($paymentId);
			$edit = new Block_Payment_Edit();
			$layout = $this->getLayout();
			$edit->setData(['payment' => $payment]);
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

			$data = $this->getRequest()->getPost('payment');
			if (!$data) {
			throw new Exception("Data not Posted..", 1);			
			}

			$id = $this->getRequest()->getParams('id');
		    $paymentModel = Ccc::getModel('Payment');
		    if ($id) {
			$paymentModel->load($id);
			}
			$paymentModel->setData($data);
			$result = $paymentModel->save();

			if (!$result) {
				throw new Exception("DATA NOT SAVED...", 1);
				
			}
			throw new Exception("DATA SAVED...", 1);
			$this->redirect('payment','grid',null,true);

		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('payment','grid',null,true);
		}
	}

	public function deleteAction()
	{
		try {
			$request = $this->getRequest();
			$paymentId = $request->getParams('id');
			if (!$paymentId) {
				throw new Exception("Invelid request..", 1);
			}
			$paymentModel = Ccc::getModel('payment');
			$payment = $paymentModel->load($paymentId);
			if (!$payment) {
				throw new Exception("Data not found....", 1);
			}
			$result = $paymentModel->delete();
			if (!$result) {
				throw new Exception("DATA NOT DELETED...", 1);
			}
			throw new Exception("DATA DELETED...", 1);
			$this->redirect('payment','grid',null,true);
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('payment','grid',null,true);
		}
	}
}
?>