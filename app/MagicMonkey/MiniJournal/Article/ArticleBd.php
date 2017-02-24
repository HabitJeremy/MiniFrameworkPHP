<?php

namespace MagicMonkey\MiniJournal\Article;

use MagicMonkey\Tools\Inheritance\PersistBd;
use \Exception;
use \PDO as PDO;

class ArticleBd extends PersistBd
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

    /* Creation d'un objet Article */
    public function map($res, $nl2br = false)
    {
        if ($nl2br) {
            $this->cleaner->cleaningToInsert($res);
        } else {
            $this->cleaner->cleaningToDisplay($res);
        }
        return new Article(
            empty($res['id']) ? null : $res['id'],
            $res['title'],
            $res['author'],
            $res['chapo'],
            $res['content'],
            $res['publication_status'],
            empty($res['creation_date']) ? null : $res['creation_date'],
            empty($res['publication_date']) ? null : $res['publication_date']
        );
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
}
