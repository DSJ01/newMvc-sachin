<?php

class Model_Core_View
{
	protected $data = [];
	protected $template;

	function __construct()
	{
		
	}
	
	public function addData($key,$value)
	{
		$this->data[$key] = $value;
		return $this;
	}

	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}

	public function getData($key = NULL)
	{
		if (!$key) {
			return $this->data;
		}
		if (array_key_exists($key,$this->data)) {
			return $this->data[$key];
		}
		return false;
	}

	public function getTemplate()
	{
		return $this->template;
	}

	public function setTemplate($template)
	{
		$this->template = $template;
		return $this;
	}

	public function render()
	{
		require_once 'View/'.$this->getTemplate();
	}
}


?>