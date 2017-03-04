<?php

namespace MagicMonkey\Framework\Tool\Cleaner;

class Cleaner
{

    public function cleaningToInsert(&$array)
    {
        foreach ($array as $key => $value) {
            $array[$key] = nl2br(trim(strip_tags(htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false))));
        }
    }

    /* Nettoyage pour l'affichage */
    public function cleaningToDisplay(&$array)
    {
        foreach ($array as $key => $value) {
            $array[$key] = htmlentities($value);
        }
    }
}
