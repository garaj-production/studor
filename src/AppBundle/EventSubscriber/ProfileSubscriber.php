<?php

namespace AppBundle\EventSubscriber;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProfileSubscriber implements EventSubscriberInterface
{
    /** @var UrlGeneratorInterface */
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FOSUserEvents::PROFILE_EDIT_SUCCESS => 'onEditSuccess',
        ];
    }

    public function onEditSuccess(FormEvent $event)
    {
        $url = $this->router->generate('app_user_profile');

        $event->setResponse(new RedirectResponse($url));
    }
}
