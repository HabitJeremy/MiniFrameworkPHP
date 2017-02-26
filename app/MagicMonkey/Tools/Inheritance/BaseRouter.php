<?php

namespace MagicMonkey\Tools\Inheritance;

use MagicMonkey\Tools\HttpFoundation\Request;
use MagicMonkey\Tools\InterfaceRepository\BaseRouterInterface;

/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 24/02/2017
 * Time: 09:55
 */
abstract class BaseRouter implements BaseRouterInterface
{
    protected $controllerClassName;
    protected $controllerAction;
    protected $request;

    abstract public function parseRequest();

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->parseRequest();
    }

    public function getControllerClassName()
    {
        return $this->controllerClassName;
    }

    public function getControllerAction()
    {
        return $this->controllerAction;
    }
}
