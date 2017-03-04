<?php

namespace MagicMonkey\Framework\Validator\Type;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

class ImageFile extends AbstractValidator implements ValidatorTypeInterface
{
    private $maxSize;

    public function __construct($maxSize = 2097152, $message = null)
    {
        parent::__construct($message);
        $this->maxSize = $maxSize;
    }

    public function validate($value)
    {
        if (count($value) != 0) {
            if (isset($value[1]) && $value[1] === FALSE) {
                $this->message = "Aucun fichier sélectionné ou le fichier n'est pas une image";
                return false;
            }
            if (isset($value[0]) && $value[0]['size'] > $this->maxSize) {
                $this->message = "Le poids de l'image ne dois pas dépasser " . $this->maxSize . " octets";
                return false;
            }
            return true;
        }
        return false;
    }

    protected function setMessage($msg = "Ce n'est pas une image valide")
    {
        $this->message = $msg;
    }
}
