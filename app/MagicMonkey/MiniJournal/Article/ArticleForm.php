<?php
/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 06/02/2017
 * Time: 15:46
 */

namespace MagicMonkey\MiniJournal\Article;

class ArticleForm
{
    const LSTVALIDSTATUS = array("brouillon", "publie");

    private $errors;
    private $article;

    public function __construct()
    {
        $this->errors = array();
        $this->article = new Article();
    }

    /* Permet l'affichage des notifications/messages afin d'informer l'utilisateur */
    public function showMsg($key, $error = true)
    {
        $res = "";
        if (array_key_exists($key, $this->errors)) {
            $class = "error";
            if (!$error) {
                $class = "success";
            }
            $res = "<span class='msg-" . $class . " marg-10-bottom'>";
            $res .= $this->errors[$key];
            $res .= "</span>";
        }
        return $res;
    }

    /* show form new article */
    public function formNewUpdate($obj = null, $h1 = "Ajout d'un article", $action = "insert")
    {
        if (!empty($obj)) {
            $this->article = $obj;
        }
        ob_start();
        include 'views/vFormNewUpdate.html';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function formSelectArticle($lst, $action = "delete")
    {
        ob_start();
        include 'views/vFormSelect.html';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /* Permet la vérifiction des données du formulaire " Nouveau " */
    public function validate($postedData)
    {
        $error = false;
        /* title */
        if (empty($postedData['title']) || (strlen($postedData['title']) > 255)) {
            $error = true;
            $this->errors["errorTitle"] = "Le titre doit être renseigné et ne doit pas dépasser 255 caractères";
        }
        /* author */
        if (empty($postedData['author']) || (strlen($postedData['author']) > 255)) {
            $this->errors["errorAuthor"] = "L'auteur doit être renseigné et ne doit pas dépasser 255 caractères";
            $error = true;
        }
        /* content */
        if (empty($postedData['content'])) {
            $this->errors["errorContent"] = "Le contenu doit être renseigné";
            $error = true;
        }
        /* chapo */
        if (empty($postedData['chapo'])) {
            $this->errors["errorChapo"] = "Le 'chapo' doit être renseigné";
            $error = true;
        }
        /* status */
        if (empty($postedData['publication_status']) ||
            !in_array($postedData['publication_status'], self::LSTVALIDSTATUS)
        ) {
            $this->errors['errorStatus'] = "Le statut doit être indiqué et doit correspondre à un statut valide";
            $error = true;
        }
        return $error;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /* ajout d'une erreur dans l'array errors */
    public function addErrors($newItem)
    {
        array_push($this->errors, $newItem);
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }
}
