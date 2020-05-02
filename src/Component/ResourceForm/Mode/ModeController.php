<?php

namespace MMC\User\Component\ResourceForm\Mode;

class ModeController implements ModeControllerInterface
{
    public function __construct(
        $name,
        $type,
        $formType,
        $messageSubject,
        $messageTemplate,
        $blockTemplate
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->formType = $formType;
        $this->messageSubject = $messageSubject;
        $this->messageTemplate = $messageTemplate;
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

    public function getMessageSubject():string
    {
        return $this->messageSubject;
    }

    public function getMessageTemplate():string
    {
        return $this->messageTemplate;
    }

    public function getBlockTemplate():string
    {
        return $this->blockTemplate;
    }
}
