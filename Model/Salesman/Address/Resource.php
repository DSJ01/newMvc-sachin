<?php
class Model_Salesman_Address_Resource extends Model_Core_Table_Resource
{
	protected $primaryKey = 'salesman_address_id';
    protected $tableName = 'salesman_address';

    const STATUS_ACTIVE = 1;
    const STATUS_ACTIVE_LBL = 'Active';
    const STATUS_INACTIVE = 2;
    const STATUS_INACTIVE_LBL = 'inactive';
    const STATUS_DEFAULT = 2;
    
    public function getStatusOptions()
    {
        return [
            self::STATUS_ACTIVE => self::STATUS_ACTIVE_LBL,
            self::STATUS_INACTIVE => self::STATUS_INACTIVE_LBL

        ];
    }
}

?>