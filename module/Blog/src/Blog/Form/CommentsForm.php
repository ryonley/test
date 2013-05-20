<?php

namespace Blog\Form;

use Zend\Form\Form;

class CommentsForm extends Form {
    
    public function __construct($post_id){
        parent::__construct('comments');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'comment_author',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Name'
            )
        ));
        $this->add(array(
            'name' => 'comment_author_email',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Email'
            )
        ));
        $this->add(array(
            'name' => 'comment_author_url',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Website'
            )
        ));
        $this->add(array(
            'name' => 'comment_content',
            'attributes' => array(
                'type' => 'textarea',
            ),
            'options' => array(
                'label' => 'Comments'
            )
        ));
        $this->add(array(
            'name' => 'comment_post_ID',
            'attributes' => array(
                'type' => 'hidden',
                'value' => $post_id
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
?>
