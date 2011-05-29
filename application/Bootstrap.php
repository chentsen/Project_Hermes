<?php
use Wildkat\Application\Container\DoctrineContainer;
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDoctype()
    {
    $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
	 public function _initDoctrineMongoContainer()
    {
        $container = new DoctrineContainer($this->getOption('doctrine'));
        Zend_Registry::set('Wildkat\DoctrineContainer', $container);

        return $container;
    }
     protected function _initDefaultModuleAutoloader(){	
    
    	
	}
	/**
	 * 
	 * Puts configuration options in the registry.
	 */
	protected function _initConfig()
	{
	    $config = new Zend_Config($this->getOptions(), true);
	    Zend_Registry::set('config', $config);
	    return $config;
	}
    	

}

