<?php

namespace MMC\User\Bundle\ResourceFormBundle\Entity;

interface ResourceFormAuthenticationInterface
{
    public function getResource();

    public function getType();

    public function getIsChecked();

    public function getCode();
}
