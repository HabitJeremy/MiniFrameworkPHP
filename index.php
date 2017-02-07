<?php

namespace MagicMonkey\MiniJournal;

use MagicMonkey\MiniJournal\Article\ArticleBd;
use MagicMonkey\MiniJournal\Article\ArticleForm;
use MagicMonkey\MiniJournal\Article\ArticleHtml;

require_once 'app/MagicMonkey/Tools/Loader/Autoloader.php';
require_once 'config/config.php';

spl_autoload_register(array('\MagicMonkey\Tools\Loader\Autoloader', 'load'));

$title = "";
$content = "";

$action = empty($_GET["a"]) ? "home" : $_GET["a"];

switch ($action) {
    case "update":
        $articleBd = new ArticleBd();
        $articleForm = new ArticleForm();
        $articleHtml = new ArticleHtml();
        if (empty($_GET['id'])) {
            $title = "Liste des articles";
            $articleHtml->setError("Aucun article demandé");
            $content = $articleHtml->listAll($articleBd->selectAll());
        } else {
            $article = $articleBd->selectOne(array("id =" => (int)$_GET['id']), false);
            if (empty($_POST)) {
                if ($article) {
                    $title = "Modification d'un article";
                    $content = $articleForm->formNewUpdate($article, $title, "update&id=" . $article->getId());
                } else {
                    $title = "Article inexistant";
                    $articleHtml->setError("L'article demandé n'existe pas");
                    $content = $articleHtml->listAll($articleBd->selectAll());
                }
            } else {
                if (!$articleForm->validateNew($_POST)) { // verif du formulaire : si aucune erreur
                    $articleBd->updateOne($_POST, $article->getId());/* modification de l'article dans la bdd */
                    $newArticle = $articleBd->selectOne(array("id =" => (int)$article->getId()));
                    $articleHtml->setSuccess("Modification effectuée");
                    $content = $articleHtml->showOne($newArticle);
                    /* $content = $articleHtml->listAll($articleBd->selectAll());*/
                } else { // s'il y a au moins une erreur
                    $title = "Modification d'un article";
                    $_POST['id'] = $_POST['creation_date'] = $_POST["publication_date"] = null;
                    $tempArticle = $articleBd->map($_POST);
                    $content = $articleForm->formNewUpdate($tempArticle, $title, "update&id=" . $article->getId());
                }
            }
        }
        break;
    case "delete":
        $articleBd = new ArticleBd();
        $articleForm = new ArticleForm();
        $articleHtml = new ArticleHtml();
        $title = "Choix d'un article";
        if ((empty($_GET['id']) && !empty($_POST['article'])) || !empty($_GET['id'])) {
            $id = empty($_GET['id']) ? $_POST['article'] : $_GET['id'];
            $res = $articleBd->deleteOne($id);
            if (!$res && !empty($_POST['article'])) { //suppression par formulaire
                $articleForm->setErrors(array("errorArticle" => "L'article doit être indiqué et doit existé"));
                $content = $articleForm->formSelectArticle($articleBd->selectAll());
            } else {
                if (!$res && !empty($_GET['id'])) {
                    $articleHtml->setError("Une erreur est survenue lors de la suppression de
                       l'article ! Il se peut que l'article n'existe plus.");
                } else {
                    $articleHtml->setSuccess("Suppression effectuée !");
                }
                $content = $articleHtml->listAll($articleBd->selectAll());
            }
        } else {
            $content = $articleForm->formSelectArticle($articleBd->selectAll());
        }
        break;
    case "new":
        $title = "Saisir un article";
        $articleForm = new ArticleForm();
        $articleHtml = new ArticleHtml();
        $articleBd = new ArticleBd();
        if (empty($_POST)) {
            $content = $articleForm->formNewUpdate();
        } else {
            if (!$articleForm->validateNew($_POST)) { // verif du formulaire : si aucune erreur
                $articleBd->addOne($_POST); /* enregistrement du nouvel article dans la bdd */
                $articleHtml->setSuccess("Ajout effectué");
                $content = $articleHtml->listAll($articleBd->selectAll());
            } else { // s'il y a au moins une erreur
                $_POST['id'] = $_POST['creation_date'] = $_POST["publication_date"] = null;
                $article = $articleBd->map($_POST);
                $content = $articleForm->formNewUpdate($article);
            }
        }
        break;
    case "home":
        $title = "Tous les articles";
        $lstObjsArticles = (new ArticleBd())->selectAll();
        $content = (new ArticleHtml())->listAll($lstObjsArticles);
        break;
    case "describe":
        $articleHtml = new ArticleHtml();
        $articleBd = new ArticleBd();
        if (!empty($_GET["id"])) {
            $article = (new ArticleBd())->selectOne(array("id =" => (int)$_GET['id']));
            if (!$article) {
                $title = "L'article demandé n'existe pas";
                $articleHtml->setError($title);
                $content = $articleHtml->listAll($articleBd->selectAll());
            } else {
                $title = "Détails d'un article";
                $content = $articleHtml->showOne($article);
            }
        } else {
            $title = "Aucun article demandé";
            $articleHtml->setError($title);
            $content = $articleHtml->listAll($articleBd->selectAll());
        }
        break;
    default:
        $title = "page inexistante";
        ob_start();
        include 'ui/commonViews/not-found.html';
        $content = ob_get_contents();
        ob_end_clean();
        break;
}

include "ui/layout/lBase.html";
