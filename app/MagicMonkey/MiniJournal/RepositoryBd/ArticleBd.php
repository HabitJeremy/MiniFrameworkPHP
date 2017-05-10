<?php

namespace MagicMonkey\MiniJournal\RepositoryBd;

use MagicMonkey\Framework\Inheritance\AbstractBd;
use \Exception as Exception;
use MagicMonkey\Framework\Tool\Auth\AuthManager;
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
        $article = new Article(
            empty($arrayData['id']) ? null : $arrayData['id'],
            $arrayData['title'],
            $arrayData['author'],
            $arrayData['chapo'],
            $arrayData['content'],
            $arrayData['publication_status'],
            empty($arrayData['creation_date']) ? null : $arrayData['creation_date'],
            empty($arrayData['publication_date']) ? null : $arrayData['publication_date']
        );
        if (isset($arrayData['imageCheckboxes']) && count($arrayData['imageCheckboxes']) > 0) {
            foreach ($arrayData['imageCheckboxes'] as $imageId) {
                $image = (new ImageBd())->selectOne(array("id =" => (int)$imageId));
                if ($image) {
                    $article->addImage($image);
                }
            }
        }
        return $article;
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
            $lstImages = $this->prepareSpecifics($postedData);
            $this->saveOne($postedData);
            $this->saveArticleImageRelations($lstImages, $id);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function updatePublicationStatus($article)
    {
        $sql = 'UPDATE ';
        $sql .= self::TABLE_NAME . ' SET publication_status = :status, publication_date = :date WHERE id= :id';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(
            ":status" => $article->getPublicationStatus(),
            ":date" => $article->getPublicationDate(),
            ":id" => $article->getId()
        ));
        return true;
    }

    /**
     * Ajout d'un article => return false si error sinon true
     * @param $postedData
     * @return bool|mixed
     */
    public function add($postedData)
    {
        try {
            $postedData['author'] = AuthManager::getInstance()->getUserData("login");
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
     * @param array $lstImages
     * @param $articleId
     * @return bool
     */
    private function saveArticleImageRelations(array $lstImages, $articleId)
    {
        try {
            $article = $this->eagerSelectOne($articleId);
            if (count($article->getLstImages()) > 0) {
                foreach ($article->getLstImages() as $image) {
                    $sql = 'DELETE from cim_article_image where idArticle = :idArticle and idImage = :idImage';
                    $stmt = $this->dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                    $stmt->execute(array(":idArticle" => $articleId, ":idImage" => $image->getId()));
                }
            }
            foreach ($lstImages as $key => $imageId) {
                $sql = "INSERT INTO cim_article_image (idArticle, idImage, num) VALUES (:articleId, :imageId, :num)";
                $stmt = $this->dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->execute(array(":articleId" => (int)$articleId, ":imageId" => (int)$imageId, ":num" => $key));
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @param $postedData
     * @return array
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

            /* a fonctionner */
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
            /* end : a fonctionner */
            return $article;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @return array|bool
     */
    public function eagerSelectAll()
    {
        try {
            $articles = $this->selectAll();
            foreach ($articles as $article) {
                /* a fonctionner */
                $sql = 'SELECT i.* from cim_article_image as cim, image as i';
                $sql .= ' where cim.idArticle = :id and i.id = cim.idImage order by cim.num';
                $stmt = $this->dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->execute(array(":id" => $article->getId()));
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($res) {
                    foreach ($res as $row) {
                        $newImage = new Image($row['id'], $row['name'], $row['path'], $row['attr_alt']);
                        $article->addImage($newImage);
                    }
                }
                /* end : a fonctionner */
            }
            return $articles;
        } catch (Exception $ex) {
            return false;
        }
    }
}
