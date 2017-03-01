<?php

namespace MagicMonkey\Framework\Inheritance\Entity;

use MagicMonkey\Framework\InterfaceRepository\EntityInterface;

abstract class AbstractEntity implements EntityInterface
{
    protected $id;

    protected function __construct($id)
    {
        $this->id= $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAttr()
    {
        return get_object_vars($this);
    }
}
