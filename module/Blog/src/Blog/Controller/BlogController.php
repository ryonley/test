<?php
namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Blog\Model\Comments;
use Blog\Form\CommentsForm;
use Blog\Form\PostForm;
use Blog\Model\Post;

class BlogController extends AbstractActionController
{
    protected $postTable;
    protected $commentsTable;
    
    public function indexAction()
    {
        // THIS ACTION WILL DISPLAY ALL BLOG POSTS
        return new ViewModel(array(
                    'posts' => $this->getPostTable()->fetchAll(array('post_status' => 'publish')),
               ) );
    }
    
    public function viewAction(){
         $name = $this->params()->fromRoute('slug');
         $post = $this->getPostTable()->getPost(array('post_name' => $name));
         
         //USE THE POST ID TO RETRIEVE THE COMMENTS
         $post_id = $post->ID;
        
 
         
         $form = new CommentsForm($post_id);
         $form->get('submit')->setValue('Post Comment');
         
         $request = $this->getRequest();
           if($request->isPost()){
          
               $commentsMod = new Comments();
               $form->setInputFilter($commentsMod->getInputFilter());
               $form->setData($request->getPost());
               if($form->isValid()){
                   $commentsMod->exchangeArray($form->getData());
                   $this->getCommentsTable()->saveComments($commentsMod);
   
               }
           }
           
        $comments = $this->getCommentsTable()->getComments($post_id);

         return new ViewModel(array(
             'name' => $name,
             'post' =>$post,
             'comments' => $comments,
             'form' => $form
         ));
    }


    
    public function addPostAction()
    {   

          
         $sm = $this->getServiceLocator();
         $form = new PostForm($sm);
         
     
         
         $form->get('submit')->setValue('Save');
        
        $request = $this->getRequest();
        if($request->isPost()){
            
            $post = new Post();
            $form->setInputFilter($post->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){
               $post->exchangeArray($form->getData());
                $this->getPostTable()->savePost($post);
                 $this->flashMessenger()->addMessage("Your post has been saved.");
            }
        }
        
        $layout = $this->layout();
        $layout->setTemplate('layout/admin');
        
        return array('form' => $form);
        
    }
    
    
    public function editPostAction(){
          $id = $this->params()->fromRoute('slug');
          if(!$id){
            //  return $this->redirect()->toRoute('blog', array('action' => 'addPost'));
          }
          echo "<pre>";
        // echo "<p>name = $name</p>";
         // $post = $this->getPostTable()->getPost($id);
          $post = $this->getPostTable()->getPost(array('ID' => $id));
         // print_r($post);
          $sm = $this->getServiceLocator();
          $form = new PostForm($sm);
          $form->bind($post);
           $form->get('submit')->setValue('Save');
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setInputFilter($post->getInputFilter());
            $form->setData($request->getPost());
          // print_r($request->getPost());
            if($form->isValid()){ 
                //print_r($form->getData());
               $this->getPostTable()->savePost($form->getData());
                 $this->flashMessenger()->addMessage("Your post has been saved.");
            }
        }
        echo "</pre>";
            $layout = $this->layout();
             $layout->setTemplate('layout/admin');
        
        return array('form' => $form, 'id' => $id);
          
          
    }
    
    public function viewPostsAction(){
        
        $layout = $this->layout();
        $layout->setTemplate('layout/admin');
        $options = array('post_status' => 'publish');
        return array('posts' => $this->getPostTable()->fetchAll($options));
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
    
    public function getPostTable(){
        if(!$this->postTable){
              $sm = $this->getServiceLocator();
              $this->postTable = $sm->get('Blog\Model\PostTable');
        }
        return $this->postTable;
    }
    
    public function getCommentsTable(){
        if(!$this->commentsTable){
             $sm = $this->getServiceLocator();
             $this->commentsTable = $sm->get('Blog\Model\CommentsTable');
        }
        return $this->commentsTable;
    }
    
    
}

?>