<?php
namespace Blog\Model;

use Zend\Db\TableGateway\TableGateway;

class CommentsTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


      public function getComments($post_id)
    {

        $rowset = $this->tableGateway->select(array('comment_post_ID' => $post_id, 'comment_approved' => '1'));
  
        if (!$rowset) {
            throw new \Exception("Could not find row $post_id");
        }
        return $rowset;
    }
    
    public function saveComments(Comments $comments){
        $data = array(
            'comment_author' => $comments->comment_author,
            'comment_author_email' => $comments->comment_author_email,
            'comment_author_url' => $comments->comment_author_url,
            'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
            'comment_date' => date('Y-m-d H:i:s'),
            'comment_date_gmt' => date('Y-m-d H:i:s'),
            'comment_post_ID' => $comments->comment_post_ID,
            'comment_content' => $comments->comment_content,
            'comment_approved' => '0',     
        );
        
        $id = $comments->comment_ID;
        if($id == 0){
            $this->tableGateway->insert($data);
        }
        
    }
    
    
  public function saveAlbum(Album $album)
    {
        $data = array(
            'artist' => $album->artist,
            'title'  => $album->title,
        );

        $id = (int)$album->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAlbum($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    
    
    

}

?>
