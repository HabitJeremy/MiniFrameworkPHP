<?php

namespace MagicMonkey\Framework\Validator\Type;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

/**
 * Created by PhpStorm.x
 * User: Jeremy
 * Date: 27/02/2017
 * Time: 10:56
 */
class Valid extends AbstractValidator implements ValidatorTypeInterface
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
