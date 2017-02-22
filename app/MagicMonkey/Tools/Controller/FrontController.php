<?php

namespace MagicMonkey\Tools\Controller;

use MagicMonkey\Tools\HttpFoundation\Request;
use MagicMonkey\Tools\HttpFoundation\Response;
use MagicMonkey\MiniJournal\Router\Router;

/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 21/02/2017
 * Time: 09:28
 */
class FrontController
{
    /**
     * @var string $controllerClass le nom complet de la classe à instancier
     */
    protected $controllerClass;

    /**
     * @var string $action le nom de l'action à exécuter
     */
    protected $action;
    protected $request;
    protected $response;
    protected $router;

    /**
     * constructeur de la classe.
     *
     * Le constructeur prend en paramètre un objet Request
     * et "regarde" quel contrôleur il faut lancer et quelle action
     * il faut exécuter.
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->router = new Router($this->request);
        // reprendre ici le code de index.php
        // pour choisir la classe de contrôleur à créer
        // et mettre son nom dans $this->controllerClass
        // ... à faire ...

       /* $obj = empty($_GET["o"]) ? "article" : $_GET["o"];
        switch ($obj) {
            case "article":
                $this->controllerClass = "ArticleController";
                break;
        }*/


        // de même ensuite regarder si une action est demandée dans l'URL
        // ... à faire ...

       /* $this->action = empty($_GET["a"]) ? "home" : $_GET["a"];*/




    }

    /**
     * méthode pour lancer le contrôleur et exécuter l'action à faire
     */
    public function execute()
    {
        $className = $this->router->getControllerClassName();
        $controller = new $className($this->request, $this->response);
        $action = $this->router->getControllerAction();
        // Noter que le contrôleur a maintenant une méthode execute(). Servira par la suite pour améliorer notre code.
        $controller->execute($action);
    }
}
