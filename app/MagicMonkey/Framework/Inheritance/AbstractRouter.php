<?php

namespace MagicMonkey\Framework\Inheritance;

use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\InterfaceRepository\RouterInterface;

/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 24/02/2017
 * Time: 09:55
 */
abstract class AbstractRouter implements RouterInterface
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
