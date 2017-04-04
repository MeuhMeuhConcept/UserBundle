<?php

namespace MMC\User\Bundle\EmailBundle\Services;

use Doctrine\ORM\EntityManager;
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
}
