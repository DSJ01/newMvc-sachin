 <?php
class Model_Core_Request
{
	public function isPost()
	{
		if ($_SERVER['REQUEST_METHOD'] != "POST") 
		{
			return false;
		}
		return true;
	}

	public function getPost($key = NULL , $value = NULL)
	{
		if ($key == NULL) 
		{
			return $_POST;
		}
		if (!array_key_exists($key,$_POST))
		 {
		 	return $value;
		 }
			return $_POST[$key];
	}

	public function getParams($key = NULL , $value = NULL)
	{
		if ($key == NULL) 
		{
			return $_GET;
		}

		if (!array_key_exists($key, $_GET))
		 {
		 	return $value;
		 }
		return $_GET[$key];
	}

	public function getActionName()
	{
		return $this->getParams('a','index');
	}

	public function getController()
	{
		return $this->getParams('c','index');
	}	

}
?>