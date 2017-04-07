<?php

namespace MMC\User\Bundle\ResourceFormBundle\Services\SenderProcessor;

use MMC\User\Bundle\ResourceFormBundle\Entity\ResourceFormAuthentication;
use Mmc\Processor\Component\Processor;
use Mmc\Processor\Component\Request;
use Mmc\Processor\Component\Response;
use Mmc\Processor\Component\ResponseStatusCode;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailerSenderProcessor implements Processor
{
    public function __construct(
        \Swift_Mailer $mailer,
        $sender
    ) {
        $this->mailer = $mailer;
        $this->sender = $sender;
    }

    public function supports(Request $request)
    {
        $input = $request->getInput();

        $resolver = new OptionsResolver();

        $resolver->setDefaults(array(
            'name' => null,
            'type' => null,
            'resource' => null,
            'subject' => null,
            'content' => null,
        ));

        $resolver->setAllowedTypes('name', ['null', 'string']);
        $resolver->setAllowedTypes('type', ['null', 'string']);
        $resolver->setAllowedTypes('resource', ['null', ResourceFormAuthentication::class]);
        $resolver->setAllowedTypes('subject', ['null', 'string']);
        $resolver->setAllowedTypes('content', ['null', HttpResponse::class]);

        // With the $request you have to decide if this processor can do the job
        // You can use the input to do this
        // Don't forget to check the 'expectedOuput', if this processor can't
        // produce that object you have to return false
        $expectedOuput = $request->getExpectedOutput();

        return true;
    }

    public function process(Request $request)
    {
        // Advice : check the method 'supports'
        if (!$this->supports($request)) {
            return new Response($request, null, ResponseStatusCode::NOT_SUPPORTED);
        }

        $input = $request->getInput();

        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom($this->sender)
            ->setReplyTo($this->sender)
            ->setTo($input['resource']->getResource())
            ->setSubject($input['subject'])
            ->setBody($input['content'])
            ->setContentType('text/html');

        $output = $this->mailer->send($mail);

        // and return the Response

        return new Response($request, $output); // $output had been create during the job was doing
    }
}
