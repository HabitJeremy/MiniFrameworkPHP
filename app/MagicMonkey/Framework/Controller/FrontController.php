<?php

namespace MagicMonkey\Framework\Controller;

use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\HttpFoundation\Response;
use MagicMonkey\Framework\Tool\Auth\AuthManager;
use MagicMonkey\MiniJournal\Router;
use MagicMonkey\Framework\Inheritance\AbstractController;

/**
 * Controlleur principal qui instancie la classe controlleur nécessaire selon les informations du router
 * Class FrontController
 * @package MagicMonkey\Framework\Controller
 */
class FrontController extends AbstractController
{
    /**
     * @var string $controllerClass le nom complet de la classe à instancier
     */
    protected $controllerClass;

    /* protected $authManager;*/

    /**
     * @var string $action le nom de l'action à exécuter
     */
    protected $action;
    /**
     * @var Router
     */
    protected $router;

    /**
     * constructeur de la classe.
     *
     * Le constructeur prend en paramètre un objet Request
     * et "regarde" quel contrôleur il faut lancer et quelle action
     * il faut exécuter.
     *
     * FrontController constructor.
     * @param Request $request
     * @param Response $response
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
        try {
            $authManager = AuthManager::getInstance($this->request);
            try {
                $login = $this->request->getPostParam("loginConnection");
                $password = $this->request->getPostParam("passwordConnection");
            } catch (\Exception $e) {
                $login = null;
            }
            if ($login !== null && !$authManager->isLogged()) {
                // l'utilisateur essaye de se connecter
                // 1) vérification en bdd
                $authManager->checkAuthentication($login, $password);
                if (!$authManager->isLogged()) { // echec de la connexion
                    // notification flash
                    $_SESSION['error'] = "Identifiant et/ou mot de passe incorrect";
                }
                $this->request->removePostParam('loginConnection');
                $this->request->removePostParam('passwordConnection');
            }

            $className = $this->router->getControllerClassName();
            $controller = new $className($this->request, $this->response);
            $action = $this->router->getControllerAction();
            $controller->execute($action);
        } /*catch (AuthentificationException $e) {*/
        catch (\Exception $e) {
            // => afficher un message d'erreur
            /* $this->response->setPart('titre', "Erreur");
             $this->response->setPart('contenu', "Erreur de connexion");*/
        }
    }
}
