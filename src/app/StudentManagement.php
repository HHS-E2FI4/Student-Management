<?php
require_once 'ClassLoader.php';

/**
 * @desc	Bootstrapper
 * @author	matthew
 */
final class StudentManagement
{

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
    private function __construct() {
    }


    /**
     * @desc	disable clone
     */
    private function __clone() {
    }



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
        $req = StudentManagement::getModel('Http','Request');
        $req->setRequest( $request );
        $this->route( $req );
    }

    /**
     * 	@desc	our routing system
     * 	@param	Http/Request $request
     */
    private function route( Http\Model\Request $request )
    {
        $request = $request->getRequest();
        
        if( !isset($request['module']) || empty($request['module']) ) {
            die('Error - No module was given');
        }
        
        if( !isset($request['controller']) || empty($request['controller']) ) {
            $request['controller'] = 'index';
        }
        
        if( !isset($request['action']) || empty($request['action']) ) {
            $request['action'] = 'index';
        }
        
        $module = $request['module'];
        $controller = $request['controller'];
        $action = $request['action'].'Action';
        
        self::getController( $module, $controller )->$action($request['data']);
    }

    /**
     * @desc getModel
     * @param string $module
     * @param string $className
     * @return StdObject
     */
    public static function getModel($module, $className)
    {
        $obj = ucfirst($module).'\\'.'Model'.'\\'.ucfirst($className);
        return new $obj();           
    }
    
    /**
     * @desc getController
     * @param string $module
     * @param string $className
     * @return StdObject
     */
    public static function getController($module, $className)
    {
        $obj = ucfirst($module).'\\'.'Controller'.'\\'.ucfirst($className);
        return new $obj();        
    }
    
    /**
     * @desc getHelper
     * @param string $module
     * @param string $className
     * @return StdObject
     */
    public static function getHelper($module, $className )
    {
        $obj = ucfirst($module).'\\'.'Helper'.'\\'.ucfirst($className);
        return new $obj();        
    }
    
    /**
     * @desc getView
     * @param string $module
     * @param string $className
     * @return StdObject
     */
    public static function getView($module, $className)
    {
        $obj = ucfirst($module).'\\'.'View'.'\\'.ucfirst($className);
        return new $obj();        
    }
}