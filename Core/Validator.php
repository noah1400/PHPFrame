<?php

namespace Core;

class Validator {

    private $errors = [];

    public function validate($data, $rules) {
        $this->errors = [];
        foreach ($rules as $key => $ruleDef) {
            $rulesDict = $this->createRulesDict($ruleDef);
            foreach ($rulesDict as $ruleName => $ruleValue) {
                $ruleMethod = $ruleName;
                $ruleValue = $ruleValue ?? null;
                $this->$ruleMethod($key, $data[$key], $ruleValue);
            }
        }
    }

    private function createRulesDict($ruleDef){
        // 'email>>required|email|min:5|max:10;password>>required|min:5|max:10'
        $rules = explode(';', $ruleDef);
        $rulesDict = [];
        foreach ($rules as $rule) {
            $rule = explode('>>', $rule);
            $field = $rule[0];
            $ruleString = $rule[1];
            $rulesDict[$field] = $this->parseRuleString($ruleString);
        }
        return $rulesDict;
    }

    private function parseRuleString($ruleString){
        // 'required|email|min:5|max:10'
        $rules = explode('|', $ruleString);
        $rulesDict = [];
        foreach ($rules as $rule) {
            $rule = explode(':', $rule);
            $ruleName = $rule[0];
            $ruleValue = $rule[1] ?? null;
            $rulesDict[$ruleName] = $ruleValue;
        }
        return $rulesDict;
    }

    private function required($key, $value) {
        if (empty($value)) {
            $this->addError($key, 'The ' . $key . ' field is required');
        }
    }

    private function addError($key, $message) {
        $this->errors[$key][] = $message;
    }

    public function hasError($key) {
        return isset($this->errors[$key]);
    }

    private function string($key, $value) {
        if (!is_string($value) || strlen(trim($value)) == 0) {
            $this->addError($key, 'The ' . $key . ' field must be a string');
        }
    }

    private function integer($key, $value) {
        if (!is_int($value)) {
            $this->addError($key, 'The ' . $key . ' field must be an integer');
        }
    }

    private function float($key, $value) {
        if (!is_float($value)) {
            $this->addError($key, 'The ' . $key . ' field must be a float');
        }
    }

    private function boolean($key, $value) {
        if (!is_bool($value)) {
            $this->addError($key, 'The ' . $key . ' field must be a boolean');
        }
    }

    private function array($key, $value) {
        if (!is_array($value)) {
            $this->addError($key, 'The ' . $key . ' field must be an array');
        }
    }

    private function maxLen($key, $value, $max) {
        if (strlen($value) > $max) {
            $this->addError($key, 'The ' . $key . ' field must be at most ' . $max . ' characters');
        }
    }

    private function minLen($key, $value, $min) {
        if (strlen($value) < $min) {
            $this->addError($key, 'The ' . $key . ' field must be at least ' . $min . ' characters');
        }
    }

    private function email($key, $value) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($key, 'The ' . $key . ' field must be a valid email address');
        }
    }

    private function unique($key, $value, $table, $field) {
        $result = App::resolve('Core\Database\Database')->select($table, [$field => $value]);
        if ($result) {
            $this->addError($key, 'The ' . $key . ' field must be unique');
        }
    }

    public function getError($key) {
        return $this->errors[$key][0];
    }

    public function getErrors() {
        return $this->errors;
    }

    public function errors() {
        return $this->errors;
    }

    public function passed() {
        return empty($this->errors);
    }
}