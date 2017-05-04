<?php

namespace MagicMonkey\MiniJournal\RepositoryBd;

use Exception;
use MagicMonkey\Framework\RepositoryBd\UserBd as DefaultUserBd;

/**
 * Class UserBd
 * @package MagicMonkey\MiniJournal\RepositoryBd
 */
class UserBd extends DefaultUserBd
{

    /**
     * Ajout d'un utilisateur => return false si error sinon true
     * @param $postedData
     * @return bool|mixed
     */
    public function add($postedData)
    {
        try {
            $postedData['password'] = hash('sha256', $postedData['password']);
            $postedData['roles'] = json_encode(array('0' => 'ROLE_EDITOR'));
            return $this->saveOne($postedData);
        } catch (Exception $ex) {
            return false;
        }
    }
}
