<?php

namespace MagicMonkey\Framework\Inheritance;

use \Exception;
use MagicMonkey\Framework\Database\DbConnection;
use MagicMonkey\Framework\Database\Cleaner;
use \PDO as PDO;

/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 24/02/2017
 * Time: 10:11
 */
abstract class AbstractBd
{
    protected $tableName;
    protected $dbh;
    protected $cleaner;

    abstract public function add($postedData);

    abstract public function update($postedData, $id);

    protected function __construct($tableName)
    {
        $this->cleaner = new Cleaner();
        $this->tableName = $tableName;
        $this->dbh = DbConnection::getInstance()->getConnexion();
    }

    /* Lire plusieurs enregistrements */
    public function selectAll()
    {
        try {
            $lstObjsArticle = array();
            $sql = 'SELECT * from ' . $this->tableName;
            $stmt = $this->dbh->query($sql);
            if ($res = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                foreach ($res as $row) {
                    array_push($lstObjsArticle, $this->mapp($row, true));
                }
                return $lstObjsArticle;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    /* Lire un enregistrement */
    public function selectOne(array $conditions, $nl2br = true)
    {
        try {
            $lstPrepare = array();
            $sql = 'SELECT * from ' . $this->tableName . ' where ';
            foreach ($conditions as $columnOperator => $value) {
                $uniqNb = uniqid(rand()) . uniqid();
                $sql .= $columnOperator . " :p" . $uniqNb . " ";
                $lstPrepare[":p" . $uniqNb] = $value;
            }
            $stmt = $this->dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute($lstPrepare);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($res) {
               return $this->mapp($res, $nl2br);
            } else {
                return $res;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    /* Supprimer d'un enregistrement => return false en cas d'erreurs sinon true */
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

    /* Ajouter/éditer un enregistrement */
    public function saveOne($array)
    {
        $sql_value = "";
        $idisPresent = null;
        if (!array_key_exists('id', $array)) {
            $sql_begin = "INSERT INTO {$this->tableName}(";
            $idisPresent = false;
        } else {
            $sql_begin = "UPDATE {$this->tableName} SET ";
            $idisPresent = true;
        }
        $p = array();
        foreach ($array as $key => $value) {
            end($array);
            $p[':' . $key] = $value;
            if (!$idisPresent) { //s create
                if ($key === key($array)) {
                    $sql_begin .= $key . ") VALUES (";
                    $sql_value .= ':' . $key . ")";
                } else {
                    $sql_begin .= $key . ',';
                    $sql_value .= ':' . $key . ',';
                }
            } else { // update
                if ($key === key($array)) {
                    $sql_begin .= $key . '= :' . $key . ' where id =' . $array['id'];
                } else {
                    $sql_begin .= $key . '= :' . $key . ',';
                }
            }
        }
        $sql = $sql_begin . $sql_value;
        $stmt = $this->dbh->prepare($sql);
        return $stmt->execute($p);
    }

    public function mapp2($arrayData, $nl2br = false)
    {
        $this->dataCleaning($arrayData, $nl2br);
        return $this->dataMapping($arrayData);
    }

    private function dataMapping($arrayData)
    {
        $arrayData['id'] = empty($arrayData['id']) ? null : $arrayData['id'];
        $class = 'MagicMonkey\\MiniJournal\\Article\\' . ucfirst($this->tableName);
        /* @@@@ PB => namespace obligatoire ??? */
        $newInstance = new $class();

        $attrs = $newInstance->getAttr();
        /* @@@@ PB => protected obigatoire */

        foreach ($attrs as $attr => $value) {
            $fieldParts = preg_split('/(?=[A-Z])/', $attr, -1, PREG_SPLIT_NO_EMPTY);
            $attrSQL = "";
            for ($i = 0; $i < count($fieldParts); $i++) {
                if ($this->startsWithUpper($fieldParts[$i])) {
                    $fieldParts[$i] = "_" . strtolower($fieldParts[$i]);
                }
                $attrSQL .= $fieldParts[$i];
            }
            $setterName = "set" . ucfirst($attr);
            if (!empty($arrayData[$attrSQL])) {
                $newInstance->$setterName($arrayData[$attrSQL]);
            }
        }

        return $newInstance;
    }

    /* Nettoyer les données avant insertion ou avant affichage */
    private function dataCleaning(&$arrayData, $nl2br)
    {
        if ($nl2br) {
            $this->cleaner->cleaningToInsert($arrayData);
        } else {
            $this->cleaner->cleaningToDisplay($arrayData);
        }
    }

    private function startsWithUpper($str)
    {
        $chr = mb_substr($str, 0, 1, "UTF-8");
        return mb_strtolower($chr, "UTF-8") != $chr;
    }
}
