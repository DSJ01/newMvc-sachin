<?php

class Model_Shipping_Row extends Model_Core_Table_Row
{
    protected $tableClass = 'Model_Shipping';

    public function getStatus()
	{
		if ($this->status) {
			return $this->status;
		}
		return Model_Shipping::STATUS_DEFAULT;
	}
	
	public function getStatusText()
	{
		$statuses = $this->getModel()->getStatusOptions();
		if (array_key_exists($this->status,$statuses)) {
			return $statuses[$this->status];
		}
		return $statuses[Model_Shipping::STATUS_DEFAULT];
	}
	
}

