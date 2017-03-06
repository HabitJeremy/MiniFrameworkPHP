<?php

namespace MagicMonkey\Framework\Validator\Type;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

/**
 * Permet de valider une valeur selon un maximum de caractères
 * Class MaxLength
 * @package MagicMonkey\Framework\Validator\Type
 */
class MaxLength extends AbstractValidator implements ValidatorTypeInterface
{
    /**
     * @var null
     */
    private $max;

    /**
     * MaxLength constructor.
     * @param null $max
     * @param null $message
     */
    public function __construct($max, $message = null)
    {
        parent::__construct($message);
        $this->max = $max;
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        if (strlen($value) > $this->max) {
            return false;
        }
        return true;
    }

    /**
     *
     */
    protected function setMessage()
    {
        $this->message = "La valeur ne doit pas dépasser ".$this->max." caractères";
    }
}
