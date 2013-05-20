<?php

namespace Authorize\Controller\Plugin;

 
use Zend\Mvc\Controller\Plugin\AbstractPlugin,
    Zend\Session\Container as SessionContainer,
    Zend\Permissions\Acl\Acl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;

use Zend\Authentication\AuthenticationService;

class IsAllowed extends AbstractPlugin
{
    protected $extra;
    protected $sesscontainer ;
    
    public function __construct() {
        $this->extra = "a little something extra";
    }
    
       private function getSessContainer()
    {
        if (!$this->sesscontainer) {
            $this->sesscontainer = new SessionContainer();
        }
        return $this->sesscontainer;
    }
    
    
    public function doAuth($e) {
            //setting ACL...
        $acl = new Acl();
        //add role ..
        $acl->addRole(new Role('anonymous'));
        $acl->addRole(new Role('user'),  'anonymous');
        $acl->addRole(new Role('admin'), 'user');
        
        $acl->addResource(new Resource('Application'));
        $acl->addResource(new Resource('Album'));
        $acl->addResource(new Resource('Blog'));
        $acl->addResource(new Resource('addPost'), 'Blog');
        $acl->addResource(new Resource('RelyAuth'));
        
         // ASSIGN ADMIN RESOURCE AND PRIVILEGES
        $acl->addResource(new Resource('Admin'));
        $acl->addResource(new Resource('index'), 'Admin');
        

        // ANONYMOUS SITE VISITORS CAN DO EVERYTHING EXCEPT ACCESS THE INDEX
         $acl->allow('anonymous', array('Application', 'Blog'));
         $acl->allow('anonymous', 'Admin', 'index');
         $acl->allow('anonymous', 'Album');
         $acl->allow('anonymous', 'RelyAuth');
         $acl->deny('anonymous', 'Blog', 'addPost');
         
        
        // THE ADMIN USER IS ALLOWED ACCESS TO THE ENTIRE ADMIN CONTROLLER
        // NOT JUST THE INDEX
        $acl->allow('admin', 'Admin');
        $acl->allow('admin', 'Blog');
        
       

    
        
        //$controller = $e->getTarget();
        $action = $e->getRouteMatch()->getParam('action');
        $controllerClass = $e->getRouteMatch()->getParam('controller');
        $namespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
        
        $role = (! $this->getSessContainer()->role) ? 'anonymous' : $this->getSessContainer()->role;

        if ( ! $acl->isAllowed($role, $namespace, $action)){
            $router = $e->getRouter();
            $url    = $router->assemble(array(), array('name' => 'login'));
        
            $response = $e->getResponse();
            $response->setStatusCode(302);
            //redirect to login route...
            /* change with header('location: '.$url); if code below not working */
            $response->getHeaders()->addHeaderLine('Location', $url);
            $e->stopPropagation();            
        }
    }
    
    

}
?>
