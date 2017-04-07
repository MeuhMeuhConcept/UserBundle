<?php

namespace MMC\User\Component\ResourceForm\Mode;

class ModeBlock implements ModeBlockInterface
{
    public function __construct(
        $name,
        $type,
        $formType,
        $blockTemplate
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->formType = $formType;
        $this->blockTemplate = $blockTemplate;
    }

    public function getName():string
    {
        return $this->name;
    }

    public function getType():string
    {
        return $this->type;
    }

    public function getFormType():string
    {
        return $this->formType;
    }

    public function getBlockTemplate():string
    {
        return $this->blockTemplate;
    }
}
