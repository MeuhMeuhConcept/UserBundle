<?php

namespace MMC\User\Component\ResourceForm\Mode;

interface ModeRenderInterface extends ModeInterface
{
    public function getRenderTemplate():string;
}
