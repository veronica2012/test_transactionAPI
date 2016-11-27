<?php


class ErrorHandler extends Component
{
    public function register() {
        ini_set('display_errors', false);
        set_exception_handler([$this, 'handleException']);

        set_error_handler([$this, 'handleError']);

        register_shutdown_function([$this, 'handleFatalError']);
    }

    public function unregister() {
        restore_error_handler();
        restore_exception_handler();
    }

    public function handleError($code, $message, $file, $line) {
        $this->renderException(500, $line, $file, $message);
    }

    public function handleFatalError() {
        $error = error_get_last();
        if(isset($error)) {
            $this->renderException(500, $error['file'], $error['line'], $error['message']);
        }
    }

    public function handleException($exception) {
        $statusCode = $exception instanceof HttpException ? $exception->statusCode : 500;
        $message = $exception->getMessage();

        $this->renderException($statusCode, $exception->getLine(), $exception->getFile(), $message);
    }

    public function formatErrorAsArray($statusCode, $line, $file, $message) {
        return [
            'status' => $statusCode,
            'line' => $line,
            'file' => $file,
            'message' => $message
        ];
    }

    public function renderException($statusCode, $line, $file, $message = '') {
        $response = Application::getInstance()->getResponse();
        $response->setStatusCode($statusCode);
        if($message) {
            $response->statusText = $message;
        }

        $response->content = $this->formatErrorAsArray($statusCode, $line, $file, $response->statusText);

        $response->send();
    }

}