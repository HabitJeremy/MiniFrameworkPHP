<?php

namespace MagicMonkey\Framework\Inheritance\Entity;

use MagicMonkey\Framework\InterfaceRepository\EntityInterface;

/**
 * Classe abstraite permettant de définir des attributs et des functions de base pour les classes "Entity"
 * Class AbstractEntity
 * @package MagicMonkey\Framework\Inheritance\Entity
 */
abstract class AbstractEntity implements EntityInterface
{
    /**
     * @var
     */
    protected $id;

    /**
     * Constructor
     * AbstractEntity constructor.
     * @param $id
     */
    protected function __construct($id)
    {
        $this->id = $id;
    }

    /* ### GETTERS & SETTERS ### */

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
