<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MMC\User\Bundle\UserBundle\Entity\LoginFormAuthenticator as BaseLoginFormAuthenticator;

/**
 * @ORM\Entity
 */
class LoginFormAuthenticator extends BaseLoginFormAuthenticator
{

}
