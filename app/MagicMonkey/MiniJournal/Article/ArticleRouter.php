<?php

namespace MagicMonkey\MiniJournal\Article;

use MagicMonkey\Tools\HttpFoundation\Request;
/*use MagicMonkey\Tools\Router\Router;*/

class ArticleRouter
{
    protected $controllerClassName;
    protected $controllerAction;
    protected $request;

    public function __construct(Request $request)
    {
       /* parent::__construct($request);*/
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

    protected function parseRequest()
    {
        // ici le code qui détermine le contrôleur de classe et l'action
        // et les met dans $this->controllerClassName et $this->controllerAction
        $obj = empty($this->request->getGetParam("o")) ? "article" : $this->request->getGetParam("o");
        switch ($obj) {
            case "article":
                $this->controllerClassName = "MagicMonkey" . DIRECTORY_SEPARATOR . "MiniJournal" . DIRECTORY_SEPARATOR;
                $this->controllerClassName .= "Article" . DIRECTORY_SEPARATOR . "ArticleController";
                break;
        }
        $this->controllerAction = empty($this->request->getGetParam("a")) ? "home" : $this->request->getGetParam("a");
    }
}