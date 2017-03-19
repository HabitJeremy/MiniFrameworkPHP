<?php

namespace MagicMonkey\Framework\Inheritance;

/**
 * Classe abstraite permettant de définir des fonctions et des attributs de base pour les classes "validator"
 * Class AbstractValidator
 * @package MagicMonkey\Framework\Inheritance
 */
/**
 * Class AbstractValidator
 * @package MagicMonkey\Framework\Inheritance
 */
/**
 * Class AbstractValidator
 * @package MagicMonkey\Framework\Inheritance
 */
abstract class AbstractValidator
{
    /**
     * @var null
     */
    protected $message;

    /**
     * @return mixed
     */
    abstract protected function setMessage();

    /**
     * Constructeur
     * AbstractValidator constructor.
     * @param null $message
     */
    public function __construct($message = null)
    {
        if ($message === null) {
            $this->setMessage();
        } else {
            $this->message = $message;
        }
    }

    /**
     * @return null
     */
    public function getMessage()
    {
        return $this->message;
    }
}
