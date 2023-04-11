<?php
class Controller_Product extends Controller_Core_Action{

	protected $products = [];
	protected $rowModel = null;

	public function gridAction()
	{
		try {
			$grid = new Block_Product_grid();
			$layout = $this->getLayout();
			$layout ->getChild('content')->addChilde('grid',$grid);
			$layout->render();		
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(), MODEL_CORE_MESSAGE::FAILURE);
		}
	}
	
	public function editAction()
	{	
		try{
			$request = $this->getRequest();
			$productId = $request->getParams('id');
			if (!$productId) {
				$this->error('Request deniad....');
			}
			$product = Ccc::getModel('product')->load($productId);
			if (!$product) {
				$this->error('Data not Fetched...');
			}
			$layout = $this->getLayout();
			$edit = new Block_Product_Edit();
			$edit->setData(['product' => $product]);
			$layout->getChild('content')->addChilde('edit',$edit);
			$layout->render();
		}
		catch(Exception $e){
			$this->getMessage()->addMessages($e->getMessage(), MODEL_CORE_MESSAGE::FAILURE);
			$this->redirect('product','grid',null,true);
		}
	}

	public function addAction()
	{
		try {
			$productModel = Ccc::getModel('product');
			$view = $this->getView();
			$layout = $this->getLayout();
			$edit = new Block_Product_Edit();
			$edit->setData(['product' => $productModel]);
			$layout->getChild('content')->addChilde('edit',$edit);
			$layout->render();
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(), MODEL_CORE_MESSAGE::FAILURE);
			$this->redirect('product','grid',null,true);
		}
	}
	
	public function saveAction()
	{
		try {

			if (!$this->getRequest()->ispost()) {
			throw new Exception("Data not Posted..", 1);			
					}

			$data = $this->getRequest()->getPost('product');
			if (!$data) {
			throw new Exception("Data not Posted..", 1);			
			}

			$id = $this->getRequest()->getParams('id');
			$productModel = Ccc::getModel('Product');
			if ($id) {
				$productModel->load($id);
				$productModel-> updated_at = date("Y-m-d h:i:sa");
			}
			$productModel-> created_at = date("Y-m-d h:i:sa");
			$productModel->setData($data);
			$result = $productModel->save();
			if (!$result) {
				throw new Exception("DATA NOT SAVED...", 1);
			}
			throw new Exception("DATA SAVED", 1);
			$this->redirect('product','grid',null,true);
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('product','grid',null,true);
		}
	}


	public function deleteAction()
	{
		try {
			$request = $this->getRequest();
			$productId = $request->getparams('id');
			if (!$productId) {
				$this->error('Request deniad...');
			}
			$productModel = Ccc::getModel('Product')->load($productId);
			$result = $productModel->delete();
			if (!$result) {
				throw new Exception("DATA NOT DELETE", 1);
			}
				throw new Exception("DATA DELETE", 1);


			
		} catch (Exception $e) {
				
			$this->getMessage()->addMessages($e->getMessage(), MODEL_CORE_MESSAGE::FAILURE);
			$this->redirect('product','grid',null,true);
		}
			
	}
}

?>
