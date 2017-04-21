<?php

namespace MagicMonkey\Framework\RepositoryBd;

use MagicMonkey\Framework\Inheritance\AbstractBd;

/**
 * Class UserBd
 * @package MagicMonkey\Framework\RepositoryBd
 */
class UserBd extends AbstractBd
{
    /**
     * constante = table name pour la classe abstraite abstractBd
     */
    const TABLE_NAME = "user";

    protected $classUser;

    /**
     * UserBd constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE_NAME);
        $this->classUser = ENTITY_USER;
    }


    /* Permet d'instancier un objet User*/
    public function mapp($arrayData)
    {
        $user = new $this->classUser(
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

    public function update($postedData, $id)
    {
        // TODO: Implement update() method.
    }

    public function add($postedData)
    {
        // TODO: Implement add() method.
    }

    /**
     * @return string
     */
    public function getClassUser()
    {
        return $this->classUser;
    }
}
