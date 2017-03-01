<?php

namespace MagicMonkey\Framework\InterfaceRepository;

interface ValidatorTypeInterface
{
    public function validate($value);

    public function getMessage();
}
