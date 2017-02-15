<?php

namespace MagicMonkey\MiniJournal;

use MagicMonkey\MiniJournal\Article\ArticleController;
use MagicMonkey\Tools\Response\Response;
use MagicMonkey\Tools\Request\Request;
use MagicMonkey\Tools\Flash\FlashMessage;

require_once 'app/MagicMonkey/Tools/Loader/Autoloader.php';
require_once 'config/config.php';

spl_autoload_register(array('\MagicMonkey\Tools\Loader\Autoloader', 'load'));

$title = "";
$content = "";

$action = empty($_GET["a"]) ? "home" : $_GET["a"];
$obj = empty($_GET["obj"]) ? "article" : $_GET["obj"];

$response = new Response();
$request = new Request($_POST, $_GET);
$flash = FlashMessage::getInstance();

switch ($obj) {
    case "article":
        $articleCtrl = new ArticleController($response, $request);
        if (method_exists($articleCtrl, $action)) {
            $articleCtrl->$action();
        } else {
            $articleCtrl->notFound();
        }
        foreach ($response->getLstFragments() as $key => $value) {
            ${$key} = $value;
        }
        break;
}

include "ui/layout/lBase.html";
