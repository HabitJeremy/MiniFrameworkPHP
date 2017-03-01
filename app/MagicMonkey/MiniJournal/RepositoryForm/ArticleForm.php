<?php

namespace MagicMonkey\MiniJournal\RepositoryForm;

use MagicMonkey\Framework\Inheritance\AbstractForm;
use MagicMonkey\Framework\Validator\Type\MaxLength;
use MagicMonkey\Framework\Validator\Type\NotBlank;
use MagicMonkey\Framework\Validator\Type\Valid;
use MagicMonkey\MiniJournal\Entity\Article;

class ArticleForm extends AbstractForm
{
    protected $article;

    public function __construct()
    {
        parent::__construct("article");
        $this->article = new Article();
    }
    /*
    public function formSelectArticle($lst, $action = "delete")
    {
        ob_start();
        include 'view/vFormSelect.html';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }*/

    public function validationOptions()
    {
        $this->validatorManager
            ->add('title', new NotBlank())
            ->add('title', new MaxLength(255))
            ->add('author', new NotBlank())
            ->add('author', new MaxLength(255))
            ->add('content', new NotBlank())
            ->add('chapo', new NotBlank())
            ->add('publication_status', new NotBlank())
            ->add('publication_status', new Valid(array("brouillon", "publie")));
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