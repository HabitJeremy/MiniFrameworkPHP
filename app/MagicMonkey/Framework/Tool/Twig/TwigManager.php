<?php

namespace MagicMonkey\Framework\Tool\Twig;

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
     * @param $authManager
     */
    public function __construct($userSession)
    {
        $this->twig = $this->initialization();
        $this->globalsInitialization($userSession);
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
        $this->twig->addGlobal('sessionUser', $sessionUser );
    }

    /**
     * Initiaisation des fonctions personnalisée de twig
     */
    public function functionsInitalization()
    {
        $getCurrentUrl = new Twig_SimpleFunction('getCurrentUrl', function () {
            return $_SERVER['REQUEST_URI'];
        });
        $this->twig->addFunction($getCurrentUrl);
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
