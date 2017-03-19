<?php

namespace MagicMonkey\Framework\Validator\ValidatorList;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

/**
 * Permet de valider une valeur selon une liste de valeurs possibles
 * Class ValidValues
 * @package MagicMonkey\Framework\Validator\ValidatorList
 */
class ValidValue extends AbstractValidator implements ValidatorTypeInterface
{
    /**
     * @var null
     */
    private $possibleValues;

    /**
     * ValidValues constructor.
     * @param null $possibleValues
     * @param null $message
     */
    public function __construct($possibleValues, $message = null)
    {
        parent::__construct($message);
        $this->possibleValues = $possibleValues;
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        if (!in_array($value, $this->possibleValues)) {
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
