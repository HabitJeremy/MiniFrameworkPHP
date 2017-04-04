<?php

namespace MagicMonkey\MiniJournal;

use MagicMonkey\Framework\HttpFoundation\Response;
use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\Tool\Auth\AuthManager;
use MagicMonkey\Framework\Tool\Flash\FlashMessage;
use MagicMonkey\Framework\Controller\FrontController;

require_once 'app/MagicMonkey/Framework/Tool/Loader/Autoloader.php';
require_once 'config/config.php';
require_once 'vendor/autoload.php'; // loader de composer
require_once 'config/twigLoader.php'; // loader / initialisation de twig
require_once 'config/twigFunctions.php'; // initialisation des functions personnalisées de twig

/* block session */
session_name(WEB_SITE_NAME);
session_start();
/* end block session */
spl_autoload_register(array('\MagicMonkey\Framework\Tool\Loader\Autoloader', 'load'));
$request = new Request();
$response = new Response();
$flash = FlashMessage::getInstance(); // objet pour les notifications
$authManager = AuthManager::getInstance($request);
$twig = iniTwig(); //initTwig from config/twigLoader.php
initFunctionsTwig($authManager, $twig);
try {
    $frontCtrl = new FrontController($request, $response);
    $frontCtrl->main();
} catch (\Exception $ex) {
    // utiliser la constante MODE_DEV déclarée en config pour décider du message à afficher
    if (MODE_DEV) {
        $response->setTemplate("exception/lThrowExceptionDev.html.twig");
        $response->setLstFragments(array(
            "content" => nl2br($ex->getTraceAsString())
        ));
        $_SESSION['error'] = $ex->getMessage();
    } else {
        $response->setTemplate("exception/lThrowException.html.twig");
        $response->setLstFragments(array(
            "content" => "Tout ne se passe pas comme prévu ... tenez bon !"
        ));
        $_SESSION['error'] = "Une erreur d'exécution s'est produite";
    }
    header('HTTP/1.0 404 Not Found');
}

// ajout du gestionnaire des notifications
$response->addOneFragment("flashAll", $flash->all(array('error', 'success', 'info', 'warning')));
// affichage
echo $twig->render($response->getTemplate(), $response->getLstFragments());
