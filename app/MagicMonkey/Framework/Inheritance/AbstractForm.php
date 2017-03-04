<?php

namespace MagicMonkey\Framework\Inheritance;

use MagicMonkey\Framework\Validator\ValidatorManager;

abstract class AbstractForm
{
    protected $errors;
    protected $objectName;
    protected $validatorManager;

    abstract protected function validationOptions();

    protected function __construct($objectName)
    {
        $this->errors = array();
        $this->validatorManager = new ValidatorManager();
        $this->objectName = $objectName;
    }

    /* Permet l'affichage des notifications/messages afin d'informer l'utilisateur */
    public function showMsg($key, $error = true)
    {
        $res = "";
        if (array_key_exists($key, $this->errors)) {
            $class = "error";
            if (!$error) {
                $class = "success";
            }
            $res = "<span class='msg-" . $class . " marg-10-bottom'>";
            $res .= $this->errors[$key];
            $res .= "</span>";
        }
        return $res;
    }

    public function validate($postedData)
    {
        $this->validationOptions();
        $this->errors = $this->validatorManager->validate($postedData);
        if (count($this->errors) > 0) {
            return false;
        }
        return true;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /* ajout d'une erreur dans l'array errors */
    public function addErrors($newItem)
    {
        array_push($this->errors, $newItem);
    }
}
