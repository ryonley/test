<?php

namespace Admin\Form;

use Zend\Form\Form;

class LoginForm extends Form {
    
    public function __construct(){
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Email'
            )
        ));
        
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password'
            ),
            'options' => array(
                'label' => 'Password'
            )
        ));
        
         $this->add(array(
             'name' => 'submit',
             'attributes' => array(
                 'type' => 'submit',
                 'value' => 'Submit',
                 'id' => 'submitbutton'
             )
        ));
    }
}
