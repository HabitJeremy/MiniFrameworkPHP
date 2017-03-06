<?php

namespace MagicMonkey\Framework\Inheritance\Entity\Type;

use MagicMonkey\Framework\Inheritance\Entity\AbstractEntity;

/**
 * Classe abstraite permettant de définir des functions et des attributs de base pour les classes "Entity"
 * de type file
 * Class AbstractFileEntity
 * @package MagicMonkey\Framework\Inheritance\Entity\Type
 */
abstract class AbstractFileEntity extends AbstractEntity
{
    /**
     * @var
     */
    protected $path;

    /**
     * Constructor
     * AbstractFileEntity constructor.
     * @param $id
     * @param $path
     */
    protected function __construct($id, $path)
    {
        parent::__construct($id);
        $this->path = $path;
    }

    /* ### GETTERS & SETTERS ### */

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }
}
