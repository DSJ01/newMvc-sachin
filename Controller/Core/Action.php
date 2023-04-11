<?php


	class Controller_Core_Action
	{

		protected $request = null;
		protected $message = null;
		protected $layout = null;

		public function error($error)
		{
			throw new Exception("{$error}", 1);				
		}

		public function redirect($controller,$action,$params = null,$reset = null)
		{
			$url = new Model_Core_Url();
			header('Location:'.$url->getUrl($controller,$action,$params,$reset));
		}	

		public function getTemplete($templet)
		{
			require_once 'view/'.$templet;
		}

		public function setRequest($request)
		{
			$this->request = $request;		
		}

		public function getRequest()
		{
			if ($this->request) {
				return $this->request;
			}	
			$request = new Model_Core_Request();	
			$this->setRequest($request);
			return $request;
		}

		public function getUrl($action = null, $controller = null, $params = null, $reset = false)
		{
			$url = Ccc::getModel('Core_Url');
			$url->getUrl($action, $controller, $params, $reset);
			return $this;
		}

		public function getMessage()
		{
			if ($this->message) {
				return $this->Message;
			}
			$message = Ccc::getModel('Core_Message');
			$this->setMessage($message);
			return $message;
		}

		public function setMessage($message)
		{
			$this->message = $message;
		}

		public function setLayout($layout)
		{
			$this->layout = $layout;
			return $this;
		}

		public function getLayout()
		{
			if ($this->layout) {
				return $this->layout;
			}
			$layout = new Block_Core_Layout();
			$this->setLayout($layout);
			return $layout;
		}

		public function getView()
		{
			return Ccc::getModel('Core_View');
		}		

		public function render()
		{
			$this->getView()->render();
		}	

		
	}


?>