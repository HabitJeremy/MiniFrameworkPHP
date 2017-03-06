<?php

namespace MagicMonkey\Framework\Validator\Type;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

/**
 * Permet de valider une valeur en tant que temps
 * Class Time
 * @package MagicMonkey\Framework\Validator\Type
 */
class Time extends AbstractValidator implements ValidatorTypeInterface
{
    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        $p1 = '/^(0?\d|1\d|2[0-3]):[0-5]\d:[0-5]\d$/';
        $p2 = '/^(0?\d|1[0-2]):[0-5]\d\s(am|pm)$/i';
        return preg_match($p1, $value) || preg_match($p2, $value);
    }

    protected function setMessage()
    {
        $this->message = "La valeur ne respecte pas le format d'une heure";
    }
}
