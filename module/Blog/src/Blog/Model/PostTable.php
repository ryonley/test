<?php
namespace Blog\Model;

use Zend\Db\TableGateway\TableGateway;

class PostTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($options = array())
    {
        $resultSet = $this->tableGateway->select($options);
        return $resultSet;
    }

    /*
      public function getPost($name)
    {

        $rowset = $this->tableGateway->select(array('post_name' => $name));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $name");
        }
        return $row;
    }
     * 
     */
    
   public function getPost($options = array())
    {
        $rowset = $this->tableGateway->select($options);
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $name");
        }
        return $row;
    }
    
    
    public function savePost(Post $post){
        $data = array(
           'post_author' => $post->post_author,
           'post_category' => $post->post_category,
           'date' => date('Y-m-d H:i:s'),
           'post_content' => $post->post_content,
            'post_title' => $post->post_title,
            'post_description' => $post->post_description,
            'post_status' => $post->post_status,
           'comment_status' => $post->comment_status,
            'post_password' => $post->post_password,
            'post_name' => $post->post_name,
            'post_modified' => date('Y-m-d H:i:s'),
           'post_content_filtered' => $post->post_content_filtered,
            'post_parent' => $post->post_parent,
            'post_type' => $post->post_type,
            'comment_count' => $post->comment_count
        );
        
        
        $id = (int)$post->ID;
        if($id == 0){
    
            $this->tableGateway->insert($data);
        } else {
            $id = (int)$post->ID;
            //$name = $post->post_name;
            if($this->getPost(array('ID' => $id))){
                $this->tableGateway->update($data, array('ID' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

}

?>
