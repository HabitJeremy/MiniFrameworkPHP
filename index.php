<?php

namespace MagicMonkey\MiniJournal;

use MagicMonkey\Framework\HttpFoundation\Response;
use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\Tool\Auth\AuthManager;
use MagicMonkey\Framework\Tool\Flash\FlashMessage;
use MagicMonkey\Framework\Controller\FrontController;
use MagicMonkey\Framework\Tool\Twig\TwigManager;

require_once 'app/MagicMonkey/Framework/Tool/Loader/Autoloader.php';
require_once 'config/config.php';
require_once 'vendor/autoload.php'; // loader de composer

/* block session */
session_name(WEB_SITE_NAME);
session_start();
/* auto loader */
spl_autoload_register(array('\MagicMonkey\Framework\Tool\Loader\Autoloader', 'load'));
$request = new Request();
$response = new Response();
$flash = FlashMessage::getInstance(); // singleton pour les notifications (sorte de flashbag à la symfony)
$authManager = AuthManager::getInstance($request); // singleton pour gérer l'authentification
$twigManager = new TwigManager();// gère l'initialisation de twig, ses functions et variables globales
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
if (!empty($response->getTemplate())) {
    echo $twigManager->getTwig()->render($response->getTemplate(), $response->getLstFragments());
}