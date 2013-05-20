<?php

namespace Blog\Form;

use Zend\Form\Form;

class PostForm extends Form {
    
    public function __construct($sm) {
        parent::__construct('post');
        $this->setAttribute('method', 'post');
        
      $cats = $sm->get('Blog\Model\CatsTable')->fetchAll();
      
        $this->add(array(
            'name' => 'ID',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'post_title',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Title'
            )
        ));
        
        $this->add(array(
            'name' => 'post_content',
            'attributes' => array(
                'type' => 'textarea'
            ),
            'options' => array(
                'label' => 'Content'
            )
        ));
        
        $this->add(array(
            'name' => 'post_description',
            'attributes' => array(
                'type' => 'textarea'
            ),
            'options' => array(
                'label' => 'Description'
            )
        ));
        
        $options = array();
        foreach($cats as $cat){
              $options[$cat->id] = $cat->name;
        }
        
             $this->add(array(
                 'name' => 'post_category',
                 'type' => 'Zend\Form\Element\Radio',
                 'options' => array(
                     'label' => 'Select a category',
                     'value_options' =>$options
                 )
             ));
             
          $this->add(array(
               'name' => 'post_status',
              'type' => 'Zend\Form\Element\Radio',
              'options' => array(
                  'label' => 'Status',
                  'value_options' => array(
                     'draft' => 'draft', 
                     'publish' => 'publish'
                  )
              )
          ));
          
          $this->add(array(
              'name' => 'post_name',
              'attributes' => array(
                  'type' => 'text'
              ),
              'options' => array(
                  'label' => 'Name / URL'
              )
          ));
    
      
        /*
        $this->add(array(
            'name' => 'status',
            'attributes' => array(
                'type' => 'radio',
                'value' => 'draft'
            ),
            'options' => array(
                'label' => 'Draft'
            )
        ));
        
         $this->add(array(
            'name' => 'status',
            'attributes' => array(
                'type' => 'radio',
                'value' => 'published'
            ),
            'options' => array(
                'label' => 'Published'
            )
        ));
        */
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'save',
                'id' => 'submitbutton'
            )
        ));
        
    }
}
?>
