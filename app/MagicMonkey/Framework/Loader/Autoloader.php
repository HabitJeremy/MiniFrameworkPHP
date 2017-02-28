<?php

namespace MagicMonkey\Framework\Loader;

class Autoloader
{
    /**
     * Méthod pour inclure le fichier de la classe $className.
     *
     * @param string $className le nom de la classe à charger
     */
    public static function load($className)
    {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $fullPath = APP_BASEFILE . DIRECTORY_SEPARATOR . $path . '.php';
        include($fullPath);
    }
}
