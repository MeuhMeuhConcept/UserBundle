<?php

namespace MMC\User\Bundle\ResourceFormBundle\Services;

use Doctrine\ORM\EntityManager;
use MMC\User\Bundle\ResourceFormBundle\Entity\ResourceFormAuthentication;
use MMC\User\Component\ResourceForm\Model\ResourceFormAuthenticationInterface;
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

    public function generate(ResourceFormAuthenticationInterface $resourceForm)
    {
        $code = $this->codeGenerator->generate();

        $resourceForm->setCode($code);

        $this->em->persist($resourceForm);
        $this->em->flush();

        return $code;
    }

    public function check(UserInterface $resource, $code, $test = false)
    {
        if ($this->em->getRepository(ResourceFormAuthentication::class)->findOneBy(['id' => $resource, 'code' => $code])) {
            $resource->setIsChecked(true)
                ->setCode(null)
            ;

            $this->em->persist($resource);
            $this->em->flush();

            return true;
        } else {
            return false;
        }
    }
}
