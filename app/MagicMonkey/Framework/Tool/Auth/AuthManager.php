<?php

namespace MagicMonkey\Framework\Tool\Auth;

use MagicMonkey\Framework\HttpFoundation\Request;

class AuthManager
{
    /**
     * $instance est privée pour implémenter le pattern Singleton
     * et être sûr qu'il n'y a qu'une et une seule instance
     */
    private static $instance = null;
    protected $request;
    protected $userData = array();
    protected $userBdClass;

    private function __construct(Request $request)
    {
        /*if (is_null($request)) {
            throw new AuthenticationException("Missing Request parameter");
        }*/
        $this->request = $request;
        $this->userBdClass = REPOSITORY_BD_USER;
        try {
            $this->userData = $this->request->getSessionParam('user');
        } catch (\Exception $e) {
            // pas d'élément user dans la session => initialiser en tableau vide
            $this->userData = array();
        }
    }

    private function __clone()
    {
    }


    public static function getInstance(Request $request = null)
    {
        if (null === self::$instance) {
            self::$instance = new self($request);
        }
        return self::$instance;
    }

    public function isLogged()
    {
        return empty($this->userData) ? false : true;
    }

    /**
     * Méthode : verifierAuthentification
     * Vérifie si le couple (login, pwd) est correct
     * Si oui, remplit le tableau $this->authenticationData et
     * l'enregistre dans la session (méthode synchronize())
     * Sinon, envoie une exception de type Exception_Auth
     *
     * @param $login
     * @param $password
     */
    public function checkAuthentication($login, $password)
    {


        $user = (new $this->userBdClass())->selectOne(array(
            "login =" => $login,
            "password =" => hash('sha256', $password)
        ));
        if ($user) { // le couple (login, pwd) est correct
            // remplissage de $this->userData
            $this->userData['id'] = $user->getId();
            $this->userData['name'] = $user->getName();
            $this->userData['first_name'] = $user->getFirstName();
            $this->userData['roles'] = $user->getRoles();
            $this->userData['login'] = $user->getLogin();
            // synchronisation
            $this->synchronize();
        } else {
            /* throw new AuthenticationException("user incconnu");*/
        }
    }

    public function getUserData($key = null)
    {
        if ($this->isLogged()) {
            if ($key != null) {
                if (array_key_exists($key, $this->userData)) {
                    return $this->userData[$key];
                }
            } else {
                return $this->userData;
            }
        }
        return null;
    }

    /**
     * logout : vider les infos de session et synchronize
     */
    public function logout()
    {
        $this->userData = array();
        $this->synchronize();
    }

    /**
     * Synchronisation des infos de $this->userData avec la session
     * Méthode à changer si on utilise un autre système pour conserver les infos
     */
    private function synchronize()
    {
        $this->request->updateSessionParam('user', $this->userData);
        $_SESSION['user'] = $this->userData;
    }
}
