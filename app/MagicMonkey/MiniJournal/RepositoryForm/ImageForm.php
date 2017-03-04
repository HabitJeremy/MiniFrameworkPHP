<?php

namespace MagicMonkey\MiniJournal\RepositoryForm;

use MagicMonkey\Framework\Inheritance\AbstractForm;
use MagicMonkey\Framework\Validator\Type\MaxLength;
use MagicMonkey\Framework\Validator\Type\NotBlank;
use MagicMonkey\MiniJournal\Entity\Image;
use MagicMonkey\Framework\Validator\Type\ImageFile;

class ImageForm extends AbstractForm
{
    protected $image;

    public function __construct()
    {
        parent::__construct("image");
        $this->image = new Image();
    }

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
