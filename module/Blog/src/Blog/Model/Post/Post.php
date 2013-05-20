<?php
namespace Blog\Model\Post;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Session\Container as SessionContainer;
use Blog\Model\DomainEntityAbstract as DomainEntityAbstract;


class Post extends DomainEntityAbstract implements InputFilterAwareInterface
{

    public $ID;
    public $post_author;
    public $date;
    public $post_date_gmt;
    public $post_content;
    public $post_title;
    public $post_description;
    public $post_excerpt;
    public $post_status;
    public $comment_status;
    public $post_password;
    public $post_name;
    public $to_ping;
    public $pinged;
    public $post_modified;
    public $post_modified_gmt;
    public $post_content_filtered;
    public $post_parent;
    public $guid;
    public $menu_order;
    public $post_type;
    public $post_mime_type;
    public $comment_count;
    protected $inputFilter;



    public function exchangeArray($data)
    {
        $sc = new SessionContainer('zftutorial');
        $user_id = $sc->user_id;
        $this->ID    = (isset($data['ID'])) ? $data['ID'] : 0;
        $this->post_author =  $user_id;
        $this->date = date('Y-m-d H:i:s');
        $this->post_category = (isset($data['post_category'])) ? $data['post_category'] : 1;
        $this->post_content  = (isset($data['post_content'])) ? $data['post_content'] : '';
        $this->post_title  = (isset($data['post_title'])) ? $data['post_title'] : '';
        $this->post_description  = (isset($data['post_description'])) ? $data['post_description'] : '';
        $this->post_status  = (isset($data['post_status'])) ? $data['post_status'] : 'publish';
        $this->comment_status  = (isset($data['comment_status'])) ? $data['comment_status'] : 'open';
        $this->post_password  = (isset($data['post_password'])) ? $data['post_password'] : '';
        $this->post_name  = (isset($data['post_name'])) ? $data['post_name'] : '';
        $this->post_modified  =  date('Y-m-d H:i:s');
        $this->post_content_filtered  = (isset($data['post_content_filtered'])) ? $data['post_content_filtered'] : '';
        $this->post_parent  = (isset($data['post_parent'])) ? $data['post_parent'] : 0;
        $this->post_type  = (isset($data['post_type'])) ? $data['post_type'] : '';
        $this->comment_count  = (isset($data['comment_count'])) ? $data['comment_count'] : 0;
        $this->comments = self::getCollection();

    }

    function setComments(CommentCollection $comments){
        $this->comments = $comments;
    }

    function getComments(){
        return $this->spaces;
    }


    function addComment(Comment $comment){
        $this->comments->add($comment);
        $comment->setPost($this);
    }





    public function setInputFilter(InputFilterInterface $inputFilter){
        throw new \Exception("Not used");
    }

    public function getInputFilter(){

        if(!$this->inputFilter){
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'post_title',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'post_content',
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim')
                )

            )));
            $inputFilter->add($factory->createInput(array(
                'name' => 'post_description',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'post_category',
                'required' => false
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'post_status',
                'required' => true
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'post_name',
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

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}