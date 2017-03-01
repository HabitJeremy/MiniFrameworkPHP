<?php

namespace MagicMonkey\Framework\Validator\Type;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

class Email extends AbstractValidator implements ValidatorTypeInterface
{
    public function validate($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    protected function setMessage()
    {
        $this->message = "La valeur ne respecte pas le format d'une adresse email";
    }
}
