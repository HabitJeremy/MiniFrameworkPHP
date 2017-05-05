<?php

namespace MagicMonkey\Framework\Role;


use MagicMonkey\Framework\Tool\Auth\AuthManager;

/**
 * Class RoleManager
 * @package MagicMonkey\Framework\Role
 */
class RoleManager
{
    /**
     * $instance est privée pour implémenter le pattern Singleton
     * et être sûr qu'il n'y a qu'une et une seule instance
     */
    private static $instance;

    /**
     * Méthode pour accéder à l'UNIQUE instance de la classe.
     *
     * @return RoleManager
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Retourne true ou false si l'utilisateur détient au moins un des rôles passés en paramètre
     * @param array $roles
     * @return bool
     */
    public function isAuth(array $roles = array("ROLE_ADMIN"))
    {
        $authManager = AuthManager::getInstance();
        $userRoles = $authManager->getUserData("roles");
        if (!empty($userRoles)) {
            foreach ($roles as $role) {
                if (in_array($role, $userRoles)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Permet de renvoyer une vue par défaut lorsque l'utilisateur n'a pas accès à certaines fonctionalités
     * @param $ctrl
     * @param array $roles
     * @return bool
     */
    public function renderAccessDenied($ctrl, array $roles = array("ROLE_ADMIN"))
    {
        if (!$this->isAuth($roles)) {
            // render acces denied view
            if (method_exists($ctrl, "render")) {
                $ctrl->render("view/vAccessDenied.html.twig");
            }
            return false;
        }
        return true;
    }

    /* Propre au mini-journal malheureusement ... */

    /* Retourne true ou false si l'utilisateur connecté est l'auteur de l'article ou de l'image passé en paramètre */
    public function isAuthor($document)
    {
        $authManager = AuthManager::getInstance();
        if ($authManager->isLogged()) {
            if (($authManager->getUserData("login") == $document->getAuthor()) || $this->isAuth()) {
                return true;
            }
        }
        return false;
    }

    /* Retourne true ou false + set une view twig author denied */
    public function renderAuthorDenied($ctrl, $document)
    {
        if (!$this->isAuthor($document)) {
            // render acces denied view
            if (method_exists($ctrl, "render")) {
                $ctrl->render("article/vAuthorDenied.html.twig");
            }
            return false;
        }
        return true;
    }

}
