<?php

namespace MMC\User\Component\User\Model;

abstract class User implements UserInterface
{
    protected $id;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId();
}