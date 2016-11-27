<?php
class HttpException extends Exception
{
    public $statusCode;


    public function __construct($status, $message = null, $code = 0, Exception $previous = null)
    {
        $this->statusCode = $status;

        parent::__construct($message, $code, $previous);
    }
}