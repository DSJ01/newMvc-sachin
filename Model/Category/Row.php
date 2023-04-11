<?php


class Model_Category_Row extends Model_Core_Table_Row
{
	
		protected $tableClass = 'Model_Category';

		public function getPathName()
    	{
       	$query = "SELECT `category_id` , `name` FROM `category` WHERE `parent_id` IS NOT NULL ";
        $categories = Ccc::getModel('Core_Adapter')->fetchPairs($query);
        $path = '';
        foreach (explode('=',$this->path) as $id) {
            if (array_key_exists($id,$categories)) {
               echo $path .= $categories[$id].'=>';
            }
        }
        return rtrim($path,'=>');
    	}

		public function getParentCategory()
		{
			$sql = "SELECT `category_id`,`name` FROM `category`";
			$categories = Ccc::getModel('Core_Adapter')->fetchPairs($sql);
			$path = '';
			if ($this->category_id) {
				 $path = $this->path;
			$sql = "SELECT `category_id`,`path` FROM `category` WHERE `path` NOT LIKE '{$path}%' ";
			}else{
				$sql = "SELECT `category_id`,`path` FROM `category`";
			}

       		$parentCategories = $this->getModel()->getAdapter()->fetchPairs($sql);
        	foreach ($parentCategories as $categoryId => &$pathName) {
            $path = '';

            foreach (explode('=',$pathName) as $id) {
                if (array_key_exists($id,$categories)) {
                   $path .= $categories[$id].'=>';
                }
            }
            $pathName = $path;
        	}
        	return $parentCategories;
		}

		public function updatePath()
    	{
	        if (!$this->getId()) {
	            return false;
	        }

	        $oldPath = $this->path;
	        $parent = Ccc::getModel('Category_Row')->load($this->parent_id);
	        if(!$parent){
	          $this->path = $this->getId().'=';
	        }else{
	          echo $this->path = $parent->path . $this->getId().'=';
	        }

	        $this->save();
	        $query = "UPDATE `category` SET `path` = '{$this->path}' WHERE `path` LIKE '{$oldPath}%' ";
	        if (!($result = Ccc::getModel('Core_Adapter')->update($query))) {
	            $this->getMessage()->addMessage('Path is not Updated!!!');
	        }

	        return $this;
    	}

    	public function getStatus()
	{
		if ($this->status) {
			return $this->status;
		}
		return Model_Category::STATUS_DEFAULT;
	}
	
	public function getStatusText()
	{
		$statuses = $this->getModel()->getStatusOptions();
		if (array_key_exists($this->status,$statuses)) {
			return $statuses[$this->status];
		}
		return $statuses[Model_Category::STATUS_DEFAULT];
	}
}
?>