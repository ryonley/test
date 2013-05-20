<?php
namespace Admin\Form;

use Zend\Form\Form;
use Zend\Permissions\Acl\Resource\ResourceInterface as Resource;

class TestForm extends Form implements Resource {
    
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
             'name' => 'submit',
             'attributes' => array(
                 'type' => 'submit',
                 'value' => 'Submit',
                 'id' => 'submitbutton'
             )
        ));
    }
    
    public function getResourceId(){
        return 1;
    }
}
?>
