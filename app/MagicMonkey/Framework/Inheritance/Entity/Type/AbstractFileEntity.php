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
     * @var
     */
    protected $author;
    /**
     * @var
     */
    protected $creationDate;
    /**
     * @var
     */
    protected $publicationDate;
    /**
     * @var
     */
    protected $publicationStatus;

    /**
     * AbstractFileEntity constructor.
     * @param $path
     * @param $author
     * @param $creationDate
     * @param $publicationDate
     * @param $publicationStatus
     */
    public function __construct($id, $path, $author, $creationDate, $publicationDate, $publicationStatus)
    {
        parent::__construct($id);
        $this->path = $path;
        $this->author = $author;
        $this->creationDate = $creationDate;
        $this->publicationDate = $publicationDate;
        $this->publicationStatus = $publicationStatus;
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

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @param mixed $publicationDate
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
    }

    /**
     * @return mixed
     */
    public function getPublicationStatus()
    {
        return $this->publicationStatus;
    }

    /**
     * @param mixed $publicationStatus
     */
    public function setPublicationStatus($publicationStatus)
    {
        $this->publicationStatus = $publicationStatus;
    }

    /* ### GETTERS & SETTERS ### */

}
