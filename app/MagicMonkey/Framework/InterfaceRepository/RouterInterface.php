<?php

namespace MagicMonkey\Framework\InterfaceRepository;

/**
 * Interface RouterInterface
 * @package MagicMonkey\Framework\InterfaceRepository
 */
interface RouterInterface
{
    /**
     * @return mixed
     */
    public function getControllerClassName();

    /**
     * @return mixed
     */
    public function getControllerAction();
}
