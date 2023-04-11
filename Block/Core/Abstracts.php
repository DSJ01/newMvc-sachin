<?php

class Block_Core_Abstracts extends Model_Core_View
{
	protected $childeren = [];


	function __construct()
	{
		parent::__construct();
	}

	public function setChildern(array $childeren)
	{
		$this->childeren = $childeren;
		return $this;
	}

	public function getChildern()
	
	{
		return $this->childeren;
	}

	public function getChild($key)
	{
		if (array_key_exists($key,$this->childeren)) {
			return $this->childeren[$key];
		}
		return null;
	}

	public function addChilde($key, $value)
	{
		$this->childeren[$key] = $value;
		return $this;	
	}

	public function removeChilde($key)
	{
		if (array_key_exists($key,$this->childeren)) {
		unset($this->childeren[$key]);
		}
		return $this;
	}


	
}
