<?php

namespace MagicMonkey\MiniJournal;

use MagicMonkey\MiniJournal\Article\ArticleController;
use MagicMonkey\Tools\HttpFoundation\Response;
use MagicMonkey\Tools\HttpFoundation\Request;
use MagicMonkey\Tools\Flash\FlashMessage;

require_once 'app/MagicMonkey/Tools/Loader/Autoloader.php';
require_once 'config/config.php';

spl_autoload_register(array('\MagicMonkey\Tools\Loader\Autoloader', 'load'));

$obj = empty($_GET["o"]) ? "article" : $_GET["o"];
$action = empty($_GET["a"]) ? "home" : $_GET["a"];


$response = new Response();
$request = new Request();
$flash = FlashMessage::getInstance();

switch ($obj) {
    case "article":
        $ctrl = new ArticleController($response, $request);
        break;
}

if (method_exists($ctrl, $action)) {
    $ctrl->$action();
} else {
    $ctrl->notFound();
}
foreach ($response->getLstFragments() as $key => $value) {
    ${$key} = $value;
}

include "ui/layout/lBase.html";
