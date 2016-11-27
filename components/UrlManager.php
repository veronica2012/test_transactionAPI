<?php



class UrlManager extends Component
{

    public $rules = [];


    public function getRoute(Request $request) {
        $pathInfo = $request->getPathInfo();

        if(isset($pathInfo)) {
            $pathInfo = trim($pathInfo, '/');

        }else{
            $pathInfo = '/';
        }

        return $pathInfo;
    }


    public function isRequestMethodValid($controller, Request $request) {
        $result = true;

        foreach($this->rules as $rule) {
            if(strpos($rule['controller'], $controller) === 0) {
                $result = in_array($request->getMethod(), $rule['allowedMethods'], true);
            }
        }

        return $result;
    }
}