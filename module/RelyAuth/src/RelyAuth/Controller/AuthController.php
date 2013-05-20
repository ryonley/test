<?php
namespace RelyAuth\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use RelyAuth\Form\LoginForm;
use RelyAuth\Model\User;
use Zend\Session\Container as SessionContainer;
use Zend\Config\Config as Config;


class AuthController extends AbstractActionController
{
    protected $form;
    protected $storage;
    protected $authservice;
    protected $usersTable;
    
    public function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('AuthService');
        }
         
        return $this->authservice;
    }
    /*
    public function getSessionStorage()
    {
        if (! $this->storage) {
            $this->storage = $this->getServiceLocator()
                                  ->get('RelyAuth\Model\MyAuthStorage');
        }
         
        return $this->storage;
    }
     * 
     */
    
    
    
    public function loginAction()
    {
        $sm = $this->getServiceLocator();
        $config = new Config($sm->get('Config'));
        $success_route = $config->login_success->route_name;
        
        //if already login, redirect to success page
        if ($this->getAuthService()->hasIdentity()){
            return $this->redirect()->toRoute('success');
        }
                 
        $form       = new LoginForm();
         
        
        $request = $this->getRequest();
        if ($request->isPost()){
            $user = new User();
            $form->setInputFilter($user->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()){
                $this->getAuthService()->getAdapter()
                                       ->setIdentity($request->getPost('email'))
                                       ->setCredential($request->getPost('password'));
                                        
                $result = $this->getAuthService()->authenticate();
                
                foreach($result->getMessages() as $message)
                {
                    $this->flashmessenger()->addMessage($message);
                } 
                       
                if($result->isValid()){
                        if($this->getAuthService()->hasIdentity()){
                            $identity = $this->getAuthService()->getIdentity();
                          
                            $usersTable = $this->getUsersTable();
                            $user = $usersTable->fetchUser($identity);
                            //echo "user role = ".$user->role_id;
                            if(isset($user->role_id)){
                                $sc = new SessionContainer();
                                $sc->role = $user->role_id;
                            }
 
                             return $this->redirect()->toRoute($success_route);
                        }
                }
            }
        }
        
        return array(
            'form'      => $form,
            'messages'  => $this->flashmessenger()->getMessages()
        );
    }
  
    
     public function logoutAction()
    {
        //$this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
          $sc = new SessionContainer();
          $sc->getManager()->getStorage()->clear();
        $this->flashmessenger()->addMessage("You've been logged out");
        return $this->redirect()->toRoute('login');
    }
    
        public function getUsersTable(){
        if(!$this->usersTable){
              $sm = $this->getServiceLocator();
              $this->usersTable = $sm->get('RelyAuth\Model\UsersTable');
        }
        return $this->usersTable;
    }
    
    
}

?>
