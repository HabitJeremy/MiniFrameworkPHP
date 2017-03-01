<?php

namespace MagicMonkey\Framework\Inheritance;

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
