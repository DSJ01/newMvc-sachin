	<?php
	class Model_Core_Table_Resource 
	{
		protected $tableName = null;
		protected $primaryKey = null;
		protected $adapter = null;


		public function setTableName($tableName)
		{
			$this->tableName = $tableName;
		}
		public function getTableName()
		{
			return $this->tableName;
		}
		public function setPrimaryKey($primaryKey)
		{
			$this->primaryKey = $primaryKey;
		}
		public function getPrimaryKey()
		{
			return $this->primaryKey;
		}
		public function setAdapter($adapter)
		{
			$this->adapter = $adapter;
		}
		public function getAdapter()
		{
			if ($this->adapter) {
				return $this->adapter;
			}
			$adapter = new Model_Core_Adapter();
			$this->setAdapter($adapter);
			return $adapter;
		}

		public function fetchAll($query)
		{
			$adapter = $this->getAdapter();
			$result = $adapter->fetchAll($query);
			return $result;
		}

		public function fetchRow($query)
		{
			$adapter = $this->getAdapter();
			$result = $adapter->fetchRow($query);
			return $result;
		}

		public function load($id)
		{
			$adapter = $this->getAdapter();
			$sql = "SELECT * FROM `{$this->tableName}` WHERE  `{$this->primaryKey}` = {$id}";
			$data = $adapter->fetchRow($sql);
			return $data;
		}
		

		public function insert($data)
		{
			$columns = "`" . implode("`,`", array_keys($data))."`";
			$values = "'" . implode("', '", array_values($data)). "'";
		echo $sql = "INSERT INTO `{$this->tableName}` ({$columns}) VALUES ({$values})";
			$adapter = $this->getAdapter();
			$result = $adapter->insert($sql);
			return $result;  
		}

		public function update($data, $condition)
		{
			$set = "";
		foreach ($data as $column => $value) {
		  $set .= '`'.$column.'` = "'.$value.'",';
		}
		
		$set = rtrim($set, ", ");
		$where = "";
		if (is_array($condition)) {
			foreach ($condition as $column => $value) {
				$where .= '`'.$column.'` = "'.$value.'" AND ' ;
			}
		}else{
			$where = '`'.$this->primaryKey.'` = "'.$condition.'"'; 
		}

		$where = rtrim($where, " AND ");
		echo $query = 'UPDATE `'.$this->tableName.'` SET '.$set.' WHERE '.$where;
		$adapter = $this->getAdapter();
		$result = $adapter->update($query);
		return $result;

			
		}


		public function delete($condition)
		{
		
		$where = "";
		if (is_array($condition)) {
			foreach ($condition as $column => $value) {
				$where .= '`'.$column.'` = '.$value.' AND ' ;
			}
		}else{
			$where = '`'.$this->primaryKey.'` = '.$condition; 
		}

			$where = rtrim($where, " AND ");
			$sql = "DELETE FROM `{$this->tableName}` WHERE {$where}";
			$adapter = $this->getAdapter();
			$result = $adapter->delete($sql);
			return $result; 		
		}


		public function updateG($data, $condition)
		{
			$set = "";
		foreach ($data as $column => $value) {
		  $set .= '`'.$column.'` = "'.$value.'",';
		}
		$set = rtrim($set, ", ");

		$where = "";
		if (is_array($condition)) {
			
				$ids = join(',',$condition);
				$where = '`'.$this->primaryKey.'` IN ('.$ids.')';
		}
		$where = rtrim($where, " AND ");
		echo $query = 'UPDATE `'.$this->tableName.'` SET '.$set.' WHERE '.$where;
		$adapter = $this->getAdapter();
		$result = $adapter->update($query);
		return $result;
		}
	}
?>