<?php

namespace Blog;

use Blog\Model\Post;
use Blog\Model\PostTable;
use Blog\Model\Comments;
use Blog\Model\CommentsTable;
use Blog\Model\Categories;
use Blog\Model\CategoriesTable;
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
    
    public function getServiceConfig(){
         return array(
             'factories' => array(
                   'dbAdapter' => function($sm){
                    return $sm->get('Zend\Db\Adapter\Adapter');
                 },
                  'Blog\Form\PostForm' => function($sm){
                      $form = new  \Blog\Form\PostForm($sm);
                      return $form;
                  },
                 'Blog\Model\CatsTable' => function($sm){
                       $tableGateway = $sm->get('CatTableGateway');
                       $table = new CategoriesTable($tableGateway);
                       return $table;
                 },
                 'CatTableGateway' => function($sm){
                       $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                       $resultSetPrototype = new ResultSet();
                       $resultSetPrototype->setArrayObjectPrototype(new Categories());
                       return new TableGateway('categories', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Blog\Model\PostTable' => function($sm) {
                        $tableGateway = $sm->get('PostTableGateway');
                        $table = new PostTable($tableGateway);
                        return $table;
                 },
                 'PostTableGateway' => function($sm){
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Post());
                     return new TableGateway('post', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Blog\Model\CommentsTable' => function($sm){
                     $tableGateway = $sm->get('CommentsTableGateway');
                     $table = new CommentsTable($tableGateway);
                     return $table;
                 },
                 'CommentsTableGateway' => function($sm){
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Comments());
                     return new TableGateway('comments', $dbAdapter, null, $resultSetPrototype);
                 }
             )
         );
    }
    
}

?>
