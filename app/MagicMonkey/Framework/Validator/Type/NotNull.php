<?php

namespace MagicMonkey\Framework\Validator\Type;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

class NotNull extends AbstractValidator implements ValidatorTypeInterface
{
    public function validate($value)
    {
        if ($value === null) {
            return false;
        }
        return true;
    }

    protected function setMessage()
    {
        $this->message = "La valeur ne doit pas être nulle";
    }
}
