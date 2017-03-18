<?php

namespace MagicMonkey\MiniJournal\RepositoryBd;

use MagicMonkey\Framework\Inheritance\AbstractBd;
use \Exception as Exception;
use MagicMonkey\MiniJournal\Entity\Article;
use MagicMonkey\MiniJournal\Entity\Image;
use \PDO as PDO;

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
            $lstImages = $this->prepareSpecifics($postedData);
            $lastInsertId = $this->saveOne($postedData);
            $this->saveArticleImageRelations($lstImages, $lastInsertId);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }


    /**
     * @param $lstImages
     * @param $articleId
     */
    private function saveArticleImageRelations($lstImages, $articleId)
    {
        try {
            foreach ($lstImages as $imageId) {
                $sql = "INSERT INTO cim_article_image (idArticle, idImage) VALUES (:articleId, :imageId)";
                $stmt = $this->dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->execute(array(":articleId" => (int)$articleId, ":imageId" => (int)$imageId));
            }
            return true;
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
        $lstImages = $postedData['imageCheckboxes'] ? $postedData['imageCheckboxes'] : array();
        unset($postedData["imageCheckboxes"]);
        return $lstImages;
    }

    /**
     * @param $id
     * @return bool
     */
    public function eagerSelectOne($id)
    {
        try {
            $article = $this->selectOne(array("id =" => $id));
            $sql = 'SELECT i.* from cim_article_image as cim, image as i';
            $sql .= ' where cim.idArticle = :id and i.id = cim.idImage order by cim.num';
            $stmt = $this->dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute(array(":id" => $id));
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($res) {
                foreach ($res as $row) {
                    $newImage = new Image($row['id'], $row['name'], $row['path'], $row['attr_alt']);
                    $article->addImage($newImage);
                }
            }
            return $article;
        } catch (Exception $ex) {
            return false;
        }
    }
}
