<?php

class Controller_Admin extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$grid = new Block_Admin_grid();
			$layout = $this->getLayout();
			$layout->getChild('content')->addChilde('grid',$grid);
			$layout->render();
			
		} catch (Exception $e) {
				
		}

	}

	public function editAction()
	{
		try {

			$request = $this->getRequest();
			$adminId = $request->getParams('id');
			if (!$adminId) {
				$this->error('Request deniad...');
			}
			$adminModel = Ccc::getModel('Admin');
			$admin = $adminModel->load($adminId);
			$edit = new Block_Admin_Edit();
			$layout = $this->getLayout();
			$edit->setData(['admin' => $admin]);
			$layout->getChild('content')->addChilde('edit', $edit);
			$layout->render();
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('admin','grid',null,true);
		}
	}

	public function addAction()
	{
		try {
			$adminModel = Ccc::getModel('Admin');
			$add = new Block_Admin_Edit();
			$add->setData(['admin' => $adminModel]);
			$layout = $this->getLayout();
			$layout->getChild('content')->addChilde('edit',$add);
			$layout->render();
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('admin','grid',null,true);
		}
	}

	public function saveAction()
	{

		try{

		if (!$this->getRequest()->ispost()) {
			throw new Exception("Data not Posted..", 1);			
		}

		$data = $this->getRequest()->getPost('admin');
		if (!$data) {
			throw new Exception("Data not Posted..", 1);			
		}

		$id = $this->getRequest()->getParams('id');
		$adminRow = Ccc::getModel('Admin');
		if ($id) {
			$admin = $adminRow->load($id);
		}
		$adminRow->setData($data);
		$adminRow->save();
		$this->redirect('admin','grid',null,true);

	}catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('admin','grid',null,true);
		}


	}


	public function deleteAction()
	{
		try {

			$id = $this->getRequest()->getParams('id');
			if (!$id) {
				throw new Exception("Request deniad..", 1);			
			}
			$admin = Ccc::getModel('Admin')->load($id);
			$admin->delete();
			$this->redirect('admin','grid',null,true);
				
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('admin','grid',null,true);
		}
	}
	
}

?>