<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
        ),
    ),
    
      'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Admin',
                        'action' => 'index'
                    ),
                ),
               
            ),
            'dash' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/dash',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Admin',
                        'action' => 'dash'
                    ),
                ),
               
            ),

        ),
    ),
    
    'view_manager' => array(
        'template_map' => array(
       //    'layout/layout' => __DIR__.'/../view/layout/layout.phtml'  
        ),
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
    ),
    'admin_info' => array(
        'key1' => 'myvalue'
    )

);
