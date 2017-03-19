<?php

namespace MagicMonkey\Framework\Validator\ValidatorList;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

/**
 * Permet de valider une valeur selon une liste d'identifiants d'enregistrements d'une table de la bdd
 * Class ValidObject
 * @package MagicMonkey\Framework\Validator\ValidatorList
 */
class ValidObject extends AbstractValidator implements ValidatorTypeInterface
{

    /**
     * @var string
     */
    private $classBdFqdn;


    /**
     * ValidObject constructor.
     * @param null $classBdFqdn
     * @param null $message
     */
    public function __construct($classBdFqdn, $message = null)
    {
        parent::__construct($message);
        $this->classBdFqdn = $classBdFqdn;
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        if (!in_array($value, $this->getPossibleIds())) {
            return false;
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
        $this->message = "La valeur doit correspondre à une valeur valide";
    }
}
