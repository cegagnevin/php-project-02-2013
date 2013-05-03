<?php

namespace Http;

class Request
{	
	const GET    = 'GET';

    const POST   = 'POST';

    const PUT    = 'PUT';

    const DELETE = 'DELETE';
 
	private $parameters;
    
	public function  __construct(array $query = array(), array $request = array())
	{
		$this->parameters = array_merge($query, $request);
	}
    
    public function getMethod()
    {
		$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : Request::GET;
		if (self::POST === $method) {
			return $this->getParameter('_method', $method);
		}
        return $method;
    }
    
    public function getUri()
    {
		$uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
		if ($pos = strpos($uri, '?')) 
		{
			$uri = substr($uri, 0, $pos);
		}
		return $uri;
    }
    
    public function getParameter($name, $default = null)
	{
		return $this->parameters[$name];
	}
    
    public static function createFromGlobals()
    {
		//me
		$request = new self($_GET , $_POST);
	
		if(isset($_SERVER['CONTENT_TYPE'])  &&  $_SERVER['CONTENT_TYPE'] === 'application/json') {
			$data    = file_get_contents('php://input');
			$request->parameters = array_merge($request->parameters, @json_decode($data, true));
		}
		return $request;
	}
	
	public function guessBestFormat()
	{
		//formatnegotiator 
		$negociator = new \Negotiation\FormatNegotiator();
		return $negociator->getBest(
			isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : 'text/html',
			array('html', 'json', '*/*')
			
		);
	}
}
