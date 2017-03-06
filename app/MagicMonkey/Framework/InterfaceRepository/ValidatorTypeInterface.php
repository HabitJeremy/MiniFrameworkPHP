<?php

namespace MagicMonkey\Framework\InterfaceRepository;

/**
 * Interface ValidatorTypeInterface
 * @package MagicMonkey\Framework\InterfaceRepository
 */
interface ValidatorTypeInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function validate($value);

    /**
     * @return mixed
     */
    public function getMessage();
}
