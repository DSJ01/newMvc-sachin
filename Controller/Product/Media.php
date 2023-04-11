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
			$sql = "SELECT * FROM `product_media` WHERE `product_id` = '{$productId}'";
			$productimgModel = Ccc::getModel('Product_Media');
			$productimg = $productimgModel->fetchAll($sql);
			$layout = $this->getLayout();
			$media = new Block_Product_Media_Grid();
			$media->setData(['productimg' => $productimg, 'productid' => $productId]);
			$layout->getChild('content')->addChilde('edit',$media);
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
			// echo "<pre>";
			// print_r($layout); die();

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
		// try {

		// $productModel =Ccc::getModel('Product_Media'); 
		// $request = $this->getRequest();	
		// $productId = $request->getParams('id');
		// $productMediaId = $request->getPost('image');
		// $basicData = ['base'=>0,'thumnail'=>0,'small'=>0,'gallary'=>0];
		// $condition = ['product_id'=>$productId];
		// $result = $productModel->save($basicData,$condition);	
		// $condition = ['product_media_id'=>$productMediaId];


		// $images = $request->getpost();

		// if (array_key_exists('base',$images)) 
		// {
		// 	$base =Ccc::getModel('Product_Media'); 
		// 	$base->setData(['base'=>1]);
		// 	$base->product_media_id = $data['base'];
		// 	$result = $base->save();
		// }

		// if (array_key_exists('small',$images)) 
		// {
		// 	$small =Ccc::getModel('Product_Media'); 
		// 	$small->setData(['small'=>1]);
		// 	$small->product_media_id = $data['small'];
		// 	$result = $small->save();
		// }

		// if (array_key_exists('thumnail',$images)) {	
		// 	$thumnail =Ccc::getModel('Product_Media'); 
		// 	$thumnail->setData(['thumnail'=>1]);
		// 	$thumnail->product_media_id = $data['thumnail'];
		// 	$result = $thumnail->save();
		// }	

		// if (array_key_exists('gallery',$images)) {
		// 	$condition = $data['gallary'];
		// 	$gallary =Ccc::getModel('Product_Media'); 
		// 	$gallary->setData(['gallary'=>1]);
		// 	$gallary->product_media_id = $data['gallary'];
		// 	$result = $gallary->save();

		// $this->redirect('product_media','grid',['id'=>$productId],true);

			
		// } catch (Exception $e) {
		// 	$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		// 		$this->redirect('product','grid',null,true);
		// }
		

		}


}
		

	}

	




?>
