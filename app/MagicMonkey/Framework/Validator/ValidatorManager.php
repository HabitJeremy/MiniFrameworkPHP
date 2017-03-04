<?php

namespace MagicMonkey\Framework\Validator;

use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

class ValidatorManager
{
    private $validatorsList = array();

    public function add($propriete, ValidatorTypeInterface $validator)
    {
        $this->validatorsList[] = [$propriete, $validator];
        return $this;
    }

    public function validate($postedData)
    {
        $errors = array();
        foreach ($this->validatorsList as $item) {
            $field = $item[0];
            $validator = $item[1];
            if (!$validator->validate($postedData[$field])) {
                $errors[$field] = $validator->getMessage();
            }
        }
        return $errors;
    }
}
