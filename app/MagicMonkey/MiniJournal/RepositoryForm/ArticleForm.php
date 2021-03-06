<?php

namespace MagicMonkey\MiniJournal\RepositoryForm;

use MagicMonkey\Framework\Cleaner\CleanerList\Nl2br;
use MagicMonkey\Framework\Cleaner\CleanerList\StripTags;
use MagicMonkey\Framework\Cleaner\CleanerList\Trim;
use MagicMonkey\Framework\Inheritance\AbstractForm;
use MagicMonkey\Framework\Validator\ValidatorList\MaxLength;
use MagicMonkey\Framework\Validator\ValidatorList\NotBlank;
use MagicMonkey\Framework\Validator\ValidatorList\ValidObjects;
use MagicMonkey\Framework\Validator\ValidatorList\ValidValue;
use MagicMonkey\MiniJournal\Entity\Article;
use MagicMonkey\MiniJournal\RepositoryBd\ImageBd;

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
            ->add('content', new NotBlank())
            ->add('chapo', new NotBlank())
            ->add('publication_status', new NotBlank())
            ->add('publication_status', new ValidValue(array("brouillon", "publie")))
            ->add('imageCheckboxes', new ValidObjects(ImageBd::class));
    }

    /**
     * Permet de nettoyer les données postées via un formulaire :
     * ajout de différents nettoyages sur différents champs
     */
    public function cleaningOptions()
    {
        $this->cleanerManager
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
