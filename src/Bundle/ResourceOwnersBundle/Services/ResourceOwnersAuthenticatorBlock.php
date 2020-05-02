<?php

namespace MMC\User\Bundle\ResourceOwnersBundle\Services;

use MMC\User\Bundle\UserBundle\Services\AuthenticatorBlock\AuthenticatorBlock;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Templating\EngineInterface;

class ResourceOwnersAuthenticatorBlock implements AuthenticatorBlock
{
    protected $isMain;
    protected $templating;
    protected $tokenManager;
    protected $resourceOwners;

    public function __construct(
        bool $isMain,
        EngineInterface $templating,
        CsrfTokenManagerInterface $tokenManager,
        array $resourceOwners
    ) {
        $this->isMain = $isMain;
        $this->templating = $templating;
        $this->tokenManager = $tokenManager;
        $this->resourceOwners = $resourceOwners;
    }

    public function render()
    {
        return $this->templating->render(
            'MMCResourceOwnersBundle:Security:resource_owners_block.html.twig',
            [
                'csrf_token' => $this->tokenManager->getToken('authenticate')->getValue(),
                'resourceOwners' => $this->resourceOwners,
            ]
        );
    }

    public function getIsMain()
    {
        return $this->isMain;
    }
}
