<?php

namespace MagicMonkey\MiniJournal;

use MagicMonkey\Framework\HttpFoundation\Response;
use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\Flash\FlashMessage;
use MagicMonkey\Framework\Controller\FrontController;

require_once 'app/MagicMonkey/Framework/Loader/Autoloader.php';
require_once 'config/config.php';
require_once 'vendor/autoload.php';

/* TWIG */
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

require_once("vendor/twig/twig/lib/Twig/Autoloader.php");
/*Twig_Autoloader::register();*/
$loader = new Twig_Loader_Filesystem("ui/layout");
$twig = new Twig_Environment($loader, array(
    "cache" => false,
    "debug" => true
));
$twig->addExtension(new Twig_Extension_Debug());






$response = "";
spl_autoload_register(array('\MagicMonkey\Framework\Loader\Autoloader', 'load'));
$flash = FlashMessage::getInstance();

try {
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

echo $twig->render("lBase.html.twig", array(
    "response" => $response,
    "flashAll" => $flash->all(array("success", "error", "warning", "info"))
));

/*include "ui/layout/lBase.html";*/
