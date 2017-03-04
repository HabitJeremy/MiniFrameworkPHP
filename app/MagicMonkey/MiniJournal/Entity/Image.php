<?php

namespace MagicMonkey\MiniJournal\Entity;

use MagicMonkey\Framework\Inheritance\Entity\Type\AbstractFileEntity;

class Image extends AbstractFileEntity
{
    private $name;
    private $attrAlt;

    /**
     * Image constructor.
     * @param $id
     * @param $name
     * @param $path
     * @param $attrAlt
     */
    public function __construct($id = null, $name = null, $path = null, $attrAlt = null)
    {
        parent::__construct($id, $path);
        $this->name = $name;
        $this->attrAlt = $attrAlt;
    }

    /**
     * @return mixed
     */
    public function getAttrAlt()
    {
        return $this->attrAlt;
    }

    /**
     * @param mixed $attrAlt
     */
    public function setAttrAlt($attrAlt)
    {
        $this->attrAlt = $attrAlt;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
