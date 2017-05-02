<?php

namespace MMC\User\Bundle\UserBundle\Controller;

use MMC\User\Bundle\UserBundle\Services\RegistrationBlock\ChainRegistrationBlock;
use Symfony\Component\Templating\EngineInterface;

class RegistrationController
{
    protected $templating;
    protected $chainRegistrationBlocks;

    public function __construct(
        EngineInterface $templating,
        ChainRegistrationBlock $chainRegistrationBlocks
    ) {
        $this->templating = $templating;
        $this->chainRegistrationBlocks = $chainRegistrationBlocks;
    }

    public function registerAction()
    {
        return $this->templating->renderResponse(
            'MMCUserBundle:Registration:index.html.twig',
            [
                'chainRegistrationBlocks' => $this->chainRegistrationBlocks,
            ]
        );
    }
}
