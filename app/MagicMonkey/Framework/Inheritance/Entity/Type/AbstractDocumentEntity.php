<?php

namespace MagicMonkey\Framework\Inheritance\Entity\Type;

use MagicMonkey\Framework\Inheritance\Entity\AbstractEntity;

/**
 * Classe abstraite permettant de définir des functions et des attributs de base pour les classes "Entity"
 * de type document
 * Class AbstractDocumentEntity
 * @package MagicMonkey\Framework\Inheritance\Entity\Type
 */
abstract class AbstractDocumentEntity extends AbstractEntity
{
    /**
     * @var
     */
    protected $title;
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
     * Constructor
     * AbstractDocumentEntity constructor.
     * @param $id
     * @param $title
     * @param $author
     * @param $creationDate
     * @param $publicationDate
     * @param $publicationStatus
     */
    protected function __construct($id, $title, $author, $creationDate, $publicationDate, $publicationStatus)
    {
        parent::__construct($id);
        $this->title = $title;
        $this->author = $author;
        $this->creationDate = $creationDate;
        $this->publicationDate = $publicationDate;
        $this->publicationStatus = $publicationStatus;
    }

    /* ### GETTERS & SETTERS ### */

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

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
}
