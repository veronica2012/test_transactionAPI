<?php

class ActiveRecord extends Component
{

    public $isNewRow = true;
    protected $_pk;
    protected $_attributes = [];
    public $tableName;
    public $rules = [];
    protected $_errors = [];

    public function __construct($config = []) {
        parent::__construct($config);
        $this->getAttributes();
    }


    public function getAttributes() {
        $db = Application::getInstance()->db;
        $columns = $columns = $db->query("SHOW COLUMNS FROM $this->tableName");
        if(empty($this->_attributes)) {
            foreach ($columns as $column)
            {
                $this->_attributes[$column['Field']] = null;
                if ($column['Key'] == 'PRI')
                {
                    $this->_pk = $column['Field'];
                    $this->_attributes[$column['Field']] = 0;
                }
            }
        }

        return $this->_attributes;
    }

    public function __set($propertyName, $value) {
        if (array_key_exists($propertyName, $this->_attributes))
        {
            $this->_attributes[$propertyName] = $value;
            return true;
        }

        parent::__set($propertyName, $value);
    }

    public function __get($propertyName) {
        if (array_key_exists($propertyName, $this->_attributes))
        {
            return $this->_attributes[$propertyName];
        }
        parent::__get($propertyName);
    }


    public function findByPk($pk) {
        $result = $this->findByFieldName($this->_pk, $pk);
        list($a) = $result;
        return $a;
    }

    public function __call($methodName, $parameters) {
        throw new Exception('Method ' . $methodName . ' does not exist!');
    }

    public function save($runValidation = true) {
        if($runValidation) {
            $result =  $this->validate();
            if(!$result) {
                return false;
            }
        }

        $result = $this->isNewRow ? $this->insert() : $this->update();

        if($result) {
            $this->isNewRow = false;
        }

        return true;
    }

    public function insert() {
        $db = Application::getInstance()->db;

        foreach ($this->_attributes as $key => $value)
        {
            $fields[] = $key;
            $params[':' . $key] = $value;
            $values[] = ":$key";
        }
        $fields = implode(',', $fields);
        $values = implode(',', $values);
        $query = "INSERT INTO $this->tableName ($fields) VALUES ($values)";
        return $db->execute($query, $params);
    }

    public function update() {
        $db = Application::getInstance()->db;
        $query = "UPDATE $this->tableName SET ";
        $params = array();
        foreach ($this->_attributes as $key => $value)
        {
            $queryParts[] = "$key = :$key";
            $params[':' . $key] = $value;
        }
        $query .= implode(',', $queryParts);
        $query .= " WHERE $this->_pk = :$this->_pk";
        return $db->execute($query, $params);
    }


    public function delete()
    {
        $id = $this->_pk;
        $db = Application::getInstance()->db;
        $query = "DELETE FROM $this->tableName WHERE id = :$id";
        $params = array(":id"=>$id);
        return $db->execute($query, $params);
    }

    public static function model($className = __CLASS__) {
        return new $className();
    }

    public  function convertToArray () {
        $item = [];
        foreach ($this->_attributes as $key => $value)
        {
            $item[$key] = $value;
        }

        return $item;
    }

    public function validate() {
        if(is_array($this->rules) && !empty($this->rules)) {
            foreach($this->rules as $rule) {
                $validator = new Validator();
                $validator->validate($this, $rule);
            }
        }

        return $this->hasErrors();
    }

    public function hasErrors() {
        return empty($this->_errors);
    }

    public function getErrors($attribute = null) {
        if($attribute===null) {
            return $this->_errors;
        } else {
            return isset($this->_errors[$attribute]) ? $this->_errors[$attribute] : [];
        }
    }

    public function addError($attribute,$error) {
        $this->_errors[$attribute][]=$error;
    }

    public function addErrors($errors) {
        foreach($errors as $attribute => $error)
        {
            if(is_array($error))
            {
                foreach($error as $e)
                    $this->addError($attribute, $e);
            }
            else
                $this->addError($attribute, $error);
        }
    }

    public function setAttributes($attributes = []) {
        if(!is_array($attributes)) {
            throw new Exception("Attributes should be array");
        }

        foreach($attributes as $attribute => $value) {
            $this->$attribute = $value;
        }

        return true;
    }
}

