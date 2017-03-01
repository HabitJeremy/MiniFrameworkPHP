<?php

namespace MagicMonkey\Framework\Inheritance;

use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\HttpFoundation\Response;

abstract class AbstractController
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

    public function render($template, $fragments)
    {
        $this->response->setTemplate($template);
        $this->response->setLstFragments($fragments);
    }
}
