<?php

namespace MagicMonkey\Framework\Validator\ValidatorList;

use DateTime;
use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

/**
 * Permet de valider une valeur en tant que Date and time
 * Class DateAndTime
 * @package MagicMonkey\Framework\Validator\ValidatorList
 */
class DateAndTime extends AbstractValidator implements ValidatorTypeInterface
{
    /**
     * @param $value
     * @return DateTime
     */
    public function validate($value)
    {
        return DateTime::createFromFormat('Y-m-d G:i:s', $value);
    }

    /**
     *
     */
    protected function setMessage()
    {
        $this->message = "La valeur ne respecte pas le format d'une date et d'une heure";
    }
}
