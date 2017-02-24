<?php

namespace MagicMonkey\Tools\Inheritance;

use \Exception;
use MagicMonkey\Tools\Database\DbConnection;
use MagicMonkey\Tools\Database\Cleaner;
use \PDO as PDO;

/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 24/02/2017
 * Time: 10:11
 */
abstract class PersistBd
{
    protected $tableName;
    protected $dbh;
    protected $cleaner;

    abstract public function map($res, $nl2br = false);

    protected function __construct($tableName)
    {
        $this->cleaner = new Cleaner();
        $this->tableName = $tableName;
        $this->dbh = DbConnection::getInstance()->getConnexion();
    }

    public function selectAll()
    {
        try {
            $lstObjsArticle = array();
            $sql = 'SELECT * from ' . $this->tableName;
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

    /* select one */
    public function selectOne(array $conditions, $nl2br = true)
    {
        try {
            $lstPrepare = array();
            $sql = 'SELECT * from ' . $this->tableName . ' where ';
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

    /* suppression d'un article => return false si error sinon true */
    public function deleteOne($id)
    {
        $res = false;
        $article = $this->selectOne(array("id =" => (int)$id));
        if ($article) {
            $sql = 'DELETE from ' . $this->tableName . ' where id = :id';
            $stmt = $this->dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            return $stmt->execute(array(":id" => $id));
        }
        return $res;
    }
}
