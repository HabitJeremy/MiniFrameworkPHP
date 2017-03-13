<?php

namespace MagicMonkey\Framework\Validator;

use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

/**
 * Gère les types de validateur et leur exécution
 * Class ValidatorManager
 * @package MagicMonkey\Framework\Validator
 */
class ValidatorManager
{
    /**
     * @var array
     */
    private $validatorsList = array();

    /**
     * Ajout d'une validation
     * @param $propriete
     * @param ValidatorTypeInterface $validator
     * @return $this
     */
    public function add($propriete, ValidatorTypeInterface $validator)
    {
        $this->validatorsList[] = [$propriete, $validator];
        return $this;
    }

    /**
     * Permet de valider des valeurs selon les validations demandées
     * @param $postedData
     * @return array
     */
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
