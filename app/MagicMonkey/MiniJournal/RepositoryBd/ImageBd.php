<?php

namespace MagicMonkey\MiniJournal\RepositoryBd;

use MagicMonkey\Framework\Inheritance\AbstractBd;
use \Exception;
use MagicMonkey\Framework\Tool\Auth\AuthManager;
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
            $arrayData['attr_alt'],
            empty($arrayData['author']) ? null : $arrayData['author'],
            $arrayData['publication_status'],
            empty($arrayData['creation_date']) ? null : $arrayData['creation_date'],
            empty($arrayData['publication_date']) ? null : $arrayData['publication_date']
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
            $this->prepareSpecifics($postedData);
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
            $this->prepareSpecifics($postedData);
            return $this->saveOne($postedData);
        } catch (Exception $ex) {
            return false;
        }
    }


    private function prepareSpecifics(&$postedData)
    {
        $postedData['author'] = AuthManager::getInstance()->getUserData("login");
        $postedData['creation_date'] = date("Y-m-d");
        if ($postedData['publication_status'] == "publie") {
            $postedData['publication_date'] = date("Y-m-d");
        } else {
            $postedData['publication_date'] = null;
        }
        return true;
    }
}
