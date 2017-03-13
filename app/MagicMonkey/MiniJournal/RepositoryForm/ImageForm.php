<?php

namespace MagicMonkey\MiniJournal\RepositoryForm;

use MagicMonkey\Framework\Cleaner\CleanerList\Nl2br;
use MagicMonkey\Framework\Cleaner\CleanerList\StripTags;
use MagicMonkey\Framework\Cleaner\CleanerList\Trim;
use MagicMonkey\Framework\Inheritance\AbstractForm;
use MagicMonkey\Framework\Validator\ValidatorList\MaxLength;
use MagicMonkey\Framework\Validator\ValidatorList\NotBlank;
use MagicMonkey\MiniJournal\Entity\Image;
use MagicMonkey\Framework\Validator\ValidatorList\ImageFile;

/**
 * Class ImageForm
 * @package MagicMonkey\MiniJournal\RepositoryForm
 */
class ImageForm extends AbstractForm
{
    /**
     * @var Image
     */
    protected $image;

    /**
     * ImageForm constructor.
     */
    public function __construct()
    {
        parent::__construct("image");
        $this->image = new Image();
    }

    /**
     * Permet de vérifier les données postées via un formulaire :
     * ajout de différentes validations sur différents champs
     */
    public function validationOptions()
    {
        $this->validatorManager
            ->add('name', new NotBlank())
            ->add('name', new MaxLength(255))
            ->add('attr_alt', new NotBlank())
            ->add('attr_alt', new MaxLength(255))
            ->add('file', new ImageFile());
    }

    public function cleaningOptions()
    {
        $this->cleanerManager
            ->add('name', new StripTags())
            ->add('name', new Trim())
            ->add('name', new Nl2br())
            ->add('path', new StripTags())
            ->add('path', new Trim())
            ->add('path', new Nl2br())
            ->add('attr_alt', new StripTags())
            ->add('attr_alt', new Trim())
            ->add('attr_alt', new Nl2br());
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
}
