<?php

	class Controller_Category extends Controller_Core_Action {

		public $category = [];

		public function gridAction()
			{
				try {
					$grid = new Block_Category_grid();
					$layout = $this->getLayout();
					$layout ->getChild('content')->addChilde('grid',$grid);
					$layout->render();
					
					
				} catch (Exception $e) {
					$this->getMessage()->addMessage($e->getMessage(), MODEL_CORE_MESSAGE::FAILURE);
				}
			}
 
		public function editAction()
			{	
				try {
					$request = $this->getRequest();
					$id = $request->getParams('id');
					if (!$id) {
						$this->error('Request deniad...');
					}
					$categoryModel = Ccc::getModel('Category');
					$category = $categoryModel->load($id);
					$layout = $this->getLayout();
					$edit = new Block_Category_Edit();
					$edit->setData(['category' => $category]);
					$layout->getChild('content')->addChilde('edit',$edit);
					$layout->render();	
						
					
				} catch (Exception $e) {
					$this->getMessage()->addMessage($e->getMessage(), MODEL_CORE_MESSAGE::FAILURE);
				}
						
			}		

		
		public function addAction()
			{
				try {

				$category = Ccc::getModel('Category');
				if (!$category) {
					throw new Exception("Object not found", 1);
				}
				$add = new Block_Category_Edit();
				$add->setData(['category' => $category]);
				$layout = $this->getLayout();
				$layout->getChild('content')->addChilde('edit',$add);
				$layout->render();
				
			} catch (Exception $e) {
					$this->getMessage()->addMessage($e->getMessage(), MODEL_CORE_MESSAGE::FAILURE);
			}
			}

		public function saveAction()
			{
				try {
					if (!$this->getRequest()->ispost()) {
					throw new Exception("Data not Posted..", 1);			
					}

					$data = $this->getRequest()->getPost('category');

					if (!$data) {
						throw new Exception("Data not Posted..", 1);			
					}

					$id = $this->getRequest()->getParams('id');
					$categoryModel = Ccc::getModel('Category');
					if ($id) {
						$categoryModel = $categoryModel->load($id);
					}
					$categoryModel->setData($data);
					// print_r($categoryModel);
					// die;
					$categoryModel->save();
					$categoryModel->updatePath();
					// $this->redirect('category','grid',null,true);
				} catch (Exception $e) {
					$this->getMessage()->addMessage($e->getMessage(), MODEL_CORE_MESSAGE::FAILURE);
					// $this->redirect('category','grid',null,true);
				}
			}

		public function deleteAction()
			{
				try {
					$request = $this->getRequest();
					$id = $request->getParams('id');
					if (!$id) {
						$this->error('Request deniad...');
					}
					$categoryModel = Ccc::getModel('Category');
					$category = $categoryModel->load($id);	
					$categoryModel->delete();
					
					$this->redirect('category','grid',null,true);
					
				} catch (Exception $e) {
					$this->getMessage()->addMessage($e->getMessage(), MODEL_CORE_MESSAGE::FAILURE);
					$this->redirect('category','grid',null,true);
				}
				
			}	
	}
?>