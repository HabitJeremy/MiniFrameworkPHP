<?php

namespace MagicMonkey\Framework\Validator\ValidatorList;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

/**
 * Permet de valider une valeur non vide
 * Class NotBlank
 * @package MagicMonkey\Framework\Validator\ValidatorList
 */
class NotBlank extends AbstractValidator implements ValidatorTypeInterface
{
    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        return $value ==! "";
    }

    /**
     *
     */
    protected function setMessage()
    {
        $this->message = "La valeur ne doit pas être vide";
    }
}
