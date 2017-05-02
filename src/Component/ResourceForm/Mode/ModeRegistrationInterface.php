<?php

namespace MMC\User\Component\ResourceForm\Mode;

interface ModeRegistrationInterface extends ModeInterface
{
    public function getFormType():string;

    public function getBlockTemplate():string;
}
