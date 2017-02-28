<?php
/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 27/02/2017
 * Time: 11:39
 */

namespace MagicMonkey\Framework\Validator;

use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

class ValidatorManager
{
    private $validatorsList;

    public function __construct()
    {
        $this->validatorsList = array();
    }

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
            if(!$validator->validate($postedData[$field])){
                $errors[$field] = $validator->getMessage();
            }
        }
        return $errors;
    }
}