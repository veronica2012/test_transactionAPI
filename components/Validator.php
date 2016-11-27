<?php
class Validator extends Component
{
    public static $validators = [
        'required' => 'required',
        'numeric' => 'numeric',
        'email' => 'email',
        'length' => 'length'
    ];


    public function validate(ActiveRecord $model, $params) {
        $attributes = isset($params[0]) ? $params[0] : '';
        $validator = isset($params[1]) ? $params[1] : null;
        $args = isset($params[2]) ? $params[2] : [];
        if(empty($validator)) {
            throw new Exception('Validator name should be set');
        }

        $validatorFn = 'validate' . ucfirst(strtolower($validator));
        if(!is_callable([$this, $validatorFn])) {
            throw new Exception("Invalid validator name '{$validator}''");
        }

        if(!isset($attributes)) {
            throw new Exception('Attributes should be set');
        }
        $attributes = explode(',', $attributes);

        if(empty($attributes)) {
            throw new Exception('Attributes should be set');
        }

        foreach($attributes as $attribute) {
            $attribute = trim($attribute);

            call_user_func([$this, $validatorFn], $model, $attribute, $args);
        }
    }


    public function validateRequired(ActiveRecord $model, $attribute) {
        if($model->$attribute === null || $model->$attribute === '') {
            $model->addError($attribute, "$attribute is required");
        }

    }

    public function validateEmail(ActiveRecord $model, $attribute) {
        $pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
        if(!preg_match($pattern, $model->$attribute)) {
            $model->addError($attribute, "{$attribute} must be a valid email");
        }
    }

    public function validateNumeric(ActiveRecord $model, $attribute, $args = []) {
        if(!is_numeric($model->$attribute)) {
            $model->addError($attribute, "$attribute must be numeric");
        }

        if(isset($args['max']) && $model->$attribute > $args['max']) {
            $model->addError($attribute, "$attribute cannot be more than {$args['max']}");
        }

        if(isset($args['min']) && $model->$attribute < $args['min']) {
            $model->addError($attribute, "$attribute cannot be less than {$args['min']}");
        }

    }

    public function validateLength(ActiveRecord $model, $attribute, $args) {
        if(is_array($model->$attribute)) {
            $model->addError($attribute, "$attribute is invalid");
            return;
        }

        $length = strlen($model->$attribute);

        if(isset($args['max']) && $length > $args['max']) {
            $model->addError($attribute, "$attribute is too long (maximum is {$args['max']} characters)");
        }

        if(isset($args['min']) && $length < $args['min']) {
            $model->addError($attribute, "$attribute is too short (minimum is {$args['min']} characters)");
        }
    }

}