<?php

namespace MagicMonkey\Framework\Validator\ValidatorList;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

/**
 * Permet de valider plusieurs valeurs selon une liste d'identifiants d'enregistrements d'une table de la bdd
 * Class ValidObjects
 * @package MagicMonkey\Framework\Validator\ValidatorList
 */
class ValidObjects extends AbstractValidator implements ValidatorTypeInterface
{

    /**
     * @var null
     */
    private $classBdFqdn;

    /**
     * ValidObjects constructor.
     * @param null $classBdFqdn
     * @param null $message
     */
    public function __construct($classBdFqdn, $message = null)
    {
        parent::__construct($message);
        $this->classBdFqdn = $classBdFqdn;
    }

    /**
     * @param $arrayValues
     * @return bool
     */
    public function validate($arrayValues)
    {
        if (isset($arrayValues) && count($arrayValues) > 0) {
            foreach ($arrayValues as $value) {
                if (!in_array($value, $this->getPossibleIds())) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Permet de retourner le tableau des identifiants possibles
     * @return array
     */
    private function getPossibleIds()
    {
        $possibleIds = array();
        $allObjects = (new $this->classBdFqdn())->selectAll();
        if (isset($allObjects) && count($allObjects) > 0) {
            foreach ($allObjects as $anObject) {
                $possibleIds[] = $anObject->getId();
            }
        }
        return $possibleIds;
    }

    /**
     *
     */
    protected function setMessage()
    {
        $this->message = "Chaque valeur doit correspondre à une valeur valide";
    }
}
