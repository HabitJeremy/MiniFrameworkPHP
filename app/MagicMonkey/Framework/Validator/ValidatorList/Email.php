<?php

namespace MagicMonkey\Framework\Validator\ValidatorList;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

/**
 * Permet de valider une valeur en tant qu'adresse email
 * Class Email
 * @package MagicMonkey\Framework\Validator\ValidatorList
 */
class Email extends AbstractValidator implements ValidatorTypeInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function validate($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     *
     */
    protected function setMessage()
    {
        $this->message = "La valeur ne respecte pas le format d'une adresse email";
    }
}
