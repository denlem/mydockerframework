<?php

namespace Simplex;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GoogleListener implements EventSubscriberInterface
{
    public function onResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        if ($response->isRedirection()
            || 'html' !== $event->getRequest()->getRequestFormat()
            || ($response->headers->has('Content-Type')
                && false === strpos($response->headers->get('Content-Type'), 'html'))
        ) {
            return;
        }

        $response->setContent($response->getContent().'GA CODE');
    }

    public static function getSubscribedEvents(): array
    {
        return ['response' => 'onResponse'];
    }
}