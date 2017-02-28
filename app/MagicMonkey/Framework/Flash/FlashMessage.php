<?php

namespace MagicMonkey\Framework\Flash;

class FlashMessage
{
    /**
     * $instance est privée pour implémenter le pattern Singleton
     * et être sûr qu'il n'y a qu'une et une seule instance
     */
    private static $instance;

    /**
     * Méthode pour accéder à l'UNIQUE instance de la classe.
     *
     * @return l'instance du singleton
     */
    public static function getInstance()
    {
        session_start();
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /* Permet d'afficher tout les messages flash (notifications) en une seule ligne dans la vue */
    public function all($array)
    {
        $res = "";
        foreach ($array as $name) {
            $res .= self::One($name);
        }
        return $res;
    }

    /*
        * Permet d'afficher la valeur d'une variable de session puis de la détruire
        * Paramètres :
            *- $name : nom de la variable de session
            *- $input : détermine l'affichage de la variable de session
       */
    public function one($name, $input = false)
    {
        $res = "";
        if (!empty($_SESSION[$name])) {
            if ($input) {
                $res = $_SESSION[$name]; // variable de session de "valeur" pour les inputs
            } else {
                $boldText = self::getBoldText($name);
                // variable de session de notification
                $res = "<span class='msg-" . $name . " marg-10-bottom'>";
                $res .= "<span class='txt-b'>" . $boldText . "</span> : " . $_SESSION[$name] . "</span>";
            }
            unset($_SESSION[$name]); // destruction de la variabe de session
        }
        return $res;
    }


    /* Retourne le "titre" en gras pour les messages flash */
    private function getBoldText($class)
    {
        $boldText = "Notification";
        switch ($class) {
            case "success":
                $boldText = "Ok";
                break;
            case "error":
                $boldText = "Échec";
                break;
            case "warning":
                $boldText = "Attention";
                break;
            case "info":
                $boldText = "Info";
                break;
        }
        return $boldText;
    }
}
