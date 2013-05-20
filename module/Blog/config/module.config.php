<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Blog\Controller\Blog' => 'Blog\Controller\BlogController',
            'Blog\Controller\Test' => 'Blog\Controller\TestController'
        ),
    ),
    
        'router' => array(
        'routes' => array(
            
            
           'blog' => array(
               
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/blog',
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Blog',
                        'action' => 'index'
                    ),
                ),
               
               
             
               
                'may_terminate' => true,
               
                'child_routes' => array(
                    // Segment route for viewing one blog post
                    'post' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/[:slug]',
                            'constraints' => array(
                                'slug' => '[a-zA-Z0-9_-]+'
                            ),
                            'defaults' => array(
                                'action' => 'view'
                            )
                        )
                    ),
        ),  
                
               
    ),
     'test' => array(
         'type' => 'Zend\Mvc\Router\Http\Literal',
         'options' => array(
             'route' => '/test',
             'defaults' => array(
                 'controller' => 'Blog\Controller\Test',
                 'action' => 'index'
             ),
         ),
     ),
            
    'addpost' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/add-post',
                    'defaults' => array(
                       'controller' => 'Blog\Controller\Blog',
                        'action'     => 'addPost',
                    ),
                ),
    ),
            
    'editpost' => array(
         'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/edit-post',
                    'defaults' => array(
                       'controller' => 'Blog\Controller\Blog',
                        'action'     => 'editPost',
                    ),
                ),
         'may_terminate' => true,
        
           'child_routes' => array(
               'post' => array(
                   'type' => 'segment',
                   'options' => array(
                       'route' => '/[:slug]',
                       'constraints' => array(
                           'slug' => '[a-zA-Z0-9_-]+'
                       ),
                       'defaults' => array(
                           'action' => 'editPost'
                       )
                   )
               )
           )
    ),
            
    'viewposts' => array(
        'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
               'route' => '/view-posts',
                'defaults' => array(
                    'controller' => 'Blog\Controller\Blog',
                    'action' => 'viewPosts',
                ),
            ),
    ),
            
            
    ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'blog' => __DIR__ . '/../view',
        ),
    ),
);

?>
