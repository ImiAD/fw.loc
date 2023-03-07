<?php

class NotFoundException extends Exception
{
    public function __construct( string $message = "", int $code = 404)
    {
        parent::__construct($message, $code);
    }
}

class ErrorHandler
{

}

new ErrorHandler();

//echo $Test;
//Test();
//try {
//    if (empty($Test)) {
//        throw new \Exception('ПечалькА!');
//    }
//} catch (\Exception $e) {
//    echo $e->getMessage();
//    var_dump($e);
//}
//throw new \Exception('ПечалькА!');
//throw new NotFoundException('No page');

