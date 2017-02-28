<?php

namespace MagicMonkey\MiniJournal\Article;

use MagicMonkey\Framework\Inheritance\AbstractBd;
use \Exception;

class ArticleBd extends AbstractBd
{
    const TABLE_NAME = "article";

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
        if ($insertData) {
            $this->cleaner->cleaningToInsert($arrayData);
        } else {
            $this->cleaner->cleaningToDisplay($arrayData);
        }
      /*  if(!$insertData){
            $this->cleaner->cleaningToDisplay($arrayData);
        }*/
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

    /* Creation d'un objet Article */
    /*public function mapp($arrayData, $nl2br = false)
    {
        if ($nl2br) {
            $this->cleaner->cleaningToInsert($arrayData);
        } else {
            $this->cleaner->cleaningToDisplay($arrayData);
        }
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
    }*/

    /* modification d'un article => return false si error sinon true */
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

    /* ajout d'un article => return false si error sinon true*/
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

    /* Manipulation spécifique des données postées (propre à Article) */
    private function prepareSpecifics(&$postedData)
    {
        if ($postedData['publication_status'] == "publie") {
            $postedData['publication_date'] = date("Y-m-d");
        } else {
            $postedData['publication_date'] = null;
        }
    }
}
