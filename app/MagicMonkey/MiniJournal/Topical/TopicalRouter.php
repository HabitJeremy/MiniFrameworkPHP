<?php

namespace MagicMonkey\MiniJournal\Topical;

use MagicMonkey\Tools\Inheritance\BaseRouter;

class TopicalRouter extends BaseRouter
{
    public function parseRequest()
    {
        // ici le code qui détermine le contrôleur de classe et l'action
        // et les met dans $this->controllerClassName et $this->controllerAction
       /* $obj = empty($this->request->getGetParam("o")) ? "article" : $this->request->getGetParam("o");
        switch ($obj) {
            case "article":
                $this->controllerClassName = "MagicMonkey" . DIRECTORY_SEPARATOR . "MiniJournal" . DIRECTORY_SEPARATOR;
                $this->controllerClassName .= "Article" . DIRECTORY_SEPARATOR . "ArticleController";
                break;
        }
        $this->controllerAction = empty($this->request->getGetParam("a")) ? "home" : $this->request->getGetParam("a");*/
    }
}
