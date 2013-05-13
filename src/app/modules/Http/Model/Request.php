<?php
namespace Http\Model;
use Core\Model;

/**
 * @desc 	make GET|POST requests more accessible
 * @author	matthew
 */
class Request extends \Core\Model\ModelAbstract
{
    /**
     * @desc parameters
     * @var array $data
     */
    private $data = array();

    /**
     * @desc superglobal $_REQUEST, $_POST, $_GET to $request
     * @param array $request
    */
    public function __construct( $request = array() )
    {
        $this->data = $request;
    }

}