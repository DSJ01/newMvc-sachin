        <?php
class Model_Payment extends Model_Core_Table
{
	protected $resourceClass = 'Model_Payment_Resource';
    protected $collectionClass = 'Model_Payment_Collection';

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }
        return Model_Payment_Resource::STATUS_DEFAULT;
    }
    
    public function getStatusText()
    {
        $statuses = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status,$statuses)) {
            return $statuses[$this->status];
        }
        return $statuses[Model_Payment_Resource::STATUS_DEFAULT];
    }
}

?>