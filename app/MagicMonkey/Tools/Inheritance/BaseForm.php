<?php

namespace MagicMonkey\Tools\Inheritance;

/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 24/02/2017
 * Time: 10:11
 */

abstract class BaseForm
{
    protected $errors;
    protected $objectName;

    protected function __construct($objectName)
    {
        $this->errors = array();
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

    /* show form new article */
    public function formNewUpdate($h1, $htmlPath, $obj = null, $action = "insert")
    {
        $fullPath = APP_BASEFILE . DIRECTORY_SEPARATOR . $htmlPath;
        if (!empty($obj)) {
            $this->{$this->objectName} = $obj;
        }
        ob_start();
        include $fullPath;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
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
