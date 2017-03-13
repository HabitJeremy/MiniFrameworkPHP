<?php

namespace MagicMonkey\Framework\Validator\ValidatorList;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

/**
 * Permet de valider une valeur selon une liste de valeurs données
 * Class ValidValues
 * @package MagicMonkey\Framework\Validator\ValidatorList
 */
class ValidValues extends AbstractValidator implements ValidatorTypeInterface
{
    /**
     * @var null
     */
    private $validValues;

    /**
     * ValidValues constructor.
     * @param null $validValues
     * @param null $message
     */
    public function __construct($validValues, $message = null)
    {
        parent::__construct($message);
        $this->validValues = $validValues;
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        if (!in_array($value, $this->validValues)) {
            return false;
        }
        return true;
    }

    /**
     *
     */
    protected function setMessage()
    {
        $this->message = "La valeur doit correspondre à une valeur valide";
    }
}
