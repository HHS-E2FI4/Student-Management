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
     * @desc   config
     * @var    SimpleXMLElement $config
     */
    private static $config = null;
    


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
        if( null === self::$config) {
            self::$config = StudentManagement::loadConfig();
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
        
        $data = (isset($request['data']))?$request['data']:array('data'=>null);
        self::getController( $module, $controller )->$action( $data );
    }
    
    private static function loadConfig()
    {
        $xml = file_get_contents( 'etc/config.xml' );
        return new SimpleXMLElement( $xml );
    }
    
    public function getConfig( $path )
    {
        $entry = self::$config->xpath( $path );
        $result = array();
        foreach( $entry as $item ) {
            $result[] = (string)$item;
        }
        return implode($result);
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