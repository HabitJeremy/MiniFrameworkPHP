<?php

namespace MagicMonkey\MiniJournal\RepositoryBd;

use MagicMonkey\Framework\Inheritance\AbstractBd;
use \Exception;
use MagicMonkey\MiniJournal\Entity\Image;

class ImageBd extends AbstractBd
{
    const TABLE_NAME = "image";

    /* ### CONSTRUCTOR ### */
    /**
     * ArticleBD constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE_NAME);
    }

    public function mapp($arrayData, $insertData = false)
    {
        /* $this->dataCleaning($arrayData, $insertData);*/
        return new Image(
            empty($arrayData['id']) ? null : $arrayData['id'],
            $arrayData['name'],
            empty($arrayData['path']) ? null : $arrayData['path'],
            $arrayData['attr_alt']
        );
    }

    /* modification d'une image => return false si error sinon true */
    public function update($postedData, $id)
    {
        try {
            $postedData['id'] = $id;
            return $this->saveOne($postedData);
        } catch (Exception $ex) {
            return false;
        }
    }

    /* ajout d'une image => return false si error sinon true*/
    public function add($postedData)
    {
        try {
            return $this->saveOne($postedData);
        } catch (Exception $ex) {
            return false;
        }
    }
}
