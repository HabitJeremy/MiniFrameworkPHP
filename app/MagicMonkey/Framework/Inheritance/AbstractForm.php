<?php

namespace MagicMonkey\Framework\Inheritance;

use MagicMonkey\Framework\Cleaner\CleanerManager;
use MagicMonkey\Framework\Validator\ValidatorManager;

/**
 * Classe abstraite permettant de définir des fonctions et des attributs de base pour les classes de type "Form"
 * Class AbstractForm
 * @package MagicMonkey\Framework\Inheritance
 */
abstract class AbstractForm
{
    /**
     * @var array
     */
    protected $errors;
    /**
     * @var
     */
    protected $objectName;
    /**
     * @var ValidatorManager
     */
    protected $validatorManager;

    protected $cleanerManager;

    /**
     * @return mixed
     */
    abstract protected function validationOptions();

    abstract public function cleaningOptions();

    /**
     * Constructeur
     * AbstractForm constructor.
     * @param $objectName
     */
    protected function __construct($objectName)
    {
        $this->errors = array();
        $this->cleanerManager = new CleanerManager();
        $this->validatorManager = new ValidatorManager();
        $this->objectName = $objectName;
    }

    /**
     * Permet l'affichage des notifications/messages afin d'informer l'utilisateur
     * @param $key
     * @param bool $error
     * @return string
     */
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

    /**
     * Permet de valider un formulaire selon les configurations de validation d'un objet (dans <objet>Form)
     * @param $postedData
     * @return bool
     */
    public function validate($postedData)
    {
        $this->validationOptions();
        $this->errors = $this->validatorManager->validate($postedData);
        if (count($this->errors) > 0) {
            return false;
        }
        return true;
    }

    public function clean(&$postedData)
    {
        $this->cleaningOptions();
        $this->cleanerManager->clean($postedData);
    }

    /**
     * Permet d'ajouter une erreur dans le tableau erros
     * @param $newItem
     */
    public function addErrors($newItem)
    {
        array_push($this->errors, $newItem);
    }

    /* ### GETTERS & SETTERS ### */

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
}
