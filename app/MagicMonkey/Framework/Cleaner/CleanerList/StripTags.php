<?php

namespace MagicMonkey\Framework\Cleaner\CleanerList;

use MagicMonkey\Framework\InterfaceRepository\CleanerTypeInterface;

/**
 * Permet de supprimer les balises HTML et PHP d'une valeur
 * Class Trim
 * @package MagicMonkey\Framework\Cleaner\CleanerList
 */
class StripTags implements CleanerTypeInterface
{
    /**
     * @param $value
     * @return bool|string
     */
    public function clean($value)
    {
        if ($value != null) {
            return strip_tags($value);
        }
        return false;
    }
}
