<?php
/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 06/02/2017
 * Time: 14:27
 */

namespace MagicMonkey\Tools\Database;

class Cleaner
{

    /* Permet de nettoyer les données d'un tableau */
    public function cleanerArray(&$array)
    {
        foreach ($array as $key => $value) {
            $array[$key] = nl2br(htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false));
        }
    }
}
