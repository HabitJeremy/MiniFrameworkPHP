<?php

namespace MagicMonkey\Framework\Validator\Type;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

/**
 * Permet de valider une valeur selon un minimum de caractères
 * Class MinLength
 * @package MagicMonkey\Framework\Validator\Type
 */
class MinLength extends AbstractValidator implements ValidatorTypeInterface
{
    /**
     * @var null
     */
    private $min;

    /**
     * MinLength constructor.
     * @param null $min
     * @param null $message
     */
    public function __construct($min, $message = null)
    {
        parent::__construct($message);
        $this->min = $min;
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        if (strlen($value) < $this->min) {
            return false;
        }
        return true;
    }

    /**
     *
     */
    protected function setMessage()
    {
        $this->message = "La valeur nécessite au moins ".$this->min." caractères";
    }
}
