<?php

namespace MagicMonkey\MiniJournal\Entity;

use MagicMonkey\Framework\Inheritance\Entity\AbstractEntity;

class Image extends AbstractEntity
{
    private $name;
    private $path;
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
        parent::__construct($id);
        $this->name = $name;
        $this->path = $path;
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
