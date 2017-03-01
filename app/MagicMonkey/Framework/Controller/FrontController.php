<?php

namespace MagicMonkey\Framework\Controller;

use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\HttpFoundation\Response;
use MagicMonkey\MiniJournal\Router;
use MagicMonkey\Framework\Inheritance\AbstractController;

class FrontController extends AbstractController
{
    /**
     * @var string $controllerClass le nom complet de la classe à instancier
     */
    protected $controllerClass;

    /**
     * @var string $action le nom de l'action à exécuter
     */
    protected $action;
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
        parent::__construct($request, $response);
        $this->router = new Router($this->request);
    }

    /**
     * méthode pour lancer le contrôleur et exécuter l'action à faire
     */
    public function main()
    {
        $className = $this->router->getControllerClassName();
        $controller = new $className($this->request, $this->response);
        $action = $this->router->getControllerAction();
        $controller->execute($action);
    }
}
