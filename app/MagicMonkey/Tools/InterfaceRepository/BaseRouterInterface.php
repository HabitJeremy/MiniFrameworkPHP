<?php

namespace MagicMonkey\Tools\InterfaceRepository;

/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 24/02/2017
 * Time: 10:19
 */
interface BaseRouterInterface
{
    public function getControllerClassName();

    public function getControllerAction();
}
