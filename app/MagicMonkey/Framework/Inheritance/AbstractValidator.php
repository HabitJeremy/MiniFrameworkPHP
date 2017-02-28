<?php

namespace MagicMonkey\Framework\Inheritance;

/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 24/02/2017
 * Time: 10:11
 */
abstract class AbstractValidator
{
    protected $message;

    abstract protected function setMessage();

    public function __construct($message = null)
    {
        if ($message === null) {
            $this->setMessage();
        } else {
            $this->message = $message;
        }
    }

    public function getMessage()
    {
        return $this->message;
    }
}
