<?php

/**
 * TODO implement autoloader
 */
require_once 'app/lib/HTTPRequest.php';
require_once 'app/lib/BaseException.php';

/**
 * @desc	Bootstrapper
 * @author	matthew
 */
final class StudentManagment
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
       return self::$instance;
	}
	
	
	/**
	 * @desc	run application
	 * @param	array $request
	 */
	public function run( $request )
	{
	 	$request = new HTTPRequest( $request, HTTPRequest::REQUEST );
	 	$this->parseConfig();
	 	$this->route( $request );
	}
	
	
	
	/**
	 * @desc	parse XML to PHP-array 
	 */
	private function parseConfig()
	{
		$config = new SimpleXMLIterator( StudentManagment::CONFIG_FILE, null, true);
		foreach( $config->config->module as $entry ) {
			$this->config['modules'][] = $entry->__toString();
		}
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
		} catch( BaseException $e ) {
			$module = 'core';
		}
		
		try {
			$controller = $request->getController();
		} catch( BaseException $e ) {
			$controller = 'index';
		}
		
		try {
			$action = $request->getAction().'Action';
		} catch( BaseException $e ) {
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
		$obj = ucfirst($module).'_'.ucfirst($type).'_'.ucfirst($className);
		return new $obj;
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