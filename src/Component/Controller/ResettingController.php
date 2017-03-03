<?php

namespace MMC\User\Component\Controller;

use MMC\User\Bundle\UserBundle\Form\ForgotPasswordFormType;
use MMC\User\Bundle\UserBundle\Form\ResettingFormType;
use MMC\User\Component\Doctrine\ResettingManager;
use MMC\User\Component\Mailer\MailerProcessor;
use MMC\User\Component\Security\LoginFormAuthenticator;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Templating\EngineInterface;

class ResettingController
{
    protected $router;
    protected $templating;
    protected $formFactory;
    protected $resettingManager;
    protected $securityAuthenticationGuardHandler;
    protected $loginFormAuthenticator;
    protected $mailerProcessor;

    public function __construct(
        RouterInterface $router,
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        ResettingManager $resettingManager,
        GuardAuthenticatorHandler $securityAuthenticationGuardHandler,
        LoginFormAuthenticator $loginFormAuthenticator,
        MailerProcessor $mailerProcessor
    ) {
        $this->router = $router;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->resettingManager = $resettingManager;
        $this->securityAuthenticationGuardHandler = $securityAuthenticationGuardHandler;
        $this->loginFormAuthenticator = $loginFormAuthenticator;
        $this->mailerProcessor = $mailerProcessor;
    }

    public function forgotPasswordAction(Request $request)
    {
        $form = $this->formFactory->create(ForgotPasswordFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->resettingManager->findUserByEmail($form->getData()->getEmail());

            if ($user != null) {
                $this->resettingManager->passwordRequest($user);
            } else {
                throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $token));
            }

            $this->mailerProcessor->sendResettingEmailMessage($user);

            return $this->templating->renderResponse('MMCUserBundle:Resetting:check_email.html.twig');
        }

        return $this->templating->renderResponse(
            'MMCUserBundle:Resetting:forgot_password.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    public function resettingAction(Request $request, $token)
    {
        $user = $this->resettingManager->findUserByPasswordRequestToken($token);

        if ($user != null) {
            $form = $this->formFactory->create(ResettingFormType::class);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $password = ($form->getData()->getPlainPassword());
                $this->resettingManager->updatePassword($user, $password);

                return $this->templating->renderResponse('MMCUserBundle:Resetting:confirmed.html.twig');
            }

            return $this->templating->renderResponse(
                'MMCUserBundle:Resetting:resetting.html.twig',
                [
                    'form' => $form->createView(),
                ]
            );
        } else {
            throw new NotFoundHttpException(sprintf('The user with token "%s" does not exist', $token));
        }
    }
}
