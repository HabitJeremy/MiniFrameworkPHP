<?php

namespace MagicMonkey\Framework\Inheritance\Entity\Type;

use MagicMonkey\Framework\Inheritance\Entity\AbstractEntity;

abstract class AbstractFileEntity extends AbstractEntity
{
    protected $path;

    protected function __construct($id, $path)
    {
        parent::__construct($id);
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }
}
