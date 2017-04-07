<?php

namespace MMC\User\Component\ResourceForm\Mode;

class ModeRender implements ModeRenderInterface
{
    public function __construct(
        $name,
        $type,
        $renderTemplate
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->renderTemplate = $renderTemplate;
    }

    public function getName():string
    {
        return $this->name;
    }

    public function getType():string
    {
        return $this->type;
    }

    public function getRenderTemplate():string
    {
        return $this->renderTemplate;
    }
}
