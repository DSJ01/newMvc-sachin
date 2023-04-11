<?php
class Controller_Core_fornt{
	public function fornt()
	{
		$request = new model_core_Request();
		$c = $request->getController();
		// $className = 'product';
		$className = 'Controller_'.ucwords($c);
		$c = str_replace("_", "/",$c);
		$pageName = 'Controller/'.($c).'.php'; 
		// $actionName = 'gridAction';
		$actionName = $request->getActionName().'Action';		
		require_once $pageName;
		$action = new $className();
		$action->$actionName();
	}
}



?>