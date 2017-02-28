<?php

namespace MagicMonkey\Framework\InterfaceRepository;

/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 24/02/2017
 * Time: 10:19
 */
interface ValidatorTypeInterface
{
    public function validate($value);

    public function getMessage();
}
