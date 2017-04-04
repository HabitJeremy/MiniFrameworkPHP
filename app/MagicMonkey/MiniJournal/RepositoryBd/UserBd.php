<?php

namespace MagicMonkey\MiniJournal\RepositoryBd;

use MagicMonkey\Framework\Inheritance\AbstractBd;
use \Exception as Exception;
use MagicMonkey\MiniJournal\Entity\User;

/**
 * Class UserBd
 * @package MagicMonkey\MiniJournal\RepositoryBd
 */
class UserBd extends AbstractBd
{
    /**
     * constante = table name pour la classe abstraite abstractBd
     */
    const TABLE_NAME = "user";

    /**
     * UserBd constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE_NAME);
    }

    /**
     * Permet d'instancier un objet User
     * @param $arrayData
     * @return User
     */
    public function mapp($arrayData)
    {
        $user = new User(
            empty($arrayData['id']) ? null : $arrayData['id'],
            $arrayData['login'],
            hash('sha256', $arrayData['password']),
            $arrayData['mail'],
            $arrayData['name'],
            $arrayData['first_name'],
            $arrayData['birthday_date'],
            $arrayData['gender']
        );
        return $user;
    }

    /**
     * Ajout d'un utilisateur => return false si error sinon true
     * @param $postedData
     * @return bool|mixed
     */
    public function add($postedData)
    {
        try {
            $postedData['password'] = hash('sha256', $postedData['password']);
            return $this->saveOne($postedData);
        } catch (Exception $ex) {
            return false;
        }
    }

    public function update($postedData, $id)
    {
        // TODO: Implement update() method.
    }
}
