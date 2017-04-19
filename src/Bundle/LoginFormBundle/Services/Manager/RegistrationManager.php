<?php

namespace MMC\User\Bundle\LoginFormBundle\Services\Manager;

use Doctrine\ORM\EntityManager;
use MMC\User\Bundle\UserBundle\Entity\LoginFormAuthenticator;
use MMC\User\Bundle\UserBundle\Services\Manager\UserManagerInterface;
use MMC\User\Component\Security\CodeGenerator\CodeGeneratorInterface;

class RegistrationManager
{
    protected $em;

    protected $tokenGenerator;

    protected $userManager;

    public function __construct(
        EntityManager $em,
        CodeGeneratorInterface $codeGenerator,
        UserManagerInterface $userManager
    ) {
        $this->em = $em;
        $this->codeGenerator = $codeGenerator;
        $this->userManager = $userManager;
    }

    public function create($loginFormAuthenticator)
    {
        $user = $this->userManager->create();

        $token = $this->codeGenerator->generate();

        $loginFormAuthenticator->setUser($user)
            ->setConfirmationToken($token)
            ->setEnabled(false)
        ;

        $this->em->persist($loginFormAuthenticator);
        $this->em->flush();

        return $loginFormAuthenticator;
    }

    public function findUserBy(array $criteria)
    {
        return $this->em->getRepository(LoginFormAuthenticator::class)->findOneBy($criteria);
    }

    public function findUserByConfirmationToken($token)
    {
        return $this->findUserBy(['confirmationToken' => $token]);
    }

    public function activateUser($user)
    {
        $user->setConfirmationToken(null)
            ->setEnabled(true)
        ;

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
