<?php

namespace MagicMonkey\MiniJournal\RepositoryBd;

use MagicMonkey\Framework\Inheritance\AbstractBd;
use \Exception;
use MagicMonkey\MiniJournal\Entity\Article;

/**
 * Class ArticleBd
 * @package MagicMonkey\MiniJournal\RepositoryBd
 */
class ArticleBd extends AbstractBd
{
    /**
     * constante = table name pour la classe abstraite abstractBd
     */
    const TABLE_NAME = "article";

    /**
     * ArticleBD constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE_NAME);
    }

    /**
     * Permet d'instancier un objet Article
     * @param $arrayData
     * @return Article
     */
    public function mapp($arrayData)
    {
        /*$this->dataCleaning($arrayData, $insertData);*/
        return new Article(
            empty($arrayData['id']) ? null : $arrayData['id'],
            $arrayData['title'],
            $arrayData['author'],
            $arrayData['chapo'],
            $arrayData['content'],
            $arrayData['publication_status'],
            empty($arrayData['creation_date']) ? null : $arrayData['creation_date'],
            empty($arrayData['publication_date']) ? null : $arrayData['publication_date']
        );
    }

    /**
     * Modification d'un article => return false si error sinon true
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
     * Ajout d'un article => return false si error sinon true
     * @param $postedData
     * @return bool|mixed
     */
    public function add($postedData)
    {
        try {
            $postedData['creation_date'] = date("Y-m-d");
            $this->prepareSpecifics($postedData);
            return $this->saveOne($postedData);
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Manipulation spécifique des données postées (propre à Article)
     * @param $postedData
     */
    private function prepareSpecifics(&$postedData)
    {
        if ($postedData['publication_status'] == "publie") {
            $postedData['publication_date'] = date("Y-m-d");
        } else {
            $postedData['publication_date'] = null;
        }
    }
}
