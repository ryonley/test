<?php

namespace Admin;

use Admin\Model\User;
use Admin\Model\UsersTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class Module
{
   
    
    public function getAutoloaderConfig()
    {
        return array(

            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
     public function getServiceConfig()
    {
        return array(
             'factories' => array(
                 'dbAdapter' => function($sm){
                    return $sm->get('Zend\Db\Adapter\Adapter');
                 },
                  'Admin\Model\UsersTable' => function($sm) {
                        $tableGateway = $sm->get('UsersTableGateway');
                        $table = new UsersTable($tableGateway);
                        return $table;
                 },
                 'UsersTableGateway' => function($sm){
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new User());
                     return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                 },
             )
        );
    }
}
?>
