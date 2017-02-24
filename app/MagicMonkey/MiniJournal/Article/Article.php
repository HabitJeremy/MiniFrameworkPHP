<?php

namespace MagicMonkey\MiniJournal\Article;

use MagicMonkey\Tools\Inheritance\Entity;

class Article extends Entity
{
    private $title;
    private $author;
    private $chapo;
    private $content;
    private $publication_status;
    private $creationDate;
    private $publicationDate;

    /**
     * Article constructor.
     * @param $id
     * @param $title
     * @param $author
     * @param $chapo
     * @param $content
     * @param $publication_status
     * @param $creationDate
     * @param $publicationDate
     */
    public function __construct(
        $id = null,
        $title = null,
        $author = null,
        $chapo = null,
        $content = null,
        $publication_status = null,
        $creationDate = null,
        $publicationDate = null
    ) {
        parent::__construct($id);
        $this->title = $title;
        $this->author = $author;
        $this->chapo = $chapo;
        $this->content = $content;
        $this->publication_status = $publication_status;
        $this->creationDate = $creationDate;
        $this->publicationDate = $publicationDate == null ? "?" : $publicationDate;
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
    public function getChapo()
    {
        return $this->chapo;
    }

    /**
     * @param mixed $chapo
     */
    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return null
     */
    public function getPublicationStatus()
    {
        return $this->publication_status;
    }

    /**
     * @param null $publication_status
     */
    public function setPublicationStatus($publication_status)
    {
        $this->publication_status = $publication_status;
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
}
