<?php

namespace MMC\User\Bundle\ResourceFormBundle\Services;

use Doctrine\ORM\EntityManager;
use MMC\User\Bundle\ResourceFormBundle\Entity\ResourceFormAuthentication;
use MMC\User\Bundle\ResourceFormBundle\Entity\ResourceFormAuthenticationInterface;
use MMC\User\Component\Security\CodeGenerator\CodeGeneratorInterface;

class AuthenticationCodeManager implements AuthenticationCodeManagerInterface
{
    public function __construct(
        EntityManager $em,
        CodeGeneratorInterface $codeGenerator
    ) {
        $this->em = $em;
        $this->codeGenerator = $codeGenerator;
    }

    public function generate(ResourceFormAuthenticationInterface $user)
    {
        $code = $this->codeGenerator->generate();

        $user->setCode($code);

        $this->em->persist($user);
        $this->em->flush();

        return $code;
    }

    public function check(ResourceFormAuthenticationInterface $user, $code, $test = false)
    {
        if ($this->em->getRepository(ResourceFormAuthentication::class)->findOneBy(['user' => $user, 'code' => $code])) {
            $user->getEmailFormAuthenticator()->setIsChecked(true)
                ->setCode(null)
            ;

            $this->em->persist($user);
            $this->em->flush();

            return true;
        } else {
            return false;
        }
    }
}
