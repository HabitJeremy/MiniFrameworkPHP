<?php

namespace MagicMonkey\Framework\HttpFoundation;

class Response
{
    protected $template;
    protected $lstFragments;

    public function __contstuct($template = null, $lstFragments = array())
    {
        $this->template = $template;
        $this->lstFragments = $lstFragments;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function addOneFragment($key, $value)
    {
        if (array_key_exists($key, $this->lstFragments)) {
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
