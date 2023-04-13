<?php

class Model_Core_Adapter{

	public $servername = "localhost";
	public $username = "root";
	public $password = "";
	public $database = "newmvc-sachin";

	public function connection()
	{
		$conn = mysqli_connect($this->servername,$this->username,$this->password,$this->database);
		if (!$conn) {
			echo "error";			
		}
		return $conn;
	}

	public function insert($query)
	{
		$connection = $this->connection();
		$result = $connection->query($query);
		if(!$result){
			return false;
		}
		return $connection->insert_id;
	}

	public function fetchAll($query)
	{
		$connection = $this->connection();
		$result = $connection->query($query);
		$data = $result->fetch_all(MYSQLI_ASSOC);
		return $data;
	}
	public function fetchRow($query)
	{
		$connection = $this->connection();
		$result = $connection->query($query);
		$data = $result->fetch_assoc();
		return $data;
	}
	public function update($query)
	{
		$connection =$this->connection();
		$result = $connection->query($query);
		if(!$result){
			return false;
		}
		return true;
	}
	public function delete($query)
	{
		$connection = $this->connection();
		$result = $connection->query($query);
		if(!$result){
			return false;
		}
		return true;
	}

	public function fetchPairs($sql)
	{
		$connection = $this->connection();
		$result = $connection->query($sql);
		if (!$result) {
			return false;
		}
		$data = $result->fetch_all();
		$column1 = array_column($data, '0');
		$column2 = array_column($data, '1');
		if (!$column2) {
			$column2 = array_fill(0, count($column1), null);
		}
		return array_combine($column1, $column2);
	}
	
	public function fetchOne($sql)
	{
		$connection = $this->connection();
		$result = $connection->query($query);
		if (!$result) {
			return false;
		}
		$row = $result->fetch_array();
		return(array_key_exists(0,$row)) ? $row[0] : null;
	}
}



?>