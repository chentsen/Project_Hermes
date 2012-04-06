<?php
use Wildkat\Application\Container\DoctrineContainer;
require_once "Zend/Cache.php";
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initRequest() {
		$this->bootstrap('FrontController');
		$front = $this->getResource('FrontController');
	}
	protected function _initDoctype()
    {
    $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
        $view->headLink( array( 'rel' => 'favicon',
        'href' => $view->baseUrl( 'favicon.ico' ),
        'type' => 'image/x-icon' ));
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
    protected function _initSmtp(){
	$options = $this->getOptions();
	$config = array('port'=>$options['email']['port'],
			'auth'=>$options['email']['auth'],
			'username'=>$options['email']['username'],
			'password'=>$options['email']['password']);
	$transport = new Zend_Mail_Transport_Smtp($options['mailClient'],$config);
	Zend_Mail::setDefaultTransport($transport);
	Zend_Registry::set('SmtpTransport',$transport);
	//var_dump($config);
	return $transport;		   
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
		//require_once 'Facebook/Facebook.php'; 
		 $documentAutoloader = array(new \Doctrine\Common\ClassLoader('Documents', APPLICATION_PATH . '/models'), 'loadClass');
   		 $fbAutoloader = array(new \Doctrine\Common\ClassLoader('Facebook', 'Doctrine/Facebook'), 'loadClass');
		 $autoloader->pushAutoloader($documentAutoloader, 'Documents\\');
		  $fbAutoloader = array(new \Doctrine\Common\ClassLoader('Facebook'), 'loadClass');
		 $autoloader->pushAutoloader($fbAutoloader, 'Facebook');
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
	public function _initMemCache() {
		$caching = Zend_Registry::get('config')->memCache->caching;
		$lifetime = Zend_Registry::get('config')->memCache->lifetime;
		$autoSerialize = Zend_Registry::get('config')->memCache->serialization;
		$host = Zend_Registry::get('config')->memCache->host;
		$port = Zend_Registry::get('config')->memCache->port;

		$frontendOpts = array(
			'caching' => $caching,
			'lifetime' => $lifetime,
			'automatic_serialization' => $autoSerialize
		);
		
		$backendOpts = array(
			'servers' =>array(
				array(
				'host' => $host,
				'port' => $port
				)
			),
			'compression' => false
		);
		$cache = Zend_Cache::factory('Core', 'Memcached', $frontendOpts, $backendOpts);
		
		Zend_Registry::set('Memcache', $cache);
		/*** example */
		/*$blah = "wahahhaha";
		$cache->save($blah, 'blahman');
		
		$blahman = Zend_Registry::get('Memcache')->load('blahman');
		
		var_dump($blahman);*/
		/*http://webhole.net/2009/11/27/how-to-cache-pages-with-zend/
		***/
	}
}

