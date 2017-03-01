<?php

namespace MagicMonkey\Framework\Validator\Type;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

class MinLength extends AbstractValidator implements ValidatorTypeInterface
{
    private $min;

    public function __construct($min, $message = null)
    {
        parent::__construct($message);
        $this->min = $min;
    }

    public function validate($value)
    {
        if (strlen($value) < $this->min) {
            return false;
        }
        return true;
    }

    protected function setMessage()
    {
        $this->message = "La valeur ne nécessite au moins ".$this->min." caractères";
    }
}
