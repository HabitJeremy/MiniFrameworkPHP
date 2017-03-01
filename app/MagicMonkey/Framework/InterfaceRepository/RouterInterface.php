<?php

namespace MagicMonkey\Framework\InterfaceRepository;

interface RouterInterface
{
    public function getControllerClassName();

    public function getControllerAction();
}
