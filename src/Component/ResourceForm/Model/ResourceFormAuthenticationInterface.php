<?php

namespace MMC\User\Component\ResourceForm\Model;

interface ResourceFormAuthenticationInterface
{
    public function getResource();

    public function getType();

    public function getIsChecked();

    public function getCode();
}
