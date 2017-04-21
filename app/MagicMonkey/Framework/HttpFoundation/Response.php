<?php

namespace MagicMonkey\Framework\HttpFoundation;

/**
 * Gère les données pour l'affichage (contenu, template, ..)
 * Class Response
 * @package MagicMonkey\Framework\HttpFoundation
 */
class Response
{
    /**
     * @var
     */
    protected $template;
    /**
     * @var
     */
    protected $lstFragments = array();

    /**
     * Constructeur
     * @param null $template
     * @param array $lstFragments
     */
    public function __contstuct($template = null, $lstFragments = array())
    {
        $this->template = $template;
        $this->lstFragments = $lstFragments;
    }

    /**
     * Permet d'ajouter un élément au tableau $lstFragments
     * @param $key
     * @param $value
     * @return bool
     */
    public function addOneFragment($key, $value)
    {
        if (isset($this->lstFragments)) {
            if (array_key_exists($key, $this->lstFragments)) {
                return false;
            } else {
                $this->lstFragments[$key] = $value;
            }
        }
        return false;
    }

    /**
     * Permet de supprimer un élément au tableau $lstFragments
     * @param $key
     * @return bool
     */
    public function deleteOneFragment($key)
    {
        if (array_key_exists($this->lstFragments, $key)) {
            unset($this->lstFragments[$key]);
        } else {
            return false;
        }
    }

    /**
     * Permet d'éditer un élément du tableau $lstFragements
     * @param $key
     * @param $value
     * @return bool
     */
    public function updateOneFragment($key, $value)
    {
        if (array_key_exists($this->lstFragments, $key)) {
            $this->lstFragments[$key] = $value;
        } else {
            return false;
        }
    }

    /**
     * Permet de retourner un élément du tableau lstFragments.
     * @param $key
     * @return bool
     */
    public function getOneFragment($key)
    {
        return !empty($this->lstFragments[$key]) ? $this->lstFragments[$key] : false;
    }

    /* ### GETTERS & SETTERS ### */

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

    /**
     * @param $array
     */
    public function setLstFragments($array)
    {
        $this->lstFragments = $array;
    }

    /**
     * @return mixed
     */
    public function getLstFragments()
    {
        return $this->lstFragments;
    }
}
