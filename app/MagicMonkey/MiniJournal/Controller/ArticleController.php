<?php

namespace MagicMonkey\MiniJournal\Controller;

use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\HttpFoundation\Response;
use MagicMonkey\Framework\Inheritance\AbstractController;
use MagicMonkey\MiniJournal\RepositoryBd\ArticleBd;
use MagicMonkey\MiniJournal\RepositoryForm\ArticleForm;
use MagicMonkey\MiniJournal\RepositoryBd\ImageBd;

/**
 * Class ArticleController
 * @package MagicMonkey\MiniJournal\Controller
 */
class ArticleController extends AbstractController
{
    /**
     * ArticleController constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * 1) Récupère la liste des articles
     * 2) Définition de la vue et des données à lui passer
     */
    public function home()
    {
        $lstObjsArticles = (new ArticleBd())->selectAll();
        $this->render("article/vAllArticles.html.twig", array("articles" => $lstObjsArticles));
    }

    /**
     * Permet de modifier un artile
     * Gère plusieurs cas d'erreurs
     */
    public function update()
    {
        $articleBd = new ArticleBd();
        $articleForm = new ArticleForm();
        if (empty($this->request->getGet()['id'])) { // si il n'y a pas d'identifiant de passé
            $_SESSION['error'] = "Aucun article demandé";
            header('Location: index.php');
            exit();
        } else { // s'il y a un identifiant
            $articleForm->setArticle($articleBd->selectOne(array(
                "id =" => (int)$this->request->getGet()['id']),
                false
            ));
            if (count($this->request->getPost()) == 0) { // s'il n'y a pas de données postées
                if ($articleForm->getArticle()) { // si l'article existe => affichage formulaire d'édition article
                    $this->render("article/vFormNewUpdate.html.twig", array(
                        "title" => "Modification d'un article",
                        "article" => $articleForm->getArticle(),
                        "action" => "update&id=" . $articleForm->getArticle()->getId(),
                        "articleForm" => $articleForm
                    ));
                } else { // s'il n'existe pas => notifcation d'erreur + redirection accueil
                    $_SESSION['error'] = "L'article demandé n'existe pas";
                    header('Location: index.php');
                    exit();
                }
            } else { // s'il y a des données postées
                $postedData = $this->request->getPost();
                if ($articleForm->validate($postedData)) { // verif du formulaire : si aucune erreur
                    $articleForm->clean($postedData);
                    /* modification de l'article dans la bdd */
                    $articleBd->update($postedData, $articleForm->getArticle()->getId());
                    $_SESSION['success'] = "Modification effectuée";
                    header('Location: index.php?o=article&a=describe&id=' . $articleForm->getArticle()->getId());
                    exit();
                } else { // s'il y a au moins une erreur => retour au formulaire avec notifications d'erreurs
                    //pour aider l'utilisateur
                    $this->request->addPostParam("id", $articleForm->getArticle()->getId());
                    $articleForm->setArticle($articleBd->mapp($this->request->getPost()));
                    $this->render("article/vFormNewUpdate.html.twig", array(
                        "title" => "Modification d'un article",
                        "article" => $articleForm->getArticle(),
                        "action" => "update&id=" . $articleForm->getArticle()->getId(),
                        "articleForm" => $articleForm
                    ));
                }
            }
        }
    }

    /**
     * Permet d'ajouter un article
     */
    public function insert()
    {
        $imageBd = new ImageBd();
        $articleForm = new ArticleForm();
        $articleBd = new ArticleBd();
        if (count($this->request->getPost()) == 0) { // s'il y a pas de données postées => affichage du formulaire
            $this->render("article/vFormNewUpdate.html.twig", array(
                "title" => "Ajout d'un article",
                "action" => "insert",
                "articleForm" => $articleForm,
                "images" => $imageBd->selectAll()
            ));
        } else {
            $postedData = $this->request->getPost();
            if ($articleForm->validate($postedData)) { // verif du formulaire : si aucune erreur
                $articleForm->clean($postedData);

                $articleBd->add($postedData); /* enregistrement du nouvel article dans la bdd */
                $_SESSION['success'] = "Ajout effectué !"; // et redirection vers l'accueil
                header('Location: index.php');
                exit();
            } else { // s'il y a au moins une erreur => redirection vers le fomulaire avec des notifications pour
                // aider l'utilisateur
                $articleForm->setArticle($articleBd->mapp($this->request->getPost()));
                $this->render("article/vFormNewUpdate.html.twig", array(
                    "articleForm" => $articleForm,
                    "title" => "Ajout d'un article",
                    "article" => $articleForm->getArticle(),
                    "action" => "insert"
                ));
            }
        }
    }

    /**
     * Permet de supprimer un article
     */
    public function delete()
    {
        $articleBd = new ArticleBd();
        $articleForm = new ArticleForm();
        $isEmptyGetId = !isset($this->request->getGet()['id']);
        $isNotEmptyPostArticle = isset($this->request->getPost()['article']);
        if (($isEmptyGetId && $isNotEmptyPostArticle) || !$isEmptyGetId) {
            $id = $isEmptyGetId ? $this->request->getPost()['article'] : $this->request->getGet()['id'];
            $res = $articleBd->deleteOne($id);
            if (!$res && $isNotEmptyPostArticle) { //suppression par formulaire
                $articleForm->setErrors(array("errorArticle" => "L'article doit être indiqué et doit existé"));
                $this->render("article/vFormSelect.html.twig", array( // redirection vers le formulaire de selection
                    "articles" => $articleBd->selectAll(),
                    "articleForm" => $articleForm,
                    "action" => "delete"
                ));
            } else { // redirection vers l'accueil
                if (!$res && !$isEmptyGetId) { // article inexistant
                    $_SESSION['error'] = "Une erreur est survenue lors de la suppression de
                       l'article ! Il se peut que l'article n'existe plus";
                } else { // success
                    $_SESSION['success'] = "Suppression effectuée !";
                }
                header('Location: index.php');
                exit();
            }
        } else { // affichage du formulaire pour choisir un article
            $this->render("article/vFormSelect.html.twig", array(
                "articles" => $articleBd->selectAll(),
                "articleForm" => $articleForm,
                "action" => "delete"
            ));
        }
    }

    /**
     * Permet d'afficher un article
     */
    public function describe()
    {
        if (isset($this->request->getGet()["id"])) { /* si il y a un identifiant */
            //$article = (new ArticleBd())->selectOne(array("id =" => (int)$this->request->getGet()['id']));
            $article = (new ArticleBd())->eagerSelectOne((int)$this->request->getGet()['id']);
            if (!$article) { /* article inexistant  => redirection vers l'accueil avec notification pour aider
 l'utilisateur*/
                $_SESSION['error'] = "L'article demandé n'existe pas";
                header('Location: index.php');
                exit();
            } else { /* article existe  => affichage de l'article */
                $this->render("article/vOneArticle.html.twig", array("article" => $article));
            }
        } else { /* id non renseigné => redirection vers l'accueil*/
            $_SESSION['error'] = "Aucun article demandé";
            header('Location: index.php');
            exit();
        }
    }
}
