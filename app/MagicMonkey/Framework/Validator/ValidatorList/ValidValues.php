<?php

namespace MagicMonkey\Framework\Validator\ValidatorList;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

/**
 * Permet de valider plusieurs valeurs selon liste de valeurs possibles
 * Class ValidValues
 * @package MagicMonkey\Framework\Validator\ValidatorList
 */
class ValidValues extends AbstractValidator implements ValidatorTypeInterface
{

    /**
     * @var null
     */
    private $possibleValues;


    /**
     * ValidArrayValues constructor.
     * @param null $possibleValues
     * @param null $message
     */
    public function __construct($possibleValues, $message = null)
    {
        parent::__construct($message);
        $this->possibleValues = $possibleValues;
    }

    /**
     * @param $arrayValues
     * @return bool
     */
    public function validate($arrayValues)
    {
        if (isset($arrayValues) && count($arrayValues) > 0) {
            foreach ($arrayValues as $value) {
                if (!in_array($value, $this->possibleValues)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     *
     */
    protected function setMessage()
    {
        $this->message = "Chaque valeur doit correspondre à une valeur valide";
    }
}
