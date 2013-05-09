<?php

/**
 * @desc 	make GET|POST requests more accessible
 * @author	matthew
 */
final class HTTPRequest
{
	
	/**
	 * @desc	alias for $_GET
	 * @var		HTTPRequest::GET
	 */
	const GET		= 'get';
	
	/**
	 * @desc	alias for $_POST
	 * @var		HTTPRequest::POST
	 */
	const POST		= 'post';
	
	/**
	 * @desc	alias for $_REQUEST
	 * @var		HTTPRequest::REQUEST
	 */
	const REQUEST	= 'request';
	
	
	
	/**
	 * @desc	transfered data
	 * @var		array data
	 */
	private		$data = array();
	
	
	/**
	 * @desc	used type
	 * @var		enum $type
	 */
	private		$type = null;
	
	
	
	/**
	 * @desc	parsing PHP superglobals for HTTPRequest to this class
	 * @param	array $request
	 * @param	enum $type
	 */
	public function __construct( $request = array(), $type = HTTPRequest::REQUEST )
	{
		$this->data = $request;
		$this->type = $type;
	}
	
	private function get( $node )
	{
		$node = strtolower($node);
		if( !isset($this->data[$node]) ) {
			throw new Exception('Key has not been found');
		}
		return $this->data[$node];
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
					return $this->get( (substr($method,3)), $args );			
					break;
		}
		
	}
}