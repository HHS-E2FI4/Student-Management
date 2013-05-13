<?php
namespace Core\Model;

class Container
{

    /**
     * @desc storing files
     * @var array $data
     */
    private $data = array();


    /**
     * @desc magic getter
     * @param string $node
     * @throws Exception
    */
    private function get( $node )
    {
        $node = strtolower($node);
        if( !isset($this->data[$node]) ) {
            throw new \Exception('Key has not been found');
        }
        return $this->data[$node];
    }


    /**
     * @desc magic setter
     * @param string $node, mixed value
     */
    private function set( $node, $value )
    {
        $node = strtolower($node);
        $this->data[$node] = $value;
        return $this;
    }


    /**
     * @desc	magicMethod __call for a dynamic/magic getter
     * @param string $method
     * @param array $args
     */
    public function __call( $method, $args )
    {
        switch( substr($method,0,3) ) {
            case 'get':
                return $this->get( (substr($method,3)) );
                break;
            case 'set':
                return $this->set( (substr($method,3)), $args[0] );
                break;
        }

    }

}