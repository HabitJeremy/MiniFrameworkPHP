<?php

namespace MagicMonkey\Framework\HttpFoundation;

class Request
{
    private $post;
    private $get;
    private $files;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->post = $_POST;
        $this->get = $_GET;
        $this->files = $_FILES;
    }

    /**
     * @param $key : la clé à chercher dans GET
     * @param $default:  la valeur à renvoyer si $key n'existe pas
     * @return null
     */
    public function getGetParam($key, $default = null)
    {
        if (!isset($this->get[$key])) {
            return $default;
        }
        return $this->get[$key];
    }

    public function getFilesParam($key, $default = null)
    {
        if (!isset($this->files[$key])) {
            return $default;
        }
        return $this->files[$key];
    }

    /**
     * @param $key : la clé à chercher dans POST
     * @param $default : la valeur à renvoyer si $key n'existe pas
     * @return null
     */
    public function getPostParam($key, $default)
    {
        if (!isset($this->post[$key])) {
            return $default;
        }
        return $this->post[$key];
    }

    public function addPostParam($key, $value){
        if(!isset($this->post[$key])){
            $this->post[$key] = $value;
            return true;
        }
        return false;
    }

    public function addFilesParam($key, $value){
        if(!isset($this->files[$key])){
            $this->files[$key] = $value;
            return true;
        }
        return false;
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

    public function getFiles(){
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

    public function setFiles($files){
        $this->files = $files;
    }
}
