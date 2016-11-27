<?php


class Application extends Component
{
    public $defaultController = 'site';

    private $_controller;

    private $_controllerPath = 'controllers';

    protected $_components = [];

    private static $_selfInstance = null;


    public static function getInstance()
    {
        return self::$_selfInstance;
    }


    public function __construct($config = []) {

        if (is_object(self::$_selfInstance))
        {
            throw new Exception('Application instance has been already created!');
        }
        self::$_selfInstance = $this;

        parent::__construct($config);

        $this->registerErrorHandler($config);

    }


    public function processRequest() {

        $route = $this->getUrlManager()->getRoute($this->getRequest());

        $result = $this->runController($route);

        if($result instanceof Response) {
            $result->send();
        }

        $response = $this->getResponse();

        if ($result !== null) {
            if(is_bool($result)) {
                $response->data = ['result' => $result];
            }else{
                $response->data = $result;
            }

        }

        $response->send();
    }

    public function runController($route = '/') {
        $ca = $this->createController($route);

        if(!isset($ca)) {
            throw new HttpException(404, "Unable to resolve the request {$route}");
        }

        list($controller,$actionId) = $ca;

        $this->_controller = $controller;

        return $controller->run($actionId);

    }

    public function createController($route = '/') {

        if(($route = trim($route,'/')) === '')
            $route = $this->defaultController;

        $route .=  '/';

        list($controllerId, $action) = explode('/', $route, 2);

        if(!preg_match('/^\w+$/',$controllerId)) {
            return null;
        }

        $controllerId = strtolower($controllerId);

        $isValidMethod = $this->getUrlManager()->isRequestMethodValid($controllerId, $this->getRequest());
        if(!$isValidMethod) {
            throw new HttpException(405);
        }


        $className =  ucfirst($controllerId) . 'Controller';

        $classFile = $this->getControllerPath() . DIRECTORY_SEPARATOR . $className . '.php';

        if(!file_exists($classFile)) {
            return null;
        }

        if(!class_exists($className, false)) {
            require($classFile);
        }

        if(class_exists($className,false) && is_subclass_of($className,'Controller'))
        {
            return [
                new $className($controllerId),
                $action
            ];
        }

        return null;
    }


    /**
     * @return UrlManager
     */
    public function getUrlManager() {
        return $this->getComponent('urlManager');
    }


    /**
     * @return Request
     */
    public function getRequest() {
        return $this->getComponent('request');
    }

    /**
     * @return Response
     */
    public function getResponse() {
        return $this->getComponent('response');
    }

    public function getComponent($componentName) {

        $componentOrConfig = $this->_components[$componentName];

        if (!is_object($componentOrConfig)) {
            $component = $this->createComponent($componentOrConfig);
            $this->_components[$componentName] = $component;
        } else {
            $component = $componentOrConfig;
        }
        return $component;
    }

    public function hasComponent($componentName) {
        return array_key_exists($componentName, $this->_components);
    }

    public function createComponent(array $componentConfig) {
        $classPath = $componentConfig['class'];

        $className = basename($classPath);

        unset($componentConfig['class']);

        if (empty($className)) {
            throw new Exception('Component config should contain parameter "class"!');
        }

        if (!class_exists($className)) {
            $className = Autoloader::getInstance()->addClassPath($classPath . '.php');
        }

        if (!class_exists($className)) {
            throw new Exception("Cannot get instance of class {$className}!");
        }


        $component = new $className($componentConfig);
        return $component;
    }


    public function getControllerPath() {
        return $this->_controllerPath !== null ?   $this->_controllerPath : 'controllers';
    }


    public function setComponents($components = []) {
        foreach($components as $name => $component) {
            $this->addComponent($name, $component);
        }
        return true;
    }

    public function getComponents() {
        return $this->_components;
    }

    public function addComponent($componentName, $componentObjectOrConfig) {
        if (is_scalar($componentObjectOrConfig)) return false;
        $this->_components[$componentName] = $componentObjectOrConfig;
        return true;
    }

    public function registerErrorHandler($config) {
        if (!isset($config['components']['errorHandler']['class'])) {
            echo "Error: no errorHandler component is configured.\n";
            exit(1);
        }

        $this->getComponent('errorHandler')->register();
    }

    public function __get($propertyName) {
        try {
            return parent::__get($propertyName);
        } catch(Exception $exception) {
            if ($this->hasComponent($propertyName)) {
                return $this->getComponent($propertyName);
            } else {
                throw $exception;
            }
        }
    }

}