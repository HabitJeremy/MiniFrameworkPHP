<?php

namespace MagicMonkey\Tools\Request;

/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 10/02/2017
 * Time: 11:10
 */
class Request
{
    private $post;
    private $get;

    /**
     * Request constructor.
     * @param $post
     * @param $get
     */
    public function __construct($post, $get)
    {
        $this->post = $post;
        $this->get = $get;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return mixed
     */
    public function getGet()
    {
        return $this->get;
    }

    /**
     * @param mixed $get
     */
    public function setGet($get)
    {
        $this->get = $get;
    }
}
