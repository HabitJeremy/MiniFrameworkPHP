<?php

namespace MagicMonkey\Framework\Validator\Type;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

/**
 * Permet de valider une valeur non nulle
 * Class NotNull
 * @package MagicMonkey\Framework\Validator\Type
 */
class NotNull extends AbstractValidator implements ValidatorTypeInterface
{
    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        return $value == !null;
    }

    /**
     *
     */
    protected function setMessage()
    {
        $this->message = "La valeur ne doit pas être nulle";
    }
}
