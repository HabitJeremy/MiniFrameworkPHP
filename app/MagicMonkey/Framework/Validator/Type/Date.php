<?php

namespace MagicMonkey\Framework\Validator\Type;

use DateTime;
use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

class Date extends AbstractValidator implements ValidatorTypeInterface
{
    public function validate($value)
    {
        return DateTime::createFromFormat('Y-m-d G:i:s', $value);
    }

    protected function setMessage()
    {
        $this->message = "La valeur ne respecte pas le format d'une date";
    }
}
