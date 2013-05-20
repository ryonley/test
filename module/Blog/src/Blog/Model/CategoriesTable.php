<?php
namespace Blog\Model;

use Zend\Db\TableGateway\TableGateway;

class CategoriesTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $rowset = $this->tableGateway->select();
        return $rowset;
    }
            
            
}
?>
