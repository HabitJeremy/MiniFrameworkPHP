<?php

namespace MagicMonkey\Framework\Cleaner\CleanerList;

use MagicMonkey\Framework\InterfaceRepository\CleanerTypeInterface;

/**
 * Permet d'insèrer un retour à la ligne HTML à chaque nouvelle ligne d'une chaîne
 * Class Trim
 * @package MagicMonkey\Framework\Cleaner\CleanerList
 */
class Nl2br implements CleanerTypeInterface
{
    /**
     * @param $value
     * @return bool|string
     */
    public function clean($value)
    {
        if ($value != null) {
            return nl2br($value);
        }
        return false;
    }
}
