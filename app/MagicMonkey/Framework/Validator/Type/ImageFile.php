<?php

namespace MagicMonkey\Framework\Validator\Type;

use MagicMonkey\Framework\Inheritance\AbstractValidator;
use MagicMonkey\Framework\InterfaceRepository\ValidatorTypeInterface;

/**
 * Permet de valider une valeur en tant qu'image
 * Class ImageFile
 * @package MagicMonkey\Framework\Validator\Type
 */
class ImageFile extends AbstractValidator implements ValidatorTypeInterface
{
    /**
     * @var int
     */
    private $maxSize;

    /**
     * ImageFile constructor.
     * @param int $maxSize
     * @param null $message
     */
    public function __construct($maxSize = 2097152, $message = null)
    {
        parent::__construct($message);
        $this->maxSize = $maxSize;
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        if (count($value) != 0) {
            if (isset($value[1]) && $value[1] === false) {
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

    /**
     * @param string $msg
     */
    protected function setMessage($msg = "Ce n'est pas une image valide")
    {
        $this->message = $msg;
    }
}
