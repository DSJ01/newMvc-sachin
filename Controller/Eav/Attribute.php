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

			$attributeEntity = Ccc::getModel('Eav_Attribute_Entity');
			$sql = "SELECT * FROM `entity_type`";
			$entityData = $attributeEntity->fetchAll($sql);

			$option = Ccc::getModel('eav_Attribute_Option');
			$sql = "SELECT * FROM `eav_attribute_option` WHERE `attribute_id` = '{$attributeId}'";
			$optionData = $option->fetchAll($sql);

			$edit->setData(['attribute' => $attribute, 'entitys' => $entityData, 'options' => $optionData]);
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

			$attributeEntity = Ccc::getModel('Eav_Attribute_Entity');
			$sql = "SELECT * FROM `entity_type`";
			$entityData = $attributeEntity->fetchAll($sql);
			$edit->setData(['attribute' => $attributeModel, 'entitys' => $entityData]);
			$layout->getChild('content')->addChilde('edit',$edit);
			$layout->render();
		}	

	public function saveAction()
		{
			echo "<pre>";

			
			if (!$this->getRequest()->ispost()) {
			throw new Exception("Data not Posted..", 1);			
			}

			if (!($dataAttribute = $this->getRequest()->getPost('attribute'))) {
			throw new Exception("Data not Posted..", 1);			
			}

			$option = $this->getRequest()->getPost('option');
			print_r($option);
			$existOption = null;
			$newOption = null;
			if (array_key_exists('new',$option)) {
			$newOption = $option['new'];
			}

			if (array_key_exists('exist',$option)) {
			$existOption = $option['exist'];
			}

		    $attributeModel = Ccc::getModel('Eav_Attribute');
			$optionModel = Ccc::getModel('eav_Attribute_Option');
			
			if ($id = $this->getRequest()->getParams('id')) {
				$sql = "SELECT * FROM `eav_attribute` WHERE '{$id}' ";
				$attributeModel->fetchRow($sql);
			}
			$attributeModel->setData($dataAttribute);
			$insertId = $attributeModel->save();
			if (!$insertId) {
				$this->error('Data not Inserted');
			}	 

			if (!$attributeModel->attribute_id) {
				$attributeModel->attribute_id = $insertId;
			}
			$attributeId = $attributeModel->attribute_id;
			$where = '';
			if ($existOption) {
				$where = 'AND `option_id` NOT IN ('.implode(',',array_keys($existOption)).')';
				foreach ($existOption as $optionId => $name) {
					$option = Ccc::getModel('eav_Attribute_Option')->load($optionId);
					if (!$option) {
						$this->error('Data not found');
					}
					$option->name = $name;
					if (!$option->save()) {
						$this->error('Data not saved..');
					}
				}
			}

			echo $sql = 'DELETE FROM `eav_attribute_option` WHERE `attribute_id` = "'.$attributeModel->attribute_id.'" '.$where;
			$result = ccc::getModel('Core_Adapter')->delete($sql);
			if (!$result) {
				$this->error('Data not saved..');
			}

			if ($newOption) {
				foreach ($newOption as $optionId => $name){
					$option = Ccc::getModel('eav_Attribute_Option');
					$option->name = $name;
					if (!$option->attribute_id) {
					$option->attribute_id = $attributeId;
					}
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
				$this->error('delete data...');
			}
			$this->redirect('eav_attribute','grid',[],true);
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('eav_attribute','grid',[],true);
		}
	}	
}


?>