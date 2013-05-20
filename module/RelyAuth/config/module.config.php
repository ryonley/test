<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'RelyAuth\Controller\Auth' => 'RelyAuth\Controller\AuthController',
            'RelyAuth\Controller\Success' => 'RelyAuth\Controller\SuccessController'
        ),
    ),
    'router' => array(
        'routes' => array(
             
            'login' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auth',
                    'defaults' => array(
                        '__NAMESPACE__' => 'RelyAuth\Controller',
                        'controller'    => 'Auth',
                        'action'        => 'login',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'process' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            'logout' => array(
                 'type' => 'Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                          '__NAMESPACE__' => 'RelyAuth\Controller',
                        'controller'    => 'Auth',
                        'action'        => 'logout',
                    )
                )
            ),
             
            'success' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/success',
                    'defaults' => array(
                        '__NAMESPACE__' => 'RelyAuth\Controller',
                        'controller'    => 'Success',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
             
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'RelyAuth' => __DIR__ . '/../view',
        ),
    ),
    
    'login_success' => array(
        'route_name' => 'dash'
    )
);