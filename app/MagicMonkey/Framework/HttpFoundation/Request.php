<?php

namespace MagicMonkey\Framework\HttpFoundation;

/**
 * Gère les données envoyées au serveur
 * Class Request
 * @package MagicMonkey\Framework\HttpFoundation
 */
/**
 * Class Request
 * @package MagicMonkey\Framework\HttpFoundation
 */
/**
 * Class Request
 * @package MagicMonkey\Framework\HttpFoundation
 */
class Request
{
    /**
     * @var
     */
    private $post;
    /**
     * @var
     */
    private $get;
    /**
     * @var
     */
    private $files;

    /**
     * @var
     */
    private $session;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->post = $_POST;
        $this->get = $_GET;
        $this->files = $_FILES;
        $this->session = $_SESSION;
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function addSessionParam($key, $value)
    {
        if (!isset($this->session[$key])) {
            $this->session[$key] = $value;
            return true;
        }
        return false;
    }

    /**
     * @param $key
     */
    public function removeSessionParam($key)
    {
        if (isset($this->session[$key])) {
            unset($this->session[$key]);
        }
    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public function getSessionParam($key, $default = null)
    {
        if (!isset($this->session[$key])) {
            return $default;
        }
        return $this->session[$key];
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function updateSessionParam($key, $value)
    {
        if (isset($this->session[$key])) {
            $this->session[$key] = $value;
            return true;
        }
        return false;
    }

    /**
     * Retourne un élement du tableau $_GET
     * @param $key : la clé à chercher dans GET
     * @param $default :  la valeur à renvoyer si $key n'existe pas
     * @return null
     */
    public function getGetParam($key, $default = null)
    {
        if (!isset($this->get[$key])) {
            return $default;
        }
        return $this->get[$key];
    }

    /**
     * Retourne un élément du tableau $_FILEs
     * @param $key
     * @param null $default
     * @return null
     */
    public function getFilesParam($key, $default = null)
    {
        if (!isset($this->files[$key])) {
            return $default;
        }
        return $this->files[$key];
    }

    /**
     * Retourne un élément du tableau $_POST
     * @param $key
     * @param $default
     * @return mixed
     */
    public function getPostParam($key, $default = null)
    {
        if (!isset($this->post[$key])) {
            return $default;
        }
        return $this->post[$key];
    }

    /**
     * Permet d'ajouter un élément au tableau $_POST
     * @param $key
     * @param $value
     * @return bool
     */
    public function addPostParam($key, $value)
    {
        if (!isset($this->post[$key])) {
            $this->post[$key] = $value;
            return true;
        }
        return false;
    }

    /**
     * Détermine si la requête est envoyée par http ou xhr
     * @return bool
     */
    public function isXhrRequest()
    {
        return (isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');
    }

    /**
     * Permet de supprimer un élément du tableau $_POST
     * @param $key
     */
    public function removePostParam($key)
    {
        if (isset($this->post[$key])) {
            unset($this->post[$key]);
        }
    }

    /**
     * Permet d'ajouter un élément au tableau $_FILES
     * @param $key
     * @param $value
     * @return bool
     */
    public function addFilesParam($key, $value)
    {
        if (!isset($this->files[$key])) {
            $this->files[$key] = $value;
            return true;
        }
        return false;
    }

    /* ### GETTERS & SETTERS ### */

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param mixed $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @return mixed
     */
    public function getGet()
    {
        return $this->get;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @param mixed $get
     */
    public function setGet($get)
    {
        $this->get = $get;
    }

    /**
     * @param $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }
}
