<?php

namespace MMC\User\Bundle\EmailBundle\Services;

use Doctrine\ORM\EntityManager;
use MMC\User\Bundle\EmailBundle\Entity\EmailFormAuthentication;
use MMC\User\Component\Security\CodeGenerator\CodeGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationCodeManager implements AuthenticationCodeManagerInterface
{
    public function __construct(
        EntityManager $em,
        CodeGeneratorInterface $codeGenerator
    ) {
        $this->em = $em;
        $this->codeGenerator = $codeGenerator;
    }

    public function generate(UserInterface $user)
    {
        $code = $this->codeGenerator->generate();

        $user->setCode($code);

        $this->em->persist($user);
        $this->em->flush();

        return $code;
    }

    public function check(UserInterface $user, $code, $test = false)
    {
        if ($this->em->getRepository(EmailFormAuthentication::class)->findOneBy(['user' => $user, 'code' => $code])) {
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
