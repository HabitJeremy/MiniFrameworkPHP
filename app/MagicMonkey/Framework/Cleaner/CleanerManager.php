<?php

namespace MagicMonkey\Framework\Cleaner;

use MagicMonkey\Framework\InterfaceRepository\CleanerTypeInterface;

/**
 * Gère les types de nettoyeur et leur exécution
 * Class CleanerManager
 * @package MagicMonkey\Framework\Cleaner
 */
class CleanerManager
{
    /**
     * @var array
     */
    private $cleanersList = array();

    /**
     * Ajout d'un nettoyeur
     * @param $propriete
     * @param CleanerTypeInterface $cleaner
     * @return $this
     */
    public function add($propriete, CleanerTypeInterface $cleaner)
    {
        $this->cleanersList[] = [$propriete, $cleaner];
        return $this;
    }

    /**
     * Permet de nettoyer des valeurs selon les nettoyeurs demandés
     * @param $postedData
     * @return array
     */
    public function clean(&$postedData)
    {
        foreach ($this->cleanersList as $item) {
            $field = $item[0];
            $cleaner = $item[1];
            $postedData[$field] = $cleaner->clean($postedData[$field]);
        }
    }
}
