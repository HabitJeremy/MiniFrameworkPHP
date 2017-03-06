<?php

namespace MagicMonkey\MiniJournal\RepositoryForm;

use MagicMonkey\Framework\Inheritance\AbstractForm;
use MagicMonkey\Framework\Validator\Type\MaxLength;
use MagicMonkey\Framework\Validator\Type\NotBlank;
use MagicMonkey\MiniJournal\Entity\Image;
use MagicMonkey\Framework\Validator\Type\ImageFile;

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
     * ajout de différentes validations sur différents champ
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
