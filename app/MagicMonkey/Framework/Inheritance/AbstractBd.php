<?php

namespace MagicMonkey\Framework\Inheritance;

use \Exception;
use MagicMonkey\Framework\Tool\Database\DbConnection;
use \PDO as PDO;

/***
 * Classe abstraite permettant de définir des attributs et des functions de base pour les classe gérent les relations
 * avec la BD
 * Class AbstractBd
 * @package MagicMonkey\Framework\Inheritance
 */
abstract class AbstractBd
{
    /**
     * @var
     */
    protected $tableName;

    /**
     * @var
     */
    protected $dbh;

    /* ### functions obligatoires pour les classes filles de celle-ci  */

    /**
     * @param $postedData
     * @return mixed
     */
    abstract public function mapp($postedData);

    /**
     * @param $postedData
     * @return mixed
     */
    abstract public function add($postedData);

    /**
     * @param $postedData
     * @param $id
     * @return mixed
     */
    abstract public function update($postedData, $id);

    /**
     * Constructeur
     * AbstractBd constructor.
     * @param $tableName
     */
    protected function __construct($tableName)
    {
        $this->tableName = $tableName;
        $this->dbh = DbConnection::getInstance()->getConnexion();
    }

    /**
     * Permet de lire plusieurs enregistrements
     * @return array|bool
     */
    public function selectAll()
    {
        try {
            $lstObjsArticle = array();
            $sql = 'SELECT * from ' . $this->tableName;
            $stmt = $this->dbh->query($sql);
            if ($res = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                foreach ($res as $row) {
                    array_push($lstObjsArticle, $this->mapp($row));
                }
                return $lstObjsArticle;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    public function selectAllBy(array $conditions)
    {
        try {
            $lstPrepare = array();
            $lstObjsArticle = array();
            $sql = 'SELECT * from ' . $this->tableName . ' where ';
            $where = false;
            foreach ($conditions as $columnOperator => $value) {
                if ($where) {
                    $sql .= "and ";
                }
                $uniqNb = uniqid(rand()) . uniqid();
                $sql .= $columnOperator . " :p" . $uniqNb . " ";
                $lstPrepare[":p" . $uniqNb] = $value;
                $where = true;
            }
            $stmt = $this->dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute($lstPrepare);
            if ($res = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                foreach ($res as $row) {
                    array_push($lstObjsArticle, $this->mapp($row));
                }
                return $lstObjsArticle;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }
    }


    /**
     *  Permet de lire un enregistrement
     * @param array $conditions
     * @return bool|mixed
     */
    public function selectOne(array $conditions)
    {
        try {
            $lstPrepare = array();
            $sql = 'SELECT * from ' . $this->tableName . ' where ';
            $where = false;
            foreach ($conditions as $columnOperator => $value) {
                if ($where) {
                    $sql .= "and ";
                }
                $uniqNb = uniqid(rand()) . uniqid();
                $sql .= $columnOperator . " :p" . $uniqNb . " ";
                $lstPrepare[":p" . $uniqNb] = $value;
                $where = true;
            }
            $stmt = $this->dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute($lstPrepare);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($res) {
                return $this->mapp($res);
            } else {
                return $res;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Permet de upprimer d'un enregistrement => return false en cas d'erreurs sinon true
     * @param $id : identifiant de l'objet
     * @return bool
     */
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

    /**
     * Permet d'ajouter/éditer un enregistrement
     * @param $array : données postées
     * @return mixed
     */
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
        $stmt->execute($p);
        return $this->dbh->lastInsertId();
    }
}
