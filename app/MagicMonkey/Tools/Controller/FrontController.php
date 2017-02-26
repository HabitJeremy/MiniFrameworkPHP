<?php

namespace MagicMonkey\Tools\Controller;

use MagicMonkey\Tools\HttpFoundation\Request;
use MagicMonkey\Tools\HttpFoundation\Response;
use MagicMonkey\MiniJournal\Article\ArticleRouter;
use MagicMonkey\Tools\Inheritance\BaseController;

/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 21/02/2017
 * Time: 09:28
 */
class FrontController extends BaseController
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
        $this->router = new ArticleRouter($this->request);
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
