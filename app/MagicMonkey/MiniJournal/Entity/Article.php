<?php

namespace MagicMonkey\MiniJournal\Entity;

use MagicMonkey\Framework\Inheritance\Entity\Type\AbstractDocumentEntity;

/**
 * Class Article
 * @package MagicMonkey\MiniJournal\Entity
 */
class Article extends AbstractDocumentEntity
{
    /**
     * @var null
     */
    private $chapo;
    /**
     * @var null
     */
    private $content;

    /**
     * Article constructor.
     * @param $id
     * @param $title
     * @param $author
     * @param $chapo
     * @param $content
     * @param $publicationStatus
     * @param $creationDate
     * @param $publicationDate
     */
    public function __construct(
        $id = null,
        $title = null,
        $author = null,
        $chapo = null,
        $content = null,
        $publicationStatus = null,
        $creationDate = null,
        $publicationDate = null
    ) {
        parent::__construct(
            $id,
            $title,
            $author,
            $creationDate,
            $publicationDate,
            $publicationStatus
        );
        $this->chapo = $chapo;
        $this->content = $content;
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
}
