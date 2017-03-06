<?php

namespace MagicMonkey\MiniJournal\RepositoryBd;

use MagicMonkey\Framework\Inheritance\AbstractBd;
use \Exception;
use MagicMonkey\MiniJournal\Entity\Image;

/**
 * Class ImageBd
 * @package MagicMonkey\MiniJournal\RepositoryBd
 */
class ImageBd extends AbstractBd
{
    /**
     * constante = table name pour la classe abstraite abstractBd
     */
    const TABLE_NAME = "image";

    /**
     * ArticleBD constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE_NAME);
    }

    /**
     * Permet d'instancier un objet Image
     * @param $arrayData
     * @return Image
     */
    public function mapp($arrayData)
    {
        return new Image(
            empty($arrayData['id']) ? null : $arrayData['id'],
            $arrayData['name'],
            empty($arrayData['path']) ? null : $arrayData['path'],
            $arrayData['attr_alt']
        );
    }

    /**
     * Modification d'une image => return false si error sinon true
     * @param $postedData
     * @param $id
     * @return bool|mixed
     */
    public function update($postedData, $id)
    {
        try {
            $postedData['id'] = $id;
            return $this->saveOne($postedData);
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Ajout d'une image => return false si error sinon true
     * @param $postedData
     * @return bool|mixed
     */
    public function add($postedData)
    {
        try {
            return $this->saveOne($postedData);
        } catch (Exception $ex) {
            return false;
        }
    }
}
