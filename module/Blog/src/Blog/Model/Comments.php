<?php

namespace Blog\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Comments implements InputFilterAwareInterface{
    
    public $comment_ID;
    public $comment_post_ID;
    public $comment_author;
    public $comment_author_email;
    public $comment_author_url;
    public $comment_author_IP;
    public $comment_date;
    public $comment_date_gmt;
    public $comment_content;
    public $comment_karma;
    public $comment_approved;
    public $comment_agent;
    public $comment_type;
    public $comment_parent;
    public $user_id;
    protected $inputFilter;
    
    public function exchangeArray($data){
              $this->comment_ID = (isset($data['comment_ID'])) ? $data['comment_ID'] : null;
              $this->comment_post_ID = (isset($data['comment_post_ID']))? $data['comment_post_ID']: null;
              $this->comment_author = (isset($data['comment_author']))? $data['comment_author']: null;
              $this->comment_author_email = (isset($data['comment_author_email']))? $data['comment_author_email']: null;
              $this->comment_author_url = (isset($data['comment_author_url']))? $data['comment_author_url']: null;
              $this->comment_author_IP = (isset($data['comment_author_IP']))? $data['comment_author_IP']: null;
              $this->comment_date = (isset($data['comment_date']))? $data['comment_date']: null;
              $this->comment_date_gmt = (isset($data['comment_date_gmt']))? $data['comment_date_gmt']: null;
              $this->comment_content = (isset($data['comment_content']))? $data['comment_content']: null;      
              $this->comment_karma = (isset($data['comment_karma']))? $data['comment_karma']: null;
              $this->comment_approved = (isset($data['comment_approved']))? $data['comment_approved']: null;
              $this->comment_agent = (isset($data['comment_agent']))? $data['comment_agent']: null;
              $this->comment_type = (isset($data['comment_type']))? $data['comment_type']: null;
              $this->comment_parent = (isset($data['comment_parent']))? $data['comment_parent']: null;
              $this->user_id = (isset($data['user_id']))? $data['user_id']: null;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter){
           throw new \Exception("Not used");
    }
    
    public function getInputFilter(){
        
        if(!$this->inputFilter){
             $inputFilter = new InputFilter();
             $factory = new InputFactory();
             
             $inputFilter->add($factory->createInput(array(
                 'name' => 'comment_author',
                 'required' => true,
                  'filters' => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim')
                 )
             )));
             
             $inputFilter->add($factory->createInput(array(
                 'name' => 'comment_author_email',
                 'required' => true,
                  'filters' => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim')
                 ),
                 'validators' => array(
                     array(
                         'name' => 'EmailAddress'
                     )
                 )
             )));
             $inputFilter->add($factory->createInput(array(
                 'name' => 'comment_author_url',
                 'required' => false,
                  'filters' => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim')
                 )
             )));
             $inputFilter->add($factory->createInput(array(
                 'name' => 'comment_content',
                 'required' => true,
                 'filters' => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim')
                 )
    
             )));
             $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
    
    
    
}

?>
