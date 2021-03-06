<?php

namespace Exception;

class NotFoundException extends HttpException {
    private $statusCode;
    
    public function __construct($statusCode, $message = null, \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
                       
        $this->statusCode = $statusCode;
    }
                            
    public function getStatusCode()
    {
        return $this->statusCode;
    }

}

?>
