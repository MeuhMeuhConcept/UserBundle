<?php

namespace MMC\User\Component\Model;

abstract class User implements UserInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
}
