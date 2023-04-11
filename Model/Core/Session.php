<?php

#get
#set
#unset
#has
#getid
#start
#detsroy
/**
 * 
 */
class Model_Core_Session  
{
	public function start()
	{
		session_start();
	}

	public function getId()
	{
		return session_id();
	}

	public function destroy()
	{
		session_destroy();
	}

	public function set($key,$value)
	{
		$_SESSION[$key] = $value;
	}

	public function get($key)
	{
		if (!$key) {
			return $_SESSION;
		}
		return $_SESSION[$key];
	}

	public function unset($key)
	{
		unset($_SESSION[$key]);
	}

	public function has($key)
	{
		if (!array_key_exists($key,$_SESSION)) {
			return false;
		}
		return true;
	}
	
}


?>