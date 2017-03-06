<?php

namespace MagicMonkey\Framework\Inheritance;

use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\InterfaceRepository\RouterInterface;

/**
 * Classe abstraite permettant de définir des fonctions et des attributs de base pour les classes "Router"
 * Class AbstractRouter
 * @package MagicMonkey\Framework\Inheritance
 */
abstract class AbstractRouter implements RouterInterface
{
    /**
     * @var
     */
    protected $controllerClassName;
    /**
     * @var
     */
    protected $controllerAction;
    /**
     * @var Request
     */
    protected $request;

    /**
     * @return mixed
     */
    abstract public function parseRequest();

    /**
     * Constructeur
     * AbstractRouter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->parseRequest();
    }

    /* ### GETTERS & SETTERS */

    /**
     * @return mixed
     */
    public function getControllerClassName()
    {
        return $this->controllerClassName;
    }

    /**
     * @return mixed
     */
    public function getControllerAction()
    {
        return $this->controllerAction;
    }
}
