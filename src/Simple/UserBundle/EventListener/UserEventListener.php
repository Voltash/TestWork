<?php

namespace Simple\UserBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class UserEventListener implements EventSubscriberInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router) {
        $this->router = $router;
    }
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInit',
            FOSUserEvents::REGISTRATION_SUCCESS => 'onConfirmed'
        );
    }

    /**
     * take action when registration is initialized
     * set the username to a unique id
     * @param \FOS\UserBundle\Event\UserEvent $userEvent
     */
    public function onRegistrationInit(UserEvent $userEvent)
    {
        $user = $userEvent->getUser();
        $user->setUsername(uniqid());
    }

    public function onConfirmed(FormEvent $event) {
        $url = $this->router->generate('simple_test_site_homepage');
        $event->setResponse(new RedirectResponse($url));
    }


}