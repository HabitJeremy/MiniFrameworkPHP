<?php

namespace MagicMonkey\MiniJournal;

use MagicMonkey\Tools\HttpFoundation\Response;
use MagicMonkey\Tools\HttpFoundation\Request;
use MagicMonkey\Tools\Flash\FlashMessage;
use MagicMonkey\Tools\Controller\FrontController;

require_once 'app/MagicMonkey/Tools/Loader/Autoloader.php';
require_once 'config/config.php';

$response = "";

try {
    spl_autoload_register(array('\MagicMonkey\Tools\Loader\Autoloader', 'load'));
    $flash = FlashMessage::getInstance();
    $response = new Response();
    $request = new Request();
    $frontCtrl = new FrontController($request, $response);
    $frontCtrl->main();
} catch (\Exception $ex) {
    // utiliser la constante MODE_DEV déclarée en config pour décider du message à afficher
    if (MODE_DEV) {
        $response->setLstFragments(array(
            "title" => "Erreur",
            "content" => "<div>" . nl2br($ex->getTraceAsString()) . "</div>"
        ));
        $_SESSION['error'] = $ex->getMessage();
    } else {
        $response->setLstFragments(array(
            "title" => "Erreur"
        ));
        $_SESSION['error'] = "Une erreur d'exécution s'est produite";
    }
}

include "ui/layout/lBase.html";
