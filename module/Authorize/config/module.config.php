<?php

return array(
  'controller_plugins' => array(
     'invokables' =>  array(
         'IsAllowed' => 'Authorize\Controller\Plugin\IsAllowed'
     )  
  ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'authorize' => __DIR__ . '/../view',
        ),
    ),
);
