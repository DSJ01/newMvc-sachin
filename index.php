<?php
// echo "<pre>";
session_start();
require_once 'Model/Core/Message.php';
require_once 'Model/Core/Url.php';
require_once 'Controller/Core/front.php';

spl_autoload_register(function ($className) {
    $className = str_replace("_", "/",$className);
	$pageName = ($className).'.php';
	require_once $pageName;
});

class Ccc
{
	public static function init()
	{
		$front = new Controller_Core_fornt();
		$front->fornt();
	}

	public static function getModel($className)
	{
		
		$className = 'Model_'.$className;
		return new $className();
	}

	public static function getSingleton($className)
	{
		if (array_key_exists($className,$GLOBALS)) {
			return $GLOBALS[$className];
		}
		$GLOBALS[$className] = new $className();
		return $GLOBALS[$className];
		
	}

	public static function getRegistry($key)
	{
		if (array_key_exists($key,$GLOBALS)) {
			return $GLOBALS[$key];
		}
		return null;	
	}

	public static function Regester($key, $value)
	{
		$GLOBALS[$key] = $value; 
	}


}
Ccc::init();
?>