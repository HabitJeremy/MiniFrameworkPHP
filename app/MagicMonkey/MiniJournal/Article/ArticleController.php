<?php
/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 10/02/2017
 * Time: 09:27
 */

namespace MagicMonkey\MiniJournal\Article;

use MagicMonkey\Tools\Request\Request;
use MagicMonkey\Tools\Response\Response;

class ArticleController
{

    private $request;
    private $response;

    public function __construct(Response $response, Request $request)
    {
        $this->response = $response;
        $this->request = $request;
    }

    public function home()
    {
        $title = "Tous les articles";
        $lstObjsArticles = (new ArticleBd())->selectAll();
        $content = (new ArticleHtml())->listAll($lstObjsArticles);
        $this->response->setLstFragments(array("content" => $content, "title" => $title));
    }

    public function update()
    {
        $articleBd = new ArticleBd();
        $articleForm = new ArticleForm();
        /* $articleHtml = new ArticleHtml();*/
        if (empty($this->request->getGet()['id'])) {
            /* $articleHtml->setError("Aucun article demandé");*/
            /*$this->response->setLstFragments(array(
                "content" => $articleHtml->listAll($articleBd->selectAll()),
                "title" => "Liste des articles"
            ));*/
            $_SESSION['error'] = "Aucun article demandé";
            header('Location: index.php');
            exit();
        } else {
            $article = $articleBd->selectOne(array("id =" => (int)$this->request->getGet()['id']), false);
            if (empty($this->request->getPost())) { // s'il y a des données postées
                if ($article) { // si l'article existe
                    $title = "Modification d'un article";
                    $this->response->setLstFragments(array(
                        "content" => $articleForm->formNewUpdate($article, $title, "update&id=" . $article->getId()),
                        "title" => $title
                    ));
                } else { // s'il n'existe pas
                    /* $articleHtml->setError("L'article demandé n'existe pas");
                     $this->response->setLstFragments(array(
                         "content" => $articleHtml->listAll($articleBd->selectAll()),
                         "title" => "Article inexistant"
                     ));*/
                    $_SESSION['error'] = "L'article demandé n'existe pas";
                    header('Location: index.php');
                    exit();
                }
            } else { // s'il n'y a pas de données postées
                if (!$articleForm->validate($this->request->getPost())) { // verif du formulaire : si aucune erreur
                    /* modification de l'article dans la bdd */
                    $articleBd->updateOne($this->request->getPost(), $article->getId());
                    /* $newArticle = $articleBd->selectOne(array("id =" => (int)$article->getId()));*/
                    /* $articleHtml->setSuccess("Modification effectuée");
                     $this->response->setLstFragments(array(
                         "content" => $articleHtml->showOne($article),
                         "title" => "Détails d'un article"
                     ));*/
                    $_SESSION['success'] = "Modification effectuée";
                    header('Location: index.php?obj=article&a=describe&id=' . $article->getId());
                    exit();
                } else { // s'il y a au moins une erreur
                    $title = "Modification d'un article";
                    $this->request->getPost()['id'] =
                    $this->request->getPost()['creation_date'] =
                    $this->request->getPost()["publication_date"] = null;
                    $tempArticle = $articleBd->map($this->request->getPost());
                    $content = $articleForm->formNewUpdate($tempArticle, $title, "update&id=" . $article->getId());
                    $this->response->setLstFragments(array(
                        "content" => $content,
                        "title" => $title
                    ));
                }
            }
        }
    }

    public function insert()
    {
        $title = "Saisir un article";
        $articleForm = new ArticleForm();
        /* $articleHtml = new ArticleHtml();*/
        $articleBd = new ArticleBd();
        if (empty($this->request->getPost())) {
            $this->response->setLstFragments(array(
                "content" => $articleForm->formNewUpdate(),
                "title" => $title
            ));
        } else {
            if (!$articleForm->validate($this->request->getPost())) { // verif du formulaire : si aucune erreur
                $articleBd->addOne($this->request->getPost()); /* enregistrement du nouvel article dans la bdd */

                /* $articleHtml->setSuccess("Ajout effectué");*/
                /*    $this->response->setLstFragments(array(
                        "content" => $articleHtml->listAll($articleBd->selectAll()),
                        "title" => "Liste des articles"
                    ));*/


                $_SESSION['success'] = "Ajout effectué !";
                header('Location: index.php');
                exit();

            } else { // s'il y a au moins une erreur
                $article = $articleBd->map($this->request->getPost());
                $this->response->setLstFragments(array(
                    "content" => $articleForm->formNewUpdate($article),
                    "title" => $title
                ));
            }
        }
    }

    public function delete()
    {
        $articleBd = new ArticleBd();
        $articleForm = new ArticleForm();
       /* $articleHtml = new ArticleHtml();*/
        $title = "Liste des articles";
        $isEmptyGetId = empty($this->request->getGet()['id']);
        $isNotEmptyPostArticle = !empty($this->request->getPost()['article']);
        if (($isEmptyGetId && $isNotEmptyPostArticle) || !$isEmptyGetId) {
            $id = $isEmptyGetId ? $this->request->getPost()['article'] : $this->request->getGet()['id'];
            $res = $articleBd->deleteOne($id);
            if (!$res && $isNotEmptyPostArticle) { //suppression par formulaire
                $articleForm->setErrors(array("errorArticle" => "L'article doit être indiqué et doit existé"));
                $this->response->setLstFragments(array(
                    "content" => $articleForm->formSelectArticle($articleBd->selectAll()),
                    "title" => $title
                ));
            } else {
                if (!$res && !$isEmptyGetId) {
                    /*$articleHtml->setError("Une erreur est survenue lors de la suppression de
                       l'article ! Il se peut que l'article n'existe plus.");*/
                    $_SESSION['error'] = "Une erreur est survenue lors de la suppression de
                       l'article ! Il se peut que l'article n'existe plus";
                } else {
                    /* $articleHtml->setSuccess("Suppression effectuée !");*/
                    $_SESSION['success'] = "Suppression effectuée !";
                }
                /*$this->response->setLstFragments(array(
                    "content" => $articleHtml->listAll($articleBd->selectAll()),
                    "title" => $title
                ));*/
                header('Location: index.php');
                exit();
            }
        } else {
            $this->response->setLstFragments(array(
                "content" => $articleForm->formSelectArticle($articleBd->selectAll()),
                "title" => "Choix d'un article"
            ));
        }
    }

    public function describe()
    {
        $articleHtml = new ArticleHtml();
        /* $articleBd = new ArticleBd();*/
        if (!empty($this->request->getGet()["id"])) { /* id pas vide */
            $article = (new ArticleBd())->selectOne(array("id =" => (int)$this->request->getGet()['id']));
            if (!$article) { /* article inexistant */
                /* $title = "L'article demandé n'existe pas";
                 $articleHtml->setError($title);
                 $this->response->setLstFragments(array(
                     "content" => $articleHtml->listAll($articleBd->selectAll()),
                     "title" => $title
                 ));*/
                $_SESSION['error'] = "L'article demandé n'existe pas";
                header('Location: index.php');
                exit();
            } else { /* article existe */
                $this->response->setLstFragments(array(
                    "content" => $articleHtml->showOne($article),
                    "title" => "Détails d'un article"
                ));
            }
        } else { /* id non renseigné */
            /* $title = "Aucun article demandé";
             $articleHtml->setError($title);
             $this->response->setLstFragments(array(
                 "content" => $articleHtml->listAll($articleBd->selectAll()),
                 "title" => $title
             ));*/
            $_SESSION['error'] = "Aucun article demandé";
            header('Location: index.php');
            exit();
        }
    }

    public function notFound()
    {
        $this->response->setLstFragments(array(
            "content" => (new ArticleHtml())->notFound(),
            "title" => "page inexistante"
        ));
    }
}
