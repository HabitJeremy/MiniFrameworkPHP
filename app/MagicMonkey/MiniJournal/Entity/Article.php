<?php

namespace MagicMonkey\MiniJournal\Entity;

use MagicMonkey\Framework\Inheritance\Entity\Type\AbstractDocumentEntity;

/**
 * Class Article
 * @package MagicMonkey\MiniJournal\Entity
 */
class Article extends AbstractDocumentEntity implements \JsonSerializable
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
     * @var array|null
     */
    private $lstImages;

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
     * @param array $lstImages
     */
    public function __construct(
        $id = null,
        $title = null,
        $author = null,
        $chapo = null,
        $content = null,
        $publicationStatus = null,
        $creationDate = null,
        $publicationDate = null,
        $lstImages = null
    )
    {
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
        if ($lstImages == null) {
            $this->lstImages = array();
        } else {
            $this->lstImages = $lstImages;
        }
    }

    public function jsonSerialize()
    {
        $objectToArray = array();
        foreach (get_object_vars($this) as $key => $value) {
            $newKey = strtolower(preg_replace('/\B([A-Z])/', '_$1', $key));
            $objectToArray[$newKey] = $value;
        }
        return $objectToArray;
    }

    /**
     * @param Image $image
     */
    public function addImage(Image $image)
    {
        $this->lstImages[] = $image;
    }

    /**
     * @param Image $image
     */
    public function removeImage(Image $image)
    {
        if (in_array($image, $this->lstImages)) {
            $key = array_keys($this->lstImages, $image);
            unset($this->lstImages[$key]);
        }
    }

    /**
     * @return array|null
     */
    public function getLstImages()
    {
        return $this->lstImages;
    }

    /**
     * @param array|null $lstImages
     */
    public function setLstImages($lstImages)
    {
        $this->lstImages = $lstImages;
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
