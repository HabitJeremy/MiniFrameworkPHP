<?php

namespace MagicMonkey\Framework\Validator\Type;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

class ValidValues extends AbstractValidator implements ValidatorTypeInterface
{
    private $validValues;

    public function __construct($validValues, $message = null)
    {
        parent::__construct($message);
        $this->validValues = $validValues;
    }

    public function validate($value)
    {
        if (!in_array($value, $this->validValues)) {
            return false;
        }
        return true;
    }

    protected function setMessage()
    {
        $this->message = "La valeur doit correspondre à une valeur valide";
    }
}
