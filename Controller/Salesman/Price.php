<?php
	require_once 'view/html/header.phtml';
	require_once 'Controller/Core/Action.php';
	require_once 'Model/Salesman/Price.php';


	class Controller_Salesman_price extends Controller_Core_Action{

		public $price = [];
		public $salesmanId = [];
		public $salesman = null;

		
		public function gridAction()
		{	
			try {

			$request = $this->getRequest();
			$salesmanId =$request->getParams('id');
			if (!$salesmanId) {
					$this->error('Request deniad...');
				}
			$salesmanModel = Ccc::getModel('Salesman');
			$priceModel = Ccc::getModel('Salesman_Price');
			$sql = "SELECT * FROM `salesman`";
			$salesmanData = $salesmanModel->fetchAll($sql); 

			$joinSql = "SELECT p.product_id, p.name, p.price, sp.salesman_price_id, sp.salesman_price, sp.salesman_id FROM `product` p
				LEFT JOIN `salesman_price` sp ON p.product_id = sp.product_id
				AND sp.salesman_id = '{$salesmanId}'
			";

			$salesmanPrices = $priceModel->fetchAll($joinSql);
			$layout = $this->getLayout();
			$grid = new Block_Salesman_Price_Grid();
			$grid->setData(['salesman'=> $salesmanData, 'salesman_prices'=>$salesmanPrices, 'salesman_id' => $salesmanId]);
			$layout->getChild('content')->addChilde('grid',$grid);
			$layout->render();
				
			} catch (Exception $e) {
				
			}
			
				
		}

		public function updateAction()
		{
			try {

				$request = $this->getRequest();
			$salesmanPrice = $request->getpost('salesman_price');
			$salesmanId = $request->getParams('id');
			if (!$salesmanPrice) {
				$this->error('Request deniad..');
			}
				foreach ($salesmanPrice as $key => $value) {	

			$sql = "SELECT `salesman_price_id` FROM `salesman_price` WHERE `product_id` = '{$key}' 
					AND `salesman_id` = '{$salesmanId}'";
			$priceModel = Ccc::getModel('Salesman_Price'); 
			$price = $priceModel->fetchAll($sql);	
				if ($price) {
					$data = ['salesman_price'=>$value,'product_id'=>$key];
					$priceModel->setData($data);
					$result = $priceModel->save();
					}
					else{
						if ($value != '') {
							$data = ['salesman_price'=>$value,'product_id'=>$key,'salesman_id'=>$salesmanId];
							$priceModel->setData($data);
							$result = $priceModel->save();
							// print_r($result);
						}
					}

				}
					$this->redirect('salesman_price','grid',['id' => $salesmanId],true);
				
			} catch (Exception $e) {
				
					$this->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
					$this->redirect('salesman_price','grid',['id' => $salesmanId],true);
			
			}
			
			
		}



	}

?>