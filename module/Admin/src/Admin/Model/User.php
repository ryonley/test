<?php

namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class User implements InputFilterAwareInterface
{
    public $id;
    public $username;
    public $password;
    protected $inputFilter;
    
        public function exchangeArray($data){
              $this->id = (isset($data['id'])) ? $data['id'] : null;
              $this->username = (isset($data['username'])) ? $data['username'] : null;
               $this->password = (isset($data['password'])) ? $data['password'] : null;
                $this->real_name = (isset($data['real_name'])) ? $data['real_name'] : null;
        }
    
    public function setInputFilter(InputFilterInterface $inputFilter) 
    {
         throw new \Exception("Not used");
    }
    
    public function getInputFilter()
    {
         if(!$this->inputFilter){
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'email',
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
                'name' =>'password',
                'required' => true,
                 'filters' => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim')
                 ),
            )));
            
            $this->inputFilter = $inputFilter;
         }
         return $this->inputFilter;
    }
}