<?php

namespace MMC\User\Bundle\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

interface UserInterface extends BaseUserInterface
{
    /**
     * Get id.
     *
     * @return int
     */
    public function getId();
}
