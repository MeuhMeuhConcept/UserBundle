<?php

namespace MMC\User\Component\Doctrine;

use Doctrine\ORM\EntityManager;
use MMC\User\Bundle\UserBundle\Entity\LoginFormAuthenticator;
use MMC\User\Bundle\UserBundle\Entity\User;
use MMC\User\Component\Security\CodeGenerator\CodeGeneratorInterface;

class RegistrationManager
{
    protected $em;

    protected $tokenGenerator;

    public function __construct(
        EntityManager $em,
        CodeGeneratorInterface $codeGenerator
    ) {
        $this->em = $em;
        $this->codeGenerator = $codeGenerator;
    }

    public function create($loginFormAuthenticator)
    {
        dump($loginFormAuthenticator);
        $user = $this->createUser();

        $token = $this->codeGenerator->generate();

        $loginFormAuthenticator->setUser($user)
            ->setConfirmationToken($token)
            ->setEnabled(false)
        ;

        $this->em->persist($loginFormAuthenticator);
        $this->em->flush();

        return $loginFormAuthenticator;
    }

    public function createUser()
    {
        $user = new User();

        $this->em->persist($user);
        $this->em->flush();

        return $user;
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
