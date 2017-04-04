<?php

namespace MagicMonkey\Framework\Controller;

use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\HttpFoundation\Response;
use MagicMonkey\Framework\Inheritance\AbstractController;
use MagicMonkey\Framework\Tool\Auth\AuthManager;

/**
 * Class AuthController
 * @package MagicMonkey\Framework\Controller
 */
class AuthController extends AbstractController
{
    /**
     * @var AuthManager|null
     */
    private $authManager;

    /**
     * AuthController constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
        $this->authManager = AuthManager::getInstance($this->request);
    }

    /**
     * Permet la déconnexion , redirection vers l'accueil
     */
    public function logout()
    {
        $this->authManager->logout();
        header('Location: index.php');
        exit();
    }
}
