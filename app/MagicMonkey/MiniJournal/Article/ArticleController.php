<?php

namespace MagicMonkey\MiniJournal\Article;

use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\HttpFoundation\Response;
use MagicMonkey\Framework\Inheritance\AbstractController;

class ArticleController extends AbstractController
{

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    public function home()
    {
        $title = "Tous les articles";
        $lstObjsArticles = (new ArticleBd())->selectAll();
        $content = (new ArticleHtml())->listAll(
            $lstObjsArticles,
            'MagicMonkey/MiniJournal/Article/views/vAllArticles.html'
        );
        $this->response->setLstFragments(array("content" => $content, "title" => $title));
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
                    $title = "Modification d'un article";
                    $this->response->setLstFragments(array(
                        "content" => $articleForm->formNewUpdate(
                            $title,
                            "MagicMonkey/MiniJournal/Article/views/vFormNewUpdate.html",
                            $article,
                            "update&id=" . $article->getId()
                        ),
                        "title" => $title
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
                    $title = "Modification d'un article";
                    $this->request->getPost()['id'] =
                    $this->request->getPost()['creation_date'] =
                    $this->request->getPost()["publication_date"] = null;
                    $tempArticle = $articleBd->mapp($this->request->getPost());
                    $content = $articleForm->formNewUpdate(
                        $title,
                        "MagicMonkey/MiniJournal/Article/views/vFormNewUpdate.html",
                        $tempArticle,
                        "update&id=" . $article->getId()
                    );
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
                "content" => $articleForm->formNewUpdate(
                    "Ajout d'un article",
                    "MagicMonkey/MiniJournal/Article/views/vFormNewUpdate.html"
                ),
                "title" => $title
            ));
        } else {
            if ($articleForm->validate($this->request->getPost())) { // verif du formulaire : si aucune erreur
                $articleBd->add($this->request->getPost()); /* enregistrement du nouvel article dans la bdd */
                $_SESSION['success'] = "Ajout effectué !";
                header('Location: index.php');
                exit();
            } else { // s'il y a au moins une erreur
                $article = $articleBd->mapp($this->request->getPost());
                $this->response->setLstFragments(array(
                    "content" => $articleForm->formNewUpdate(
                        "Ajout d'un article",
                        "MagicMonkey/MiniJournal/Article/views/vFormNewUpdate.html",
                        $article
                    ),
                    "title" => $title
                ));
            }
        }
    }

    public function delete()
    {
        $articleBd = new ArticleBd();
        $articleForm = new ArticleForm();
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
                    $_SESSION['error'] = "Une erreur est survenue lors de la suppression de
                       l'article ! Il se peut que l'article n'existe plus";
                } else {
                    /* $articleHtml->setSuccess("Suppression effectuée !");*/
                    $_SESSION['success'] = "Suppression effectuée !";
                }
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
        if (!empty($this->request->getGet()["id"])) { /* id pas vide */
            $article = (new ArticleBd())->selectOne(array("id =" => (int)$this->request->getGet()['id']));
            if (!$article) { /* article inexistant */
                $_SESSION['error'] = "L'article demandé n'existe pas";
                header('Location: index.php');
                exit();
            } else { /* article existe */
                $this->response->setLstFragments(array(
                    "content" => $articleHtml->showOne(
                        $article,
                        'MagicMonkey/MiniJournal/Article/views/vOneArticle.html'
                    ),
                    "title" => "Détails d'un article"
                ));
            }
        } else { /* id non renseigné */
            $_SESSION['error'] = "Aucun article demandé";
            header('Location: index.php');
            exit();
        }
    }
}
