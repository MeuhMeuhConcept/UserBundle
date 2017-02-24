<?php

namespace MMC\User\Bundle\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateLoginFormAuthenticatorCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('mmc:user:create')
            ->setDescription('Create a user.')
            ->setDefinition([
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
            ])
            ->setHelp('This command allows you to create users...')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '<comment>',
            ' ===========================',
            ' Welcome to MMC User Creator',
            ' ===========================',
            '</comment>',
        ]);

        $questions = [];

        if (!$input->getArgument('email')) {
            $question = new Question('<info>Please choose an email:</info>');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Email can not be empty');
                }
                if (!$this->validEmail($email)) {
                    throw new \Exception('Email not valid');
                }

                return $email;
            });
            $questions['email'] = $question;
        }

        if (!$input->getArgument('password')) {
            $question = new Question('<info>Please choose a password:</info>');
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception('Password can not be empty');
                }

                return $password;
            });
            $question->setHidden(true);
            $questions['password'] = $question;
        }

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // access the container using getContainer()
        $userManager = $this->getContainer()->get('mmc_user.component.doctrine.registration_manager');

        if ($userManager->createCommand($input->getArgument('email'), $input->getArgument('password'))) {
            $output->writeln('User successfully generated!');
        }
    }

    public function validEmail($email)
    {
        $isValid = true;
        $atIndex = strrpos($email, '@');
        if (is_bool($atIndex) && !$atIndex) {
            $isValid = false;
        } else {
            $domain = substr($email, $atIndex + 1);
            $local = substr($email, 0, $atIndex);
            $localLen = strlen($local);
            $domainLen = strlen($domain);
            if ($localLen < 1 || $localLen > 64) {
                $isValid = false;
            } elseif ($domainLen < 1 || $domainLen > 255) {
                $isValid = false;
            } elseif ($local[0] == '.' || $local[$localLen - 1] == '.') {
                $isValid = false;
            } elseif (preg_match('/\\.\\./', $local)) {
                $isValid = false;
            } elseif (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
                $isValid = false;
            } elseif (preg_match('/\\.\\./', $domain)) {
                $isValid = false;
            } elseif (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace('\\\\', '', $local))) {
                if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace('\\\\', '', $local))) {
                    $isValid = false;
                }
            }
        }

        return $isValid;
    }
}
