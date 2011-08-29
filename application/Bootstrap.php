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
        //once login use zend_registry 
        return $container;
    }
        protected function _initViewHelpers()
    {
  
        $this->view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");

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
	
	protected function _initAutoloader(){
		//$document = new SolrInputDocument();
		$autoloader = Zend_Loader_Autoloader::getInstance();
		require_once 'Doctrine/Common/ClassLoader.php';
		 $documentAutoloader = array(new \Doctrine\Common\ClassLoader('Documents', APPLICATION_PATH . '/models'), 'loadClass');
   		 $autoloader->pushAutoloader($documentAutoloader, 'Documents\\');
	    
   		// $documentAutoloader = new \Doctrine\Common\ClassLoader('Documents', APPLICATION_PATH . '/models');
	    //$autoloader->pushAutoloader(array($documentAutoloader, 'loadClass'), 'Documents');
	
	    $repositoryAutoloader = new \Doctrine\Common\ClassLoader('Repositories', APPLICATION_PATH . '/models');
	    $autoloader->pushAutoloader(array($repositoryAutoloader, 'loadClass'), 'Repositories');
	
	    return $autoloader;
	}
	
	protected function _initSolr(){
		$host = Zend_Registry::get('config')->siteInformation->solrHost;
		$port = Zend_Registry::get('config')->siteInformation->solrPort;
		$path = Zend_Registry::get('config')->siteInformation->solrPath;
		$options = array
			(
			    'hostname' => $host,   
			    'port'     => $port,
				'path'	   => $path,
				
			);
		$client = new SolrClient($options);
		
		
	    Zend_Registry::set('solr', $client);
	    return $client;
	}
	/*
	protected function _initSolrIndexer(){
		require_once 'Hermes/SolrIndexer.php';
		$indexer = new SolrIndexer();
		$indexer->startIndexer();
		
	}
	*/
    
}

