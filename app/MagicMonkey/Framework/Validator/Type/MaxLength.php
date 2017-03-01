<?php

namespace MagicMonkey\Framework\Validator\Type;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

class MaxLength extends AbstractValidator implements ValidatorTypeInterface
{
    private $max;

    public function __construct($max, $message = null)
    {
        parent::__construct($message);
        $this->max = $max;
    }

    public function validate($value)
    {
        if (strlen($value) > $this->max) {
            return false;
        }
        return true;
    }

    protected function setMessage()
    {
        $this->message = "La valeur ne doit pas dépasser ".$this->max." caractères";
    }
}
