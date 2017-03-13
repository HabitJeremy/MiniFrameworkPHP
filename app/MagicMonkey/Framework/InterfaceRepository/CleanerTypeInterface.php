<?php

namespace MagicMonkey\Framework\InterfaceRepository;

/**
 * Interface CleanerTypeInterface
 * @package MagicMonkey\Framework\InterfaceRepository
 */
interface CleanerTypeInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function clean($value);
}
