<?php

class Controller_Product_media extends Controller_Core_Action{

	public $images = [];
	public $imagesId = null;
	public $model = null;

	public function gridAction()
	{	
		try {
			$productId = $this->getRequest()->getParams('id');
			if (!$productId) {
				throw new Exception("request denied..", 1);
			}
			if (!($product = Ccc::getModel('Product')->load($productId))) {
				throw new Exception("Data Not Found", 1);
			}
			
			$layout = $this->getLayout();
			$media = new Block_Product_Media_Grid();
			$media->setData(['product' => $product]);
			$layout->getChild('content')->addChilde('grid',$media);
			$layout->render();
			
		} catch (Exception $e) {
			$this->getMessages()->addMessages($e->getMessage(), MODEL_CORE_MESSAGE::FAILURE);
			$this->redirect('media','grid',null,true);
		}
		
	}

	public function addAction()
	{
			$productId = $this->getRequest()->getParams('id');
			if (!$productId) {
				throw new Exception("request denied..", 1);
			}
			$productimgModel = Ccc::getModel('Product_Media');
			$layout = $this->getLayout();
			$edit = new Block_Product_Media_Edit();
			$edit->setData(['edit'=>$productimgModel , 'productid' => $productId]);
			$layout->getChild('content')->addChilde('edit', $edit);

			$layout->render();
	}

	public function insertAction()
	{

		try {
			$request = $this->getRequest();
		$productId = $request->getParams('id');
			
		$productImg = $request->getpost('img');
		$productimgRow = Ccc::getModel('Product_Media');
		$productImgRow->setData($productImg);
		$productImgRow->created_at = date('Y-m-d h:i:sa');
		$productImgRow->product_id = $productId;
		$mediaModel = Ccc::getModel('Media_Resource');
		$mediaId = $mediaModel->save();
		
			$file = $_FILES['img']['name']; 		
			$fileTemp = $_FILES['img']['tmp_name'];

			$divide = 	explode('.',$file);
			$fileName =  $mediaId.'.'.$divide[1];

			move_uploaded_file($fileTemp, 'view/product_media/media/'.$fileName ); 	
			$file = $fileName;
			print_r($file);	
			$productImgRow-> image 	= $file;
			$productImgRow-> product_media_id 	= $mediaId;

			$this->getRowModel()->save($mediaId);
			$this->redirect('product_media','grid',['id'=>$productId],true);
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('product','grid',null,true);
		}

		
	}


	public function updateAction()
	{
		try {



			$request = $this->getRequest();
			$productId = $request->getParams('id');
			if (!$productId) {
				$this->error('Invalid Request !!');
			}

			if (!($product = Ccc::getModel('Product')->load($productId))) {
				$this->error('Product data not found !!!');
			}

			if (!$request->isPost()) {
				$this->error('Invalid request !!!');
			}

			$data = $request->getPost();
			if (array_key_exists('base',$data)) {
				$product->base = $data["base"];
			}

			if (array_key_exists('thumnail',$data)) {	
				$product->thumb = $data["thumnail"];
			}

			if (array_key_exists('small',$data)) {
				$product->small = $data["small"];
			}	

			if (!($product->save())) {
				$this->error('failed to save data !!!');
			}
	
			// $basicData = ['gallary'=>0];
			// $productMediaModel = Ccc::getModel('Product_Media'); 
			// $condition = ['product_id'=>$productId];
			// echo '<pre>';
			// print_r($productMediaModel->setData($basicData));
			// $result = $productMediaModel->save($condition);	
			// die;

			if (array_key_exists('gallary',$data)) {
				$condition = $data["gallary"];
				$gallary = Ccc::getModel('Product_Media');
				$gallary->setData(['gallary'=>1]);
				$gallary->product_media_id = '';
				$result = $gallary->save($condition);
				if (!$result) {
					$this->error('failed to save data !!!');
				}
			}

			$this->getMessage()->addMessage('Data Saved Successfully..!!');
			$this->redirect('grid',null,null);
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('product','grid',null,true);
		}
		

		}


}
		

	




?>
