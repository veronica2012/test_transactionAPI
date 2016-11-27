<?php


class Controller extends Component
{
    public $defaultAction = 'index';

    public $action;

    public $id;

    public function __construct($id) {
        $this->id = $id;
    }


    public function runAction($id) {

        $id = $id ? $id : $this->defaultAction;

        $isMethodNameValid = preg_match('/^[a-z0-9\\-_]+$/', $id) && strpos($id, '--') === false && trim($id, '-') === $id;
        if(!$isMethodNameValid) {
            throw new HttpException(404, "Unable to resolve {$this->id}/$id");
        }

        $methodName = 'action' . str_replace(' ', '', ucwords(implode(' ', explode('-', $id))));

        if(!method_exists($this, $methodName)) {
            throw new HttpException(404, "Unable to resolve {$this->id}/$id");
        }

        $method = new \ReflectionMethod($this, $methodName);

        $canCallThisMethod = $method->isPublic() && $method->getName() === $methodName;

        if (!$canCallThisMethod) {
            throw new HttpException(404, "Unable to resolve {$this->id}/$id");
        }

        $call = array($this, $methodName);
        return call_user_func($call);

    }

    public function run($actionId) {
        if(!isset($actionId)) {
            $actionId = $this->defaultAction;
        }

        return $this->runAction($actionId);
    }
}