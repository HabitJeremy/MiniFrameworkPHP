<?php

namespace MagicMonkey\Framework\Validator\Type;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

class NotBlank extends AbstractValidator implements ValidatorTypeInterface
{
    public function validate($value)
    {
        return $value ==! "";
    }

    protected function setMessage()
    {
        $this->message = "La valeur ne doit pas être vide";
    }
}
