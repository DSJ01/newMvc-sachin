<?php

class Controller_Eav_Attribute extends Controller_Core_Action
{
	public function gridAction()
		{
			$layout = $this->getLayout();
			$grid = new Block_Eav_Attribute_Grid();
			$layout->getChild('content')->addChilde('grid', $grid);
			$layout->render();
		}	


	public function editAction()
		{
		try {
			$attributeId = $this->getRequest()->getParams('id');
			if (!$attributeId) {
				$this->error('Request deniad...');
			}
			$attribute = Ccc::getModel('Eav_Attribute');
			if (!$attribute) {
				throw new Exception("Object not found", 1);
			}
			$layout = $this->getLayout();
			$edit = new Block_Eav_Attribute_Edit();
			$attribute = Ccc::getModel('Eav_Attribute')->load($attributeId);
			$edit->setData(['attribute' => $attribute]);
			$layout->getChild('content')->addChilde('edit',$edit);
			$layout->render(); 
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			
		}

		}

	public function addAction()
		{
			$attribute = Ccc::getModel('Eav_Attribute');
			if (!$attribute) {
				throw new Exception("Object not found", 1);
			}
			$layout = $this->getLayout();
			$edit = new Block_Eav_Attribute_Edit();
			$attributeModel = Ccc::getModel('Eav_Attribute');
			$edit->setData(['attribute' => $attributeModel]);
			$layout->getChild('content')->addChilde('edit',$edit);
			$layout->render();
		}	

	public function saveAction()
		{
			echo "<pre>";
			
			if (!$this->getRequest()->ispost()) {
			throw new Exception("Data not Posted..", 1);			
			}

			$dataAttribute = $this->getRequest()->getPost('attribute');
			if (!$dataAttribute) {
			throw new Exception("Data not Posted..", 1);			
			}
			$option = $this->getRequest()->getPost('option');
			if (!$option) {
			throw new Exception("Data not Posted..", 1);			
			}
			$newOption = $option['option']['new'];
			$existOption = $option['option']['exist'];

		    $attributeModel = Ccc::getModel('Eav_Attribute');
			$optionModel = Ccc::getModel('eav_Attribute_Option');
			
			if ($id = $this->getRequest()->getParams('id')) {
				if ($attributeModel->load($id)) {
					$this->error('Data Not Found');
				}
			}
		    
			$attributeModel->setData($dataAttribute);
			$insertId = $attributeModel->save();
			if (!$insertId) {
				 	$this->error('Data NOt Inserted');
				 }	 

			if (!$optionModel->attribute_id) {
				$optionModel->attribute_id = $insertId;
			}
			$optionId = $optionModel->attribute_id;

			$where = "";
			if ($existOption) {
				$ids = implode(',', array_keys($existOption));
				$where = AND `option_id` NOT IN ($ids);
			}

			$sql = "DELETE FROM `eav_attribute_option` WHERE `attribute_id` = '{$optionId}' .$where"



			if ($newOption) {
				foreach ($newOption as $optionnId => $name){
					$option = Ccc::getModel('eav_Attribute_Option');
					$option->name = $name;
					$option->attribute_id = $insertId;
					$option->save();
				}
			}

		}	


		public function deleteAction()
	{
		try {
			$id = $this->getRequest()->getParams('id');
			if (!$id) {
				$this->error('Invalid request...');
			}
			$attribute = Ccc::getModel('Eav_Attribute');
			$data = $attribute->load($id);
			$result = $attribute->delete();
			if ($result) {
				$this->error('Failed to delete data!!!');
			}
			$this->redirect('eav_attribute','grid',[],true);
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('eav_attribute','grid',[],true);
		}
	}	
}


?>