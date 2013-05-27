<?php
namespace Core\Model;

abstract class ResourceAbstract extends \PDO
{

    protected $engine;
    protected $host;
    protected $database;
    protected $user;
    protected $pass;

    public function __construct()
    {
        $this->engine = \StudentManagement::getInstance()->getConfig('pdo/engine');
        $this->host = \StudentManagement::getInstance()->getConfig('pdo/host');
        $this->database = \StudentManagement::getInstance()->getConfig('pdo/database');
        $this->user = \StudentManagement::getInstance()->getConfig('pdo/user');
        $this->pass = \StudentManagement::getInstance()->getConfig('pdo/pass');
        
        $dns = $this->engine.':dbname='.$this->database.";host=".$this->host;
        try {
            parent::__construct( $dns, $this->user, $this->pass );
        } catch( \Exception $e ) {
          die( $e->getMessage() );
        }
    }
    
    public function write( $entry = array() )
    {
        $table = $entry['table'];
        $columns = array();
        $values = array();
        
        foreach( $entry['items'] as $column => $request ) {
            $columns[] = $column;
            $values[] = $this->parseRequest($request);
        }
        
        $sql = 'INSERT INTO '.$table.'('.implode(',',$columns).') VALUES('.implode(',',$values).');';
        
        if( FALSE === $this->exec($sql) ) {
            var_dump($sql);
            print_r($this->errorInfo());
        }
    }
    
    protected function callMysql( $functionName ) {
        return null;
    }
    
    protected function callPhp( $methodName, $param = null ) {
        if( !(\method_exists($this, $methodName) ) ) {
            throw new \Exception('method does not exist');
        }
        return $this->$methodName( $param );
    }
    
    protected function parseRequest( $request = array() ) {
        
        $param = (isset($request['param']))?$request['param']:null;
        $request = explode('!->',$request['value']);
        
        switch( $request[0] ) {
            case 'mysql':
                return $this->quote( $this->callMysql( $request[1] ) );
                break;
            case 'php':
                return $this->quote( $this->callPhp( $request[1], $param ) );
                break;
            case 'raw':
                return $this->quote($request[1]);
                break;
            default:
                break;
        }
    }   
}