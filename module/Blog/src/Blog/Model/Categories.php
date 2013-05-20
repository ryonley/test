<?php


namespace Blog\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Categories implements InputFilterAwareInterface{
    
    public $id;
    public $name;
    public $slug;
    
    public function exchangeArray($data){
          $this->id= (isset($data['id'])) ? $data['id'] : null;
           $this->name = (isset($data['name'])) ? $data['name'] : null;
            $this->slug = (isset($data['slug'])) ? $data['slug'] : null;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter){
           throw new \Exception("Not used");
    }
    
    public function getInputFilter(){

    }
    
}
?>
