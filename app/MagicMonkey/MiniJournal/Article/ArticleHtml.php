<?php

namespace MagicMonkey\MiniJournal\Article;

class ArticleHtml
{
    private $startContent;
    private $endContent;
    private $error;
    private $success;

    public function __construct()
    {
        $this->startContent = "<div class='row'><div class='cell-12'>";
        $this->endContent = "</div></div>";
    }

    /* Permet l'affichage des notifications/messages afin d'informer l'utilisateur */
    public function showMsg()
    {
        $res = "";
        if (!empty($this->error) || !empty($this->success)) {
            $res = $this->startContent;
            if (!empty($this->error)) {
                $res .= $this->makeTagMsg($this->error);
            }
            if (!empty($this->success)) {
                $res .= $this->makeTagMsg($this->success, false);
            }
            $res .= $this->endContent;
        }
        return $res;
    }

    /* fonction utilisée par la fonction showMsg() */
    private function makeTagMsg($msg, $error = true)
    {
        $class = "error";
        if (!$error) {
            $class = "success";
        }
        return "<p class='msg-" . $class . " marg-10-bottom'>" . $msg . "</p>";
    }

    /* default list all articles */
    public function listAll($lst)
    {
        ob_start();
        include 'views/vAllArticles.html';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /* show one article */
    public function showOne($article)
    {
        ob_start();
        include 'views/vOneArticle.html';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param mixed $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }
}
