<?php

namespace MMC\User\Component\ResourceForm\Mode;

interface ModeControllerInterface extends ModeInterface
{
    public function getFormType():string;

    public function getMessageSubject():string;

    public function getMessageTemplate():string;

    public function getBlockTemplate():string;
}
