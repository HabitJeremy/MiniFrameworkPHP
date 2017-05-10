<?php

namespace MagicMonkey\MiniJournal\Entity;

use MagicMonkey\Framework\Inheritance\Entity\Type\AbstractFileEntity;

/**
 * Class Image
 * @package MagicMonkey\MiniJournal\Entity
 */
class Image extends AbstractFileEntity
{
    /**
     * @var null
     */
    private $name;
    /**
     * @var null
     */
    private $attrAlt;


    /**
     * Image constructor.
     * @param null $id
     * @param null $name
     * @param null $path
     * @param null $attrAlt
     * @param null $author
     * @param null $publicationStatus
     * @param null $creationDate
     * @param null $publicationDate
     */
    public function __construct(
        $id = null,
        $name = null,
        $path = null,
        $attrAlt = null,
        $author = null,
        $publicationStatus = null,
        $creationDate = null,
        $publicationDate = null
    ) {
        parent::__construct($id, $path, $author, $creationDate, $publicationDate, $publicationStatus);
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
