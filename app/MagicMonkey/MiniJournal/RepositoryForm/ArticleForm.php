<?php

namespace MagicMonkey\MiniJournal\RepositoryForm;

use MagicMonkey\Framework\Cleaner\CleanerList\Nl2br;
use MagicMonkey\Framework\Cleaner\CleanerList\StripTags;
use MagicMonkey\Framework\Cleaner\CleanerList\Trim;
use MagicMonkey\Framework\Inheritance\AbstractForm;
use MagicMonkey\Framework\Validator\ValidatorList\MaxLength;
use MagicMonkey\Framework\Validator\ValidatorList\NotBlank;
use MagicMonkey\Framework\Validator\ValidatorList\ValidValues;
use MagicMonkey\MiniJournal\Entity\Article;

/**
 * Class ArticleForm
 * @package MagicMonkey\MiniJournal\RepositoryForm
 */
class ArticleForm extends AbstractForm
{
    /**
     * @var Article
     */
    protected $article;

    /**
     * ArticleForm constructor.
     */
    public function __construct()
    {
        parent::__construct("article");
        $this->article = new Article();
    }

    /**
     * Permet de vérifier les données postées via un formulaire :
     * ajout de différentes validations sur différents champs
     */
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
            ->add('publication_status', new ValidValues(array("brouillon", "publie")));
    }

    public function cleaningOptions()
    {
        $this->cleanerManager
            ->add('author', new StripTags())
            ->add('author', new Trim())
            ->add('author', new Nl2br())
            ->add('title', new StripTags())
            ->add('title', new Trim())
            ->add('title', new Nl2br())
            ->add('publication_status', new StripTags())
            ->add('publication_status', new Trim())
            ->add('publication_status', new Nl2br())
            ->add('chapo', new StripTags())
            ->add('chapo', new Trim())
            ->add('chapo', new Nl2br())
            ->add('content', new Trim());
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
