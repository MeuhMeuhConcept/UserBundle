<?php

namespace MMC\User\Bundle\ResourceFormBundle\Services\Manager;

use Doctrine\ORM\EntityManager;
use MMC\User\Bundle\ResourceFormBundle\Entity\ResourceFormAuthentication;
use MMC\User\Bundle\UserBundle\Services\Manager\UserManagerInterface;
use MMC\User\Component\Security\CodeGenerator\CodeGeneratorInterface;

class RegistrationManager
{
    protected $em;

    protected $codeGenerator;

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

    public function create($resourceForm, $type)
    {
        $user = $this->userManager->create();

        $code = $this->codeGenerator->generate();

        $resourceForm->setUser($user)
                ->setType($type)
                ->setCode($code)
                ->setIsChecked(false)
            ;

        $this->em->persist($resourceForm);
        $this->em->flush();

        return $resourceForm;
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
