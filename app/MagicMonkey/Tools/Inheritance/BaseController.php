<?php

namespace MagicMonkey\Tools\Inheritance;

use MagicMonkey\Tools\HttpFoundation\Request;
use MagicMonkey\Tools\HttpFoundation\Response;

/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 24/02/2017
 * Time: 10:11
 */

abstract class BaseController
{
    protected $request;
    protected $response;

    protected function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request = $request;
    }

    protected function execute($action)
    {
        if (method_exists($this, $action)) {
            return $this->$action();
        } else {
            throw new \Exception("Action {$action} non trouvée");
        }
    }
}
