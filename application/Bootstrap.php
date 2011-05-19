<?php
use Wildkat\Application\Container\DoctrineContainer;
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	 public function _initDoctrineMongoContainer()
    {
        $container = new DoctrineContainer($this->getOption('doctrine'));
        Zend_Registry::set('Wildkat\DoctrineContainer', $container);

        return $container;
    }
     protected function _initDefaultModuleAutoloader(){	
    	$resourceLoader = new Zend_Loader_Autoloader_Resource(array(
    'basePath'  => APPLICATION_PATH.'/models/documents/',
    'namespace' => 'Documents',
));
    	
	}
    	

}

