<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Rodger
 * Date: 5/19/13
 * Time: 10:13 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class TestController extends AbstractActionController {
    public function indexAction(){
        $sm = $this->getServiceLocator();
        $postMapper = $sm->get('PostMapper');
        $post = $postMapper->fetchAll();
        /*
        echo "<pre>";
        print_r($post);
        echo "</pre>";
        */
        foreach ($post as $p){
            echo $p->post_title;
        }
    }
}