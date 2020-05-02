<?php

namespace MMC\User\Bundle\UserBundle\Controller;

use MMC\User\Bundle\UserBundle\Services\AuthenticatorBlock\ChainAuthenticatorBlock;
use Symfony\Component\Templating\EngineInterface;

class SecurityController
{
    protected $templating;
    protected $chainAuthenticatorBlocks;

    public function __construct(
        EngineInterface $templating,
        ChainAuthenticatorBlock $chainAuthenticatorBlocks
    ) {
        $this->templating = $templating;
        $this->chainAuthenticatorBlocks = $chainAuthenticatorBlocks;
    }

    public function loginAction()
    {
        return $this->templating->renderResponse(
            'MMCUserBundle:Security:login.html.twig',
            [
                'chainAuthenticatorBlocks' => $this->chainAuthenticatorBlocks,
            ]
        );
    }
}
