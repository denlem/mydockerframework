
<?php
require dirname(__DIR__).'/vendor/autoload.php';


use Symfony\Component\HttpFoundation\Request;
use Simplex\StringResponseListener;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;

//$routes = include __DIR__.'/../src/app.php';
$container = include __DIR__.'/../src/container.php';

$container->setParameter('routes', include __DIR__.'/../src/app.php');


//$container->register('listener.string_response', StringResponseListener::class);
//$container->getDefinition('dispatcher')
//    ->addMethodCall('addSubscriber', [new Reference('listener.string_response')])
//;

//$container->setParameter('debug', true);

//var_dump($container->getParameter('debug'));

//$container->register('listener.response', HttpKernel\EventListener\ResponseListener::class)
//$container->register('listener.response', ResponseListener::class)
//    ->setArguments(['%charset%'])
//;

$request = Request::createFromGlobals();

$response = $container->get('framework')->handle($request);

$response->send();