<?php

class Block_Core_Grid extends Block_Core_Abstracts
{
	public $columns = [];
	public $actions = [];
	public $buttons = [];
	public $title = null;

	function __construct()
	{
		$this->_prepareActions();
		$this->_prepareCollumns();
		$this->_prepareButtons();
		$this->setTemplate('core/grid.php');

	}

	public function setCollumns(array $columns)
	{
		$this->columns = $columns;
		return $this;
	}

	public function getCollumns()
	{
		return $this->columns;
	}

	public function addCollumn($key,$value)
	{
		$this->columns[$key] = $value;
		return $this;
	}

	public function getCollumn($key)
	{
		if (array_key_exists($key,$this->columns)) {
			return $this->columns[$key];
		}
		return null;
	}

	public function removeCollumn($key)
	{
		unset($key,$this->columns);
		return $this;
	}

	protected function _prepareCollumns()
	{
		return $this;
	}




	public function setActions($action)
	{
		$this->action = $action;
		return $this;
	}

	public function getActions()
	{
		return $this->actions;
	}

	public function addAction($key,$value)
	{
		$this->actions[$key] = $value;
		return $this;
	}

	public function getAction($key)
	{
		if (array_key_exists($key,$this->actions)) {
			return $this->actions[$key];
		}
		return null;
	}

	public function removeActiob($key)
	{
		unset($key,$this->actions);
		return $this;
	}



	protected function _prepareActions()
	{
		return $this;
	}


	public function setButtons($action)
	{
		$this->button = $button;
		return $this;
	}

	public function getButtons()
	{
		return $this->buttons;
	}

	public function addButton($key,$value)
	{
		$this->buttons[$key] = $value;
		return $this;
	}

	public function getButton($key)
	{
		if (array_key_exists($key,$this->buttons)) {
			return $this->buttons[$key];
		}
		return null;
	}

	public function removeButton($key)
	{
		unset($key,$this->buttons);
		return $this;
	}

	protected function _prepareButtons()
	{
		return $this;
	}


	public function setTitle()
	{
		$this->title = $title;
		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}



}



?>