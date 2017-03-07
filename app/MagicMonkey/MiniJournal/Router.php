<?php

namespace MagicMonkey\MiniJournal;

use MagicMonkey\Framework\Inheritance\AbstractRouter;

/**
 * Class Router
 * @package MagicMonkey\MiniJournal
 */
class Router extends AbstractRouter
{
    /**
     * @throws \Exception
     */
    public function parseRequest()
    {
        // ici le code qui détermine le contrôleur de classe et l'action
        // et les met dans $this->controllerClassName et $this->controllerAction
        $package = $this->request->getGetParam('o');
        switch ($package) {
            case "article":
                $this->controllerClassName = APP_OWNER . DS_ROUTER . APP_NAME . DS_ROUTER . "Controller" . DS_ROUTER . "ArticleController";
                break;
            case "image":
                $this->controllerClassName = APP_OWNER . DS_ROUTER . APP_NAME . DS_ROUTER . "Controller" . DS_ROUTER . "ImageController";
                break;
            case "page":
                $this->controllerClassName = APP_OWNER . DS_ROUTER . APP_NAME . DS_ROUTER . "Controller" . DS_ROUTER . "PageController";
                break;
            default:
                $this->controllerClassName = APP_OWNER . DS_ROUTER . APP_NAME . DS_ROUTER . "Controller" . DS_ROUTER . "ArticleController";
        }

        // tester si la classe à instancier existe bien. Si non lancer une Exception.
        if (!class_exists($this->controllerClassName)) {
            throw new \Exception("Classe {$this->controllerClassName} non existante");
        }

        // regarder si une action est demandée dans l'URL
        // si le paramètre 'a' n'existe pas alors l'action sera 'defaultAction'
        $this->controllerAction = $this->request->getGetParam('a', 'home');

        // tester si l'action existe bien. Si non lancer une Exception
        if (!method_exists($this->controllerClassName, $this->controllerAction)) {
            throw new \Exception("Action {$this->controllerAction} non existante");
        }
    }
}
