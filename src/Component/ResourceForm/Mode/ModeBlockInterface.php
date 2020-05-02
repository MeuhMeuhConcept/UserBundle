<?php

namespace MMC\User\Component\ResourceForm\Mode;

interface ModeBlockInterface extends ModeInterface
{
    public function getFormType():string;

    public function getBlockTemplate():string;
}
