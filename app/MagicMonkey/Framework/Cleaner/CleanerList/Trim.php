<?php

namespace MagicMonkey\Framework\Cleaner\CleanerList;

use MagicMonkey\Framework\InterfaceRepository\CleanerTypeInterface;

/**
 * Permet de supprimer les espaces (ou d'autres caractères) en début et fin de chaîne
 * Class Trim
 * @package MagicMonkey\Framework\Cleaner\CleanerList
 */
class Trim implements CleanerTypeInterface
{
    /**
     * @param $value
     * @return bool|string
     */
    public function clean($value)
    {
        if ($value != null) {
            return trim($value);
        }
        return false;
    }
}
