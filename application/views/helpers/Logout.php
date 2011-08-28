<?php
class Zend_View_Helper_Logout extends Zend_View_Helper_Abstract {
        public function Logout()
        {
         $auth = Zend_Auth::getInstance();
                 if ($auth->hasIdentity()) {
                     $loginUrl = $this->view->url(array('controller' => 'index', 'action' => 'logout'));
                     return '<li><a href="'. $loginUrl . '">Logout</a></li>';
                 }
                 else {
                     $registerUrl = $this->view->url(array('controller'=>'registration','action'=>'index'));
                   
                     $loginUrl = $this->view->url(array('controller' => 'index', 'action' => 'index'));
                     return '
                         <li><a href="'. $registerUrl . '">Register</a></li>
                             <li><a href="'. $loginUrl . '">Login</a></li>';
                 }
        }
}

?>
