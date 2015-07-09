<?php
class O2Exception extends Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // some code
    
        // make sure everything is assigned properly
        parent::__construct($message['message'], $code, $previous);
		echo $this->getMessage();
		exit;
    }
}