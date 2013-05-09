<?php

/**
 * TODO moving library to /Core/Lib/
 */
require_once 'app/lib/HTTPRequest.php';
require_once 'app/lib/SplClassLoader.php';

/**
 * @desc	Bootstrapper
 * @author	matthew
 */
final class StudentManagement
{
	
	/**
	 * @desc	path to config file
	 * @var		StudentManagment::CONFIG_FILE
	 */
	const CONFIG_FILE = 'app/etc/config.xml';
	
	
	/**
	 * @desc	list of modules
	 * @var		array $config
	 */
	private $config = array();
	
	
	/**
	 * @desc	instance
	 * @var		StudentManagment $instance
	 */
	private static $instance = null;
	
	
	/**
	 * @desc   autoloader
	 * @var    SplAutoloader $autoloader;
	 */
	private static $autoloader = null;
	
	
	/**
	 * @desc	disable constructor
	 */
	private function __construct() {}
	
	
	/**
	 * @desc	disable clone
	 */
	private function __clone() {}
	
	
	
	/**
	 * @desc	get a singleton of StudentManagment
	 * @return	StudentManagment
	 */
	public static function getInstance()
	{
       if (null === self::$instance) {
           self::$instance = new self;
       }
       if (null === self::$autoloader) {
           self::$autoloader = new SplClassLoader();
           self::$autoloader->register();
           self::$autoloader->setIncludePath('app/modules');
       }
       return self::$instance;
	}
	
	
	/**
	 * @desc	run application
	 * @param	array $request
	 */
	public function run( $request )
	{
	 	$request = new HTTPRequest( $request, HTTPRequest::REQUEST );
	 	$this->parseConfig();  // need to be implemented
	 	$this->route( $request );
	}
	
	
	
	/**
	 * @desc	parse XML to PHP-array 
	 */
	private function parseConfig()
	{
	 /**
	  * TODO add logic
	  */
	}
	
	
	/**
	 * 	@desc	our routing system
	 * 	@param	HTTPRequest $request
	 */
	private function route( HTTPRequest $request )
	{
		$module = null;
		$controller = null;
		$action = null;
		
		
		try {
			$module = $request->getModule();
		} catch( Exception $e ) {
		    die('Error - Module not found');
		}
		
		try {
			$controller = $request->getController();
		} catch( Exception $e ) {
			$controller = 'index';
		}
		
		try {
			$action = $request->getAction().'Action';
		} catch( Exception $e ) {
			$action = 'index'.'Action';
		}
		self::getController( $module, $controller )->$action($request);	
	}
	

	
	/**
	 * @desc	get (Controller|Model|Helper)
	 * @param	string $moduleName
	 * @param	string $type
	 * @param	string $className
	 * @return	Object
	 */
	private static function get($type, $module, $className)
	{
      $obj = ucfirst($module).'\\'.ucfirst($type).'\\'.ucfirst($className);
	  return new $obj();
	}
	
	
	/**
	 * @desc	magicMethod __callStatic for a dynamic/magic getter
	 * @param	string $method
	 * @param	array $args
	 */
	public static function __callStatic( $method, $args )
	{
		switch( substr($method,0,3) ) {
			case 'get':
				return self::get( (substr($method,3)), $args[0], $args[1] );
				break;
		}
	}
}