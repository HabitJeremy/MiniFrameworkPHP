<?php

namespace MagicMonkey\Framework\Inheritance\Entity\Type;

use MagicMonkey\Framework\Inheritance\Entity\AbstractEntity;

abstract class AbstractDocumentEntity extends AbstractEntity
{
    protected $title;
    protected $author;
    protected $creationDate;
    protected $publicationDate;
    protected $publicationStatus;

    protected function __construct($id, $title, $author, $creationDate, $publicationDate, $publicationStatus)
    {
        parent::__construct($id);
        $this->title = $title;
        $this->author = $author;
        $this->creationDate = $creationDate;
        $this->publicationDate = $publicationDate;
        $this->publicationStatus = $publicationStatus;
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
