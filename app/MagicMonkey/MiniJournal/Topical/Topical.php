<?php

namespace MagicMonkey\MiniJournal\Topical;

use MagicMonkey\Tools\Inheritance\Entity\Type\DocumentEntity;

class Topical extends DocumentEntity
{
    private $content;

    /**
     * Article constructor.
     * @param $id
     * @param $title
     * @param $author
     * @param $content
     * @param $publicationStatus
     * @param $creationDate
     * @param $publicationDate
     */
    public function __construct(
        $id = null,
        $title = null,
        $author = null,
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
        $this->content = $content;
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
