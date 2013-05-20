<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;

class UsersTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function getUser($username){
        $rowset = $this->tableGateway->select(array('username' => $username));
        $row = $rowset->current();
        if(!$row){
            throw new \Exception("Could not find user $username");
        }
        return $row;
    }
    
}
?>
