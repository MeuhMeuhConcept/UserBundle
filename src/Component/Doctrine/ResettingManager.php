<?php

namespace MMC\User\Component\Doctrine;

use Doctrine\ORM\EntityManager;
use MMC\User\Component\Security\TokenGenerator;

class ResettingManager
{
    protected $em;
    protected $tokenGenerator;

    public function __construct(
        EntityManager $em,
        TokenGenerator $tokenGenerator
    ) {
        $this->em = $em;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function findUserBy(array $criteria)
    {
        return $this->em->getRepository('MMC\User\Bundle\LoginBundle\Entity\LoginFormAuthenticator')->findOneBy($criteria);
    }

    public function findUserByEmail($email)
    {
        return $this->findUserBy(['email' => $email]);
    }

    public function findUserByPasswordRequestToken($token)
    {
        return $this->findUserBy(['passwordRequestToken' => $token]);
    }

    public function passwordRequest($user)
    {
        $token = $this->tokenGenerator->generateUuidToken();

        $user->setPasswordRequestToken($token);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function updatePassword($user, $password)
    {
        $user->setPlainPassword($password);
        $user->setPasswordRequestToken(null);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
