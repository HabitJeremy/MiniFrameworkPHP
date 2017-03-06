<?php

namespace MagicMonkey\Framework\InterfaceRepository;

/**
 * Interface EntityInterface
 * @package MagicMonkey\Framework\InterfaceRepository
 */
interface EntityInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id);
}
