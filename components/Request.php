<?php


class Request extends Component
{

    public function getMethod() {

        if (isset($_SERVER['REQUEST_METHOD'])) {
            return strtoupper($_SERVER['REQUEST_METHOD']);
        }

        return 'GET';

    }

    public function getRequestUri() {
        if (isset($_SERVER['REQUEST_URI'])) {
            return $_SERVER['REQUEST_URI'];
        }
    }


    public function getPathInfo() {
        if (isset($_SERVER['PATH_INFO'])) {
            return $_SERVER['PATH_INFO'];
        }

        return null;
    }


    public function getRawBody() {
        $rawBody = file_get_contents('php://input');
        return $rawBody;
    }

    public function getParam($name, $defaultValue = null) {

        return isset($_GET[$name]) ? $_GET[$name] : (isset($_POST[$name]) ? $_POST[$name] : $defaultValue);

    }
}