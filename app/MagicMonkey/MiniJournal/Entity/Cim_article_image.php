<?php

namespace MagicMonkey\MiniJournal\Entity;

    /**
     * Class Cim_article_image
     * @package MagicMonkey\MiniJournal\Entity
     */
/**
 * Class Cim_article_image
 * @package MagicMonkey\MiniJournal\Entity
 */
class Cim_article_image
{
    /**
     * @var
     */
    private $idArticle;

    /**
     * @var
     */
    private $idImage;

    /**
     * @var
     */
    private $order;

    /**
     * @var
     */
    private $main;

    /**
     * Cim_article_image constructor.
     * @param $idArticle
     * @param $idImage
     * @param $order
     * @param $main
     */
    public function __construct($idArticle, $idImage, $order, $main)
    {
        $this->idArticle = $idArticle;
        $this->idImage = $idImage;
        $this->order = $order;
        $this->main = $main;
    }

    /**
     * @return mixed
     */
    public function getIdArticle()
    {
        return $this->idArticle;
    }

    /**
     * @param mixed $idArticle
     */
    public function setIdArticle($idArticle)
    {
        $this->idArticle = $idArticle;
    }

    /**
     * @return mixed
     */
    public function getIdImage()
    {
        return $this->idImage;
    }

    /**
     * @param mixed $idImage
     */
    public function setIdImage($idImage)
    {
        $this->idImage = $idImage;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * @param mixed $main
     */
    public function setMain($main)
    {
        $this->main = $main;
    }

}