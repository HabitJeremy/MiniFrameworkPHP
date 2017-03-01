<?php

namespace MagicMonkey\MiniJournal\Controller;

use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\HttpFoundation\Response;
use MagicMonkey\Framework\Inheritance\AbstractController;
use MagicMonkey\MiniJournal\RepositoryBd\ArticleBd;
use MagicMonkey\MiniJournal\RepositoryForm\ArticleForm;

class ArticleController extends AbstractController
{
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    public function home()
    {
        $lstObjsArticles = (new ArticleBd())->selectAll();
        $this->render("Article/vAllArticles.html.twig", array("articles" => $lstObjsArticles));
    }

    public function update()
    {
        $articleBd = new ArticleBd();
        $articleForm = new ArticleForm();
        if (empty($this->request->getGet()['id'])) {
            $_SESSION['error'] = "Aucun article demandé";
            header('Location: index.php');
            exit();
        } else {
            $article = $articleBd->selectOne(array("id =" => (int)$this->request->getGet()['id']), false);
            if (empty($this->request->getPost())) { // s'il y a des données postées
                if ($article) { // si l'article existe
                    $this->render("Article/vFormNewUpdate.html.twig", array(
                        "title" => "Modification d'un article",
                        "article" => $article,
                        "action" => "update&id=" . $article->getId(),
                        "articleForm" => $articleForm
                    ));
                } else { // s'il n'existe pas
                    $_SESSION['error'] = "L'article demandé n'existe pas";
                    header('Location: index.php');
                    exit();
                }
            } else { // s'il n'y a pas de données postées
                if ($articleForm->validate($this->request->getPost())) { // verif du formulaire : si aucune erreur
                    /* modification de l'article dans la bdd */
                    $articleBd->update($this->request->getPost(), $article->getId());
                    $_SESSION['success'] = "Modification effectuée";
                    header('Location: index.php?o=article&a=describe&id=' . $article->getId());
                    exit();
                } else { // s'il y a au moins une erreur
                    $this->request->getPost()['id'] =
                    $this->request->getPost()['creation_date'] =
                    $this->request->getPost()["publication_date"] = null;
                    $tempArticle = $articleBd->mapp($this->request->getPost());

                    $this->render("Article/vFormNewUpdate.html.twig", array(
                        "title" => "Modification d'un article",
                        "article" => $tempArticle,
                        "action" => "update&id=" . $article->getId(),
                        "articleForm" => $articleForm
                    ));
                }
            }
        }
    }

    public function insert()
    {
        $articleForm = new ArticleForm();
        $articleBd = new ArticleBd();
        if (empty($this->request->getPost())) {
            $this->render("Article/vFormNewUpdate.html.twig", array(
                "title" => "Ajout d'un article",
                "action" => "insert",
                "articleForm" => $articleForm
            ));
        } else {
            if ($articleForm->validate($this->request->getPost())) { // verif du formulaire : si aucune erreur
                $articleBd->add($this->request->getPost()); /* enregistrement du nouvel article dans la bdd */
                $_SESSION['success'] = "Ajout effectué !";
                header('Location: index.php');
                exit();
            } else { // s'il y a au moins une erreur
                $article = $articleBd->mapp($this->request->getPost());
                $this->render("Article/vFormNewUpdate.html.twig", array(
                    "articleForm" => $articleForm,
                    "title" => "Ajout d'un article",
                    "article" => $article,
                    "action" => "insert"
                ));
            }
        }
    }

    public function delete()
    {
        $articleBd = new ArticleBd();
        $articleForm = new ArticleForm();
        $isEmptyGetId = empty($this->request->getGet()['id']);
        $isNotEmptyPostArticle = !empty($this->request->getPost()['article']);
        if (($isEmptyGetId && $isNotEmptyPostArticle) || !$isEmptyGetId) {
            $id = $isEmptyGetId ? $this->request->getPost()['article'] : $this->request->getGet()['id'];
            $res = $articleBd->deleteOne($id);
            if (!$res && $isNotEmptyPostArticle) { //suppression par formulaire
                $articleForm->setErrors(array("errorArticle" => "L'article doit être indiqué et doit existé"));
                $this->render("Article/vFormSelect.html.twig", array(
                    "articles" => $articleBd->selectAll(),
                    "articleForm" => $articleForm,
                    "action" => "delete"
                ));
            } else {
                if (!$res && !$isEmptyGetId) {
                    $_SESSION['error'] = "Une erreur est survenue lors de la suppression de
                       l'article ! Il se peut que l'article n'existe plus";
                } else {
                    $_SESSION['success'] = "Suppression effectuée !";
                }
                header('Location: index.php');
                exit();
            }
        } else {
            $this->render("Article/vFormSelect.html.twig", array(
                "articles" => $articleBd->selectAll(),
                "articleForm" => $articleForm,
                "action" => "delete"
            ));
        }
    }

    public function describe()
    {
        if (!empty($this->request->getGet()["id"])) { /* id pas vide */
            $article = (new ArticleBd())->selectOne(array("id =" => (int)$this->request->getGet()['id']));
            if (!$article) { /* article inexistant */
                $_SESSION['error'] = "L'article demandé n'existe pas";
                header('Location: index.php');
                exit();
            } else { /* article existe */
                $this->render("Article/vOneArticle.html.twig", array("data" => $article));
            }
        } else { /* id non renseigné */
            $_SESSION['error'] = "Aucun article demandé";
            header('Location: index.php');
            exit();
        }
    }
}
