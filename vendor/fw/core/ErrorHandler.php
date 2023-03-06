<?php

namespace fw\core;

class ErrorHandler
{
    public function __construct()
    {
        if (DEBUG) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }

        set_error_handler([$this, 'errorHandler']);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
    }

    /**
     *Обработка не фатальных ошибок
     */
    public function errorHandler(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        $this->logErrors($errstr, $errfile, $errline);

        if (DEBUG || in_array($errno, [E_USER_ERROR, E_RECOVERABLE_ERROR])) {
            $this->displayError($errno, $errstr, $errfile, $errline);
        }

        return true;
    }

    public function fatalErrorHandler()
    {
        $error = error_get_last();

        if (!empty($error) && $error['type'] &  E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR) {
            $this->logErrors($error['message'], $error['file'], $error['line']);
            ob_end_clean();
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
            ob_end_flush();
        }
    }

    protected function displayError($errno, string $errstr, string $errfile, int $errline, int $response = 500)
    {
        http_response_code($response);

        if ($response == 404 && !DEBUG) {
            require_once WWW . '/errors/404.html';
            die;
        }

        if (DEBUG) {
            require_once WWW . '/errors/dev.php';
        } else {
            require_once WWW . '/errors/prod.php';
        }

        die;
    }

    public function exceptionHandler($e)
    {
        $this->logErrors($e->getMessage(),$e->getFile(), $e->getLine());
        $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }

    public function logErrors($message = '', $file = '', $line ='')
    {
        error_log("[".date('d-m-y h-m-s')."] Текст ошибки: {$message} 
        | Файл: {$file} | Строка: {$line}
        \n===========================================\n", 3, ROOT.'/tmp/errors.log');
    }
}