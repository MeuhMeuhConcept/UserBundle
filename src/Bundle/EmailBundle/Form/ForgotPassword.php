<?php

namespace MMC\User\Bundle\LoginBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;

class ForgotPassword
{
    /**
     * @var string
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    protected $email;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}
