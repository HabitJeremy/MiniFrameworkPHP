<?php

namespace MagicMonkey\MiniJournal\Article;

use \Exception;
use \PDO as PDO;
use MagicMonkey\Tools\Database\DbConnection;
use MagicMonkey\Tools\Database\Cleaner;

class ArticleBd
{
    const TABLE_NAME = "article";

    private $dbh;
    private $cleaner;

    /* ### CONSTRUCTOR ### */
    /**
     * ArticleBD constructor.
     */
    public function __construct()
    {
        $this->dbh = DbConnection::getInstance()->getConnexion();
        $this->cleaner = new Cleaner();
    }

    /* ### SQL FUNCTIONS ### */

    /* select one */
    public function selectOne(array $conditions, $nl2br = true)
    {
        try {
            $lstPrepare = array();
            $sql = 'SELECT * from ' . self::TABLE_NAME . ' where ';
            $i = 0;
            foreach ($conditions as $columnOperator => $value) {
                if ($i == 0) {
                    $sql .= $columnOperator . " :p" . $i;
                } else {
                    $sql .= " and " . $columnOperator . " :p" . $i;
                }
                $lstPrepare[":p" . $i] = $value;
            }
            $stmt = $this->dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute($lstPrepare);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($res) {
                return $this->map($res, $nl2br);
            } else {
                return $res;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    /* select all */
    public function selectAll()
    {
        try {
            $lstObjsArticle = array();
            $sql = 'SELECT * from ' . self::TABLE_NAME;
            $stmt = $this->dbh->query($sql);
            if ($res = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                foreach ($res as $row) {
                    array_push($lstObjsArticle, $this->map($row, true));
                }
                return $lstObjsArticle;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    /* suppression d'un article => return false si error sinon true */
    public function deleteOne($id)
    {
        $res = false;
        $article = $this->selectOne(array("id =" => (int)$id));
        if ($article) {
            $sql = 'DELETE from ' . self::TABLE_NAME . ' where id = :id';
            $stmt = $this->dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            return $stmt->execute(array(":id" => $id));
        }
        return $res;
    }

    /* modification d'un article => return false si error sinon true */
    public function updateOne($postedData, $id)
    {
        try {
            $postedData['id'] = $id;
            $sql = 'UPDATE ' . self::TABLE_NAME;
            $sql .= ' SET title = :title, author = :author, content = :content,';
            $sql .= ' publication_status = :publication_status,';
            $sql .= ' chapo = :chapo where id = :id';
            $stmt = $this->dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            return $stmt->execute($postedData);
        } catch (Exception $ex) {
            return false;
        }
    }

    /* ajout d'un article => return false si error sinon true*/
    public function addOne($postedData)
    {
        try {
            $postedData['creation_date'] = date("Y-m-d");
            if ($postedData['publication_status'] == "publie") {
                $postedData['publication_date'] = date("Y-m-d");
            } else {
                $postedData['publication_date'] = null;
            }
            $sql = 'INSERT INTO ' . self::TABLE_NAME;
            $sql .= ' (author, title, chapo, content, publication_status, creation_date, publication_date)';
            $sql .= ' VALUES ';
            $sql .= '(:author, :title, :chapo, :content, :publication_status, :creation_date, :publication_date)';
            $stmt = $this->dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            return $stmt->execute($postedData);
        } catch (Exception $ex) {
            return false;
        }
    }

    /* Creation d'un objet Article */
    public function map($res, $nl2br = false)
    {
        if ($nl2br) {
            $this->cleaner->cleanerArray($res);
        }
        return new Article($res['id'], $res['title'], $res['author'], $res['chapo'], $res['content'],
            $res['publication_status'], $res['creation_date'], $res['publication_date']);
    }
}
