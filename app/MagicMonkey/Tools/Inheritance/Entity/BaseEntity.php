<?php

namespace MagicMonkey\Tools\Inheritance\Entity;

use MagicMonkey\Tools\InterfaceRepository\BaseEntityInterface;

/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 24/02/2017
 * Time: 10:11
 */
abstract class BaseEntity implements BaseEntityInterface
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
