<?php
class Zend_View_Helper_LayoutClass extends Zend_View_Helper_Abstract {
        public function LayoutClass()
        {
          return Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
         }
}

?>
