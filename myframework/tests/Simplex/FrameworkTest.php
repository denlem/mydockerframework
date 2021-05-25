<?php

namespace Simplex\Tests;

use Calendar\Controller\LeapYearController;
use PHPUnit\Framework\TestCase;
use Simplex\Framework;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class FrameworkTest extends TestCase
{

    public function testControllerResponse(): void
    {
        $matcher = $this->createMock(Routing\Matcher\UrlMatcherInterface::class);
        // use getMock() on PHPUnit 5.3 or below
        // $matcher = $this->getMock(Routing\Matcher\UrlMatcherInterface::class);

        $matcher
            ->expects(self::once())
            ->method('match')
            ->willReturn([
                '_route' => 'is_leap_year/{year}',
                'year' => '2000',
                '_controller' => [new LeapYearController(), 'index']
            ]);

        $matcher
            ->expects(self::once())
            ->method('getContext')
            ->willReturn($this->createMock(Routing\RequestContext::class));

        $controllerResolver = new ControllerResolver();
        $argumentResolver = new ArgumentResolver();

        $framework = new Framework($matcher, $controllerResolver, $argumentResolver);

        $response = $framework->handle(new Request());

        self::assertEquals(200, $response->getStatusCode());
        self::assertStringContainsString('Yep, this is a leap year!', $response->getContent());
    }

    public function testNotFoundHandling(): void
    {
        $framework = $this->getFrameworkForException(new ResourceNotFoundException());

        $response = $framework->handle(new Request());

        self::assertEquals(404, $response->getStatusCode());
    }

    public function testErrorHandling(): void
    {
        $framework = $this->getFrameworkForException(new \RuntimeException());

        $response = $framework->handle(new Request());

        self::assertEquals(500, $response->getStatusCode());
    }

    private function getFrameworkForException($exception): Framework
    {
        $matcher = $this->createMock(Routing\Matcher\UrlMatcherInterface::class);
        // use getMock() on PHPUnit 5.3 or below
        // $matcher = $this->getMock(Routing\Matcher\UrlMatcherInterface::class);

        $matcher
            ->expects($this->once())
            ->method('match')
            ->will($this->throwException($exception))
        ;
        $matcher
            ->expects($this->once())
            ->method('getContext')
            ->will($this->returnValue($this->createMock(Routing\RequestContext::class)))
        ;
        $controllerResolver = $this->createMock(ControllerResolverInterface::class);
        $argumentResolver = $this->createMock(ArgumentResolverInterface::class);

        return new Framework($matcher, $controllerResolver, $argumentResolver);
    }
}