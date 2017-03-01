<?php

namespace MagicMonkey\Framework\Validator\Type;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

class Url extends AbstractValidator implements ValidatorTypeInterface
{
    public function validate($value)
    {
        return filter_var($value, FILTER_VALIDATE_URL);
    }

    protected function setMessage()
    {
        $this->message = "La valeur ne respecte pas le format d'une adresse réticulaire (URL)";
    }
}
