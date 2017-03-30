<?php

namespace MMC\User\Bundle\EmailBundle\Services;

use Doctrine\ORM\EntityManager;
use MMC\User\Bundle\EmailBundle\Entity\EmailFormAuthenticator;
use MMC\User\Component\Security\CodeGenerator;
use MMC\User\Component\Security\SimpleCodeGenerator;

class EmailFormManager
{
    protected $em;
    protected $codeGenerator;
    protected $simpleCodeGenerator;

    public function __construct(
        EntityManager $em,
        CodeGenerator $codeGenerator,
        SimpleCodeGenerator $simpleCodeGenerator
    ) {
        $this->em = $em;
        $this->codeGenerator = $codeGenerator;
        $this->simpleCodeGenerator = $simpleCodeGenerator;
    }

    public function findUserBy(array $criteria)
    {
        return $this->em->getRepository(EmailFormAuthenticator::class)->findOneBy($criteria);
    }

    public function findUserByEmail($email)
    {
        return $this->findUserBy(['email' => $email]);
    }

    public function findUserByEmailRequestToken($token)
    {
        return $this->findUserBy(['emailRequestToken' => $token]);
    }

    public function emailWithTokenRequest($user)
    {
        $token = $this->codeGenerator->generateUuidToken();

        $user->setEmailRequestToken($token);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function emailWithCodeRequest($user)
    {
        $code = $this->simpleCodeGenerator->generate();

        $user->setEmailRequestCode($code);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function resetToken($user)
    {
        $user->setEmailRequestToken(null);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function resetCode($user)
    {
        $user->setEmailRequestCode(null);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function create($emailFormAuthenticator)
    {
        $user = $this->createUser();

        $emailFormAuthenticator->setUser($user)
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

    public function isCodeValid($user, $code)
    {
        $user = $user->getUser()->getId();
        $code = $this->codeGenerator->encode($user, $code);

        return $this->findUserByCodeRequest($user, $code);
    }

    public function findUserByCodeRequest($user, $code)
    {
        return $this->findUserBy(['user' => $user, 'emailRequestCode' => $code]);
    }
}
