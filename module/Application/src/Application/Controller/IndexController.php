<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\Password\Bcrypt;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        /*
        $bcrypt = new Bcrypt(array(
                'salt' => '1234567890123456',
                'cost' => 14
        ));
        
        $start    = microtime(true);
        $password = $bcrypt->create('elvira1980');
        $end      = microtime(true);

        printf ("Password  : %s\n", $password);
        printf ("Exec. time: %.2f\n", $end-$start);
        
        echo "is it valid? ".$bcrypt->verify('elvira1980', $password);
        */
        return new ViewModel();
    }
    
    public function aboutAction(){
        return new ViewModel();
    }
}
