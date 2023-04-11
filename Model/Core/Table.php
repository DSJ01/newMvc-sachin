<?php

class Model_Core_Table
{
	protected $data = [];
	protected $resourceClass = null;
	protected $resource = null;
	protected $collectionClass = null;
	protected $collection = null;
	protected $id = null;

	public function __set($key,$value)
	{
		$this->data[$key] = $value;
	}

	public function __get($key)
	{
		if (!$key) {
		return $this->data;
		}
		if ($key) {
			if (!array_key_exists($key,$this->data)) {
				return null;
			}
			return $this->data[$key];
		}
	}

	public function getId()
	{
		if ($this->id) {
			return $this->id;
		}
		if (array_key_exists($this->getResource()->getPrimaryKey(),$this->data)) {
			return $this->data[$this->getResource()->getPrimaryKey()];
		}
		return false;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function __unset($key)
	{
		unset($this->data[$key]);
		return $this;
	}

	public function setResource($resource)
	{
		$this->resource = $resource;
	}

	public function getResource()
	{
		if ($this->resource) {
			return $this->resource;
		}
		// print_r($this->resourceClass); die();
		$resourceClass = $this->resourceClass;
		$resource = new $resourceClass;
		$this->setResource($resource);
		return $resource;
	}

	public function setCollection($collection)
	{
		$this->collection = $collection;
	}

	public function getCollection()
	{
		if ($this->collection) {
			return $this->collection;
		}

		$collectionClass = $this->collectionClass;
		$collection = new $collectionClass;
		$this->setResource($collection);
		return $collection;
	}

	public function setData($data)
	{
		$this->data = array_merge($this->data, $data);
		return $this;
	}

	public function getData($key = null)
	{
		if ($key == null) {
			return $this->data;
		}
		if ($key) {
			if (!array_key_exists($key,$this->data)) {
				return null;
			}
			return $this->data[$key];
		}
	}

	public function addData($key,$value)
	{
		$this->data[$key] = $value;
		return $this;
	}

	public function removeData($key)
	{
		unset($this->data[$key]);
		return $this;
	}


	public function save($condition = null)
	{
		if (array_key_exists($this->getResource()->getPrimaryKey(),$this->getData())) {
			if (!$condition) {
				$condition = $this->getData($this->getResource()->getPrimaryKey());	
			}
			$result = $this->getResource()->update($this->getData(),$condition);
			return $result;
		}
		$insertId = $this->getResource()->insert($this->getData());
		return $insertId;
	}


	public function fetchAll($sql)
	{
		$datas = $this->getResource()->fetchAll($sql);
		if (!$datas) {
			return false;
		}	
		foreach($datas as &$data){
			$data = (new $this)->setData($data);
		}
		$this->setData($datas);

		return $this->getCollection()->setData($datas);
		// return $this;
		}

	public function fetchRow($sql)
	{
		$data = $this->getResource()->fetchRow($sql);
		if ($data) {
			$data = $this->setData($data);
		}
		return $this;
	}

	public function load($id,$column = null)
	{
		$data = $this->getResource()->load($id);
		if ($data) {
			$this->setData($data);
		}
		return $this;
	}

	public function delete()
	{
		$primaryKey = $this->getResource()->getPrimaryKey();
		echo $this->getData($primaryKey);
		if (array_key_exists($primaryKey,$this->getData())) {
			$result = $this->getResource()->delete($this->getData($primaryKey));
			return $result;
		}
	}
}
?>