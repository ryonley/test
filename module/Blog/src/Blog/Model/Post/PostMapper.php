<?php

namespace Blog\Model\Post;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Stdlib\Hydrator\ArraySerializable;
use Blog\Model\Post\Post;


class PostMapper extends AbstractDbMapper
{
    protected $tableName = 'post';

    public function __construct(){
        $this->setHydrator(new ArraySerializable());
        $this->setEntityPrototype(new Post());
    }

    public function save(Post $post){
        if (!$post->getId()) {
            $result = $this->insert($post);
            $post->setId($result->getGeneratedValue());
        } else {
            $where = 'ID = ' . (int)$post->getId();
            $this->update($post, $where);
        }
    }

    public function fetchAll()
    {
        $select = $this->getSelect($this->tableName);
        return $this->select($select);
    }

    public function loadById($id)
    {
        $select = $this->getSelect($this->tableName)
            ->where(array('ID' => (int)$id));

        $obj =  $this->select($select)->current();
       // $comment_collection =
        $obj->setComments($comment_collection);
    }
}