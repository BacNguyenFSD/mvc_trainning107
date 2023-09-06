<?php

class Request {

    private $__rules = [], $__messages = [];
    public $errors = [];

    /**
     * 1. method
     * 2. Body
     */
    public function getMethod() {
        return strtolower($_SERVER['REQUEST_METHOD']);   
    }

    public function isPost() {
        if ($this->getMethod() == 'post') {
            return true;
        }

        return false;
    }

    public function isGet() {
        if ($this->getMethod() == 'get') {
            return true;
        }

        return false;
    }

    public function getFields() {

        $dataField = []; 
        
        if ($this->isGet()) {
            //Xử lý lấy dữ liệu với phương thức get
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    if (is_array($value)) {
                        $dataField[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataField[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }

        if ($this->isPost()) {
            //Xử lý lấy dữ liệu với phương thức get
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    if (is_array($value)) {
                        $dataField[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataField[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                    
                }
            }
        }

        return $dataField;
    }

    //set rules
    public function rules($rules=[]) {
        $this->__rules = $rules;
    }

    //set message
    public function message($message=[]) {
        $this->__messages = $message;
    }

    //run validate
    public function validate() {

        $this->__rules = array_filter($this->__rules);

        $checkValidate = true;

        if (!empty($this->__rules)) {

            $dataFields = $this->getFields();

            foreach ($this->__rules as $fieldName=>$ruleItem) {

                $ruleItemArr = explode('|', $ruleItem);
                // echo $fieldName;
                
                foreach ($ruleItemArr as $rules) {
                    $ruleName = null;
                    $ruleValue = null;
                    
                    $rulesArr = explode(':', $rules);

                    $ruleName = reset($rulesArr);

                    if (count($rulesArr)>1) {
                        $ruleValue = end($rulesArr);
                    } 

                    if ($ruleName == 'required') {
                        // echo '<pre>';
                        // print_r($dataFields);
                        // echo '</pre>';
                        echo $dataFields[$fieldName];
                        if (empty(trim($dataFields[$fieldName]))) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'min') {
                        if (strlen(trim($dataFields[$fieldName]))<$ruleValue) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'max') {
                        if (strlen(trim($dataFields[$fieldName]))<$ruleValue) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'email') {
                        if (!filter_var($dataFields[$fieldName], FILTER_VALIDATE_EMAIL)) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'match') {
                        if (trim($dataFields[$fieldName])!=trim($dataFields[$ruleValue])) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }
                }
            }
        }

        return $checkValidate;
    }

    //Get Errors
    public function errors($fieldName='') {
        if (!empty($this->errors)) {
            if (empty($fieldName)) {
                return $this->errors;
            }
            return reset($this->errors[$fieldName]);
        }
        return false;
    }

    //set errors
    public function setErrors($fieldName, $ruleName) {
        $this->errors[$fieldName][$ruleName] = $this->__messages[$fieldName.'.'.$ruleName];
    }
}