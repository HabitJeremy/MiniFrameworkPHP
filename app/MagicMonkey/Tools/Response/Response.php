<?php

namespace MagicMonkey\Tools\Response;

/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 10/02/2017
 * Time: 11:07
 */
class Response
{

    private $lstFragments;

    public function __contstuct()
    {
        $this->lstFragments = array();
    }

    public function addOneFragment($key, $value)
    {
        if (array_key_exists($this->lstFragments, $key)) {
            return false;
        } else {
            $this->lstFragments[$key] = $value;
        }
    }

    public function deleteOneFragment($key)
    {
        if (array_key_exists($this->lstFragments, $key)) {
            unset($this->lstFragments[$key]);
        } else {
            return false;
        }
    }

    public function updateOneFragment($key, $value)
    {
        if (array_key_exists($this->lstFragments, $key)) {
            $this->lstFragments[$key] = $value;
        } else {
            return false;
        }
    }

    public function setLstFragments($array)
    {
        $this->lstFragments = $array;
    }

    public function getLstFragments()
    {
        return $this->lstFragments;
    }

    public function getOneFragment($key)
    {
        return !empty($this->lstFragments[$key]) ? $this->lstFragments[$key] : false;
    }
}
