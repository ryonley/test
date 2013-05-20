<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Rodger
 * Date: 5/19/13
 * Time: 8:26 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Blog\Model;

class DomainEntityAbstract {
    protected $id;



    function getId(){
        return $this->id;
    }

    static function getCollection(){
        return array();
    }

    function collection(){
        return self::getCollection(get_class($this));
    }
}