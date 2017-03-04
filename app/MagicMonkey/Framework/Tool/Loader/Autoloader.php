<?php

namespace MagicMonkey\Framework\Tool\Loader;

class Autoloader
{
    /**
     * Méthod pour inclure le fichier de la classe $className.
     *
     * @param string $className le nom de la classe à charger
     */
    public static function load($className)
    {
        $path = str_replace('\\', DS, $className);
        $fullPath = APP_BASEFILE . DS . $path . '.php';
        include($fullPath);
    }
}
