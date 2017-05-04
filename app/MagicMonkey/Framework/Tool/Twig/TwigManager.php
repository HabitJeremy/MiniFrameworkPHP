<?php

namespace MagicMonkey\Framework\Tool\Twig;

use MagicMonkey\Framework\Role\RoleManager;
use MagicMonkey\Framework\Tool\Auth\AuthManager;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;
use Twig_SimpleFunction;

/**
 * Initialisation du moteur de template twig, de ses variables globales et de ses fonctions personnalisées
 * Class TwigManager
 * @package MagicMonkey\Framework\Tool\Twig
 */
class TwigManager
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * TwigManager constructor.
     */
    /*public function __construct($userSession)*/
    public function __construct()
    {
        $this->twig = $this->initialization();
        //$this->globalsInitialization($userSession);
        $this->functionsInitalization();
    }

    /**
     * @return Twig_Environment
     */
    public function initialization()
    {
        // twig devra chercher les vues à l'intérieur de ces deux dossiers
        $loader = new Twig_Loader_Filesystem(
            array(
                "ui/layout",
                "ui" . DS . "view",
                APP_BASEFILE . DS . APP_OWNER . DS . FRAMEWORK_DIR . DS . "ui")
        );
        $twig = new Twig_Environment($loader, array(
            "cache" => false,
            "debug" => true
        ));
        $twig->addExtension(new Twig_Extension_Debug());
        return $twig;
    }


    public function globalsInitialization($sessionUser)
    {
        $this->twig->addGlobal('sessionUser', $sessionUser);
    }

    /**
     * Initiaisation des fonctions personnalisée de twig
     */
    public function functionsInitalization()
    {
        /* permet de récupérer l'url courante */
        $getCurrentUrl = new Twig_SimpleFunction('getCurrentUrl', function () {
            return $_SERVER['REQUEST_URI'];
        });
        $this->twig->addFunction($getCurrentUrl);

        /* function pour tester si un utilisateur est connecté et récupérer ainsi ses données */
        $isLoggedUser = new Twig_SimpleFunction('isLoggedUser', function () {
            $authManager = AuthManager::getInstance();
            return $authManager->isLogged();
        });
        $this->twig->addFunction($isLoggedUser);

        /* permet de déterminer si un utilisateur à accès à certaines fonctionnaliées (du point de vue affichage)*/
        $isGranted = new Twig_SimpleFunction('isGranted', function (array $roles) {
            $roleManager = RoleManager::getInstance();
            return $roleManager->isAuth($roles);
        });
        $this->twig->addFunction($isGranted);


        /*  Propoe au mini-journal malheureusement ... */

        $isAuthor = new Twig_SimpleFunction('isAuthor', function ($articleAuthor) {
            $authmanager = AuthManager::getInstance();
            if ($authmanager->isLogged()) {
                if ($authmanager->getUserData("login") == $articleAuthor) {
                    return true;
                }
            }
            return false;
        });
        $this->twig->addFunction($isAuthor);

    }

    /* ###  GETTERS & SETTERS ### */

    /**
     * @return Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * @param Twig_Environment $twig
     */
    public function setTwig($twig)
    {
        $this->twig = $twig;
    }
}
