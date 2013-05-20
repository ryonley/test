<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\User;
use Admin\Form\LoginForm;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;


use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Zend\Crypt\Password\Bcrypt;

use Zend\Session\Container as SessionContainer;
use Zend\Config\Config as Config;


class AdminController extends AbstractActionController
{
 protected $usersTable;
    
    public function indexAction()
    {

                
      $sc = new SessionContainer();

       $auth = new AuthenticationService();
       $identity = $auth->getIdentity();
 
        // Create a SQLite database connection
        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('dbAdapter');

        $form = new LoginForm();
        $form->get('submit')->setValue('Log In');
        
        // ONCE THIS ACTION DETERMINES THE USER LOGGED IN SUCCESSFULLY
        // USER IS REDIRECTED TO DASHBOARD ACTION
        
        // FIRST VALIDATE
        $request = $this->getRequest();
        if($request->isPost()){
             $user = new User();
             $form->setInputFilter($user->getInputFilter());
             $form->setData($request->getPost());
             if($form->isValid()){
                 $post = $request->getPost();
                 $email = $post['email'];
                 $password = $post['password'];
                 
                 $auth = new AuthenticationService();
                 
                 $authAdapter = new AuthAdapter($dbAdapter);

                $authAdapter
                    ->setTableName('users')
                    ->setIdentityColumn('username')
                    ->setCredentialColumn('password')
                ;
                
                // Convert the password into the encrypted form
                $bcrypt = new Bcrypt(array(
                'salt' => '1234567890123456',
                'cost' => 14
                ));
                
                $enc_pass = $bcrypt->create($password);
                
                $authAdapter
                    ->setIdentity($email)
                    ->setCredential($enc_pass)
                ;
                
                
                
                $result = $auth->authenticate($authAdapter);
                //$result = $authAdapter->authenticate();
                
                if(!$result->isValid()){
                      // Authentication failed; print the reasons why
                        foreach ($result->getMessages() as $message) {
                            echo "$message\n";
                        }
                } else {
                           if ($auth->hasIdentity()) {
                                // Identity exists; get it
                                $identity = $auth->getIdentity();
                                
                           
                                // SET THE ROLE BASED ON THE IDENTITY
                                // TODO ***  QUERY THE DB FOR THE ROLE OF THIS USER'S IDENTITY
                                 $sc = new SessionContainer('zftutorial');
                                 $sc->role = 'admin';
                                $user = $this->getUsersTable()->getUser($identity);
                                $sc->user_id = $user->id;

                            }
                        $this->flashMessenger()->addMessage("Welcome $identity!  This is the flash messenger letting you know that you are now logged in.");
                        return $this->redirect()->toRoute('dash');
                }

                 
                 // REDIRECT TO THE DASH
                // return $this->redirect()->toRoute('dash');
             } 
        }

    
        return array('form' => $form);
        
    }

    

    
    public function dashAction()
    {
         $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('dbAdapter');
        // provide a visual representation of routes to the administrative features of your other Modules
        $auth = new AuthenticationService();
          $sc = new SessionContainer();
         $vars =  get_object_vars($sc);
    
        
        if ($auth->hasIdentity()) {
            // Identity exists; get it
             $return = array('success' => true);
             $identity = $auth->getIdentity();
             $return['identity'] = $identity;

 
            $flashMessenger = $this->flashMessenger();
            if ($flashMessenger->hasMessages()) {
                $return['messages'] = $flashMessenger->getMessages();
            }
           
            /*
            $test = $this->forward()->dispatch('Blog\Controller\Blog', array('action' => 'index'));
            $return['test'] = $test;
             * 
             */
            
            /*
             $sc = new SessionContainer('zftutorial');
             $role = $sc->role;
             */
              
             $layout = $this->layout();
             $layout->setTemplate('layout/admin');
                            
            return $return;
        }
    }
    
    public function getUsersTable(){
        if(!$this->usersTable){
              $sm = $this->getServiceLocator();
              $this->usersTable = $sm->get('Admin\Model\UsersTable');
        }
        return $this->usersTable;
    }
    

  

}
?>
