<?php

namespace MagicMonkey\MiniJournal\Controller;

use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\HttpFoundation\Response;
use MagicMonkey\Framework\Inheritance\AbstractController;
use MagicMonkey\MiniJournal\RepositoryBd\UserBd;
use MagicMonkey\MiniJournal\RepositoryForm\UserForm;

/**
 * Class UserController
 * @package MagicMonkey\Framework\Controller
 */
class UserController extends AbstractController
{
    /**
     * UserController constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    public function registration()
    {
        $userForm = new UserForm();
        $userBd = new UserBd();
       /* var_dump($this->request->getPost());
        die();*/
        if (count($this->request->getPost()) == 0) { // si il n'y a pas de données postées
            $this->render("view/vUserRegistration.html.twig");
        } else {
            $postedData = $this->request->getPost();
            if ($userForm->validate($postedData)) { // verif du formulaire : si aucune erreur
                $userForm->clean($postedData);
                $userBd->add($postedData); /* enregistrement du nouvel article dans la bdd */
                $_SESSION['success'] = "Féliciations " . $postedData['login'] . ", vous êtes maintenant inscrit !"; // et redirection vers l'accueil
                header('Location: index.php');
                exit();
            } else { // s'il y a au moins une erreur => redirection vers le fomulaire avec des notifications pour
                // aider l'utilisateur
                $userForm->setUser($userBd->mapp($this->request->getPost()));
                $this->render("view/vUserRegistration.html.twig", array(
                    "userForm" => $userForm,
                    "user" => $userForm->getUser()
                ));
            }
        }
    }
}
