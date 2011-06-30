<?php
class Zend_View_Helper_Logout extends Zend_View_Helper_Abstract {
        public function Logout()
        {
         $auth = Zend_Auth::getInstance();
                 if ($auth->hasIdentity()) {
                     $loginUrl = $this->view->url(array('controller' => 'index', 'action' => 'logout'));
                     return '<a href="'. $loginUrl . '">Logout</a>';
                 }
                 else {
                     $loginUrl = $this->view->url(array('controller' => 'index', 'action' => 'index'));
                     return '<a href="'. $loginUrl . '">Login</a>';
                 }
        }
}

?>
