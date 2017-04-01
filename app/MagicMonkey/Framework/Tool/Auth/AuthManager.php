<?php

namespace MagicMonkey\Framework\Tool\Auth;

use MagicMonkey\Framework\HttpFoundation\Request;

class AuthManager
{
    /**
     * $instance est privée pour implémenter le pattern Singleton
     * et être sûr qu'il n'y a qu'une et une seule instance
     */
    private static $instance;
    protected $request;
    protected $userData = array();

    public function __construct(Request $request)
    {
        /*if (is_null($request)) {
            throw new AuthenticationException("Missing Request parameter");
        }*/
        $this->request = $request;
        try {
            $this->userData = $this->request->getSessionParam('user');
        } catch (\Exception $e) {
            // pas d'élément user dans la session => initialiser en tableau vide
            $this->authenticationData = array();
        }
    }

    private function __clone()
    {
    }

    /**
     * Méthode pour accéder à l'UNIQUE instance de la classe.
     *
     * @param Request $request
     * @return l'instance du singleton
     */
    public static function getInstance(Request $request = null)
    {
        if (!(self::$instance instanceof self) || null === self::$instance) {
            self::$instance = new self($request);
        }
        return self::$instance;
    }

    public function isLogged()
    {
        return !empty($this->userData);
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
        /* $this->request->getItemSession('user')['id'] = $id;
         $this->request->getItemSession('user')['login'] = $login;
         $this->request->getItemSession('user')['status'] = $status;*/
    }

    public function getUserData($key)
    {
        if ($this->isLogged()) {
            if (array_key_exists($key, $this->userData)) {
                return $this->userData[$key];
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
        $this->request->updateSessionParam('user', $this->authenticationData);
    }
}
