<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MMC\User\Bundle\EmailBundle\Entity\EmailFormAuthentication as BaseEmailFormAuthentication;

/**
 * @ORM\Entity
 */
class EmailFormAuthentication extends BaseEmailFormAuthentication
{

}
