<?php

namespace MagicMonkey\Framework\Inheritance;

use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\HttpFoundation\Response;

/**
 * Classe abstraite pour les classes "controlleur"
 * Class AbstractController
 * @package MagicMonkey\Framework\Inheritance
 */
abstract class AbstractController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Response
     */
    protected $response;

    /**
     * Constructeur
     * AbstractController constructor.
     * @param Request $request : contient les données envoyées au serveur
     * @param Response $response : contient les données de réponses pour l'affichage
     */
    protected function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request = $request;
    }

    /**
     * Permet a une classe "controlleur" d'exécuter une action passée en paramètre
     * @param $action : action à exécuter
     * @return mixed
     * @throws \Exception
     */
    protected function execute($action)
    {
        if (method_exists($this, $action)) {
            return $this->$action();
        } else {
            throw new \Exception("Action {$action} non trouvée");
        }
    }

    /**
     * Permet de stocker les données nécessaires à l'affichage
     * @param $template : le chemin de la vue à affichée
     * @param $fragments : les différentes données qui seront utilisées dans la vue
     */
    public function render($template, $fragments)
    {
        $this->response->setTemplate($template);
        $this->response->setLstFragments($fragments);
    }
}
