<?php
require_once './vendor/autoload.php';
 
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
 
try
{
    $index_route = new Route(
        '/',
        ['controller' => 'DefaultController', 'method'=>'index']
    );
 
    $product_fill_route = new Route(
        '/product/fill-table',
        ['controller' => 'ProductController', 'method'=>'fillProductTable'],
    );
   
    $product_get_all_route = new Route(
        '/product/get-all',
        ['controller' => 'ProductController', 'method'=>'getAll'],
    );
   
    $order_create_route = new Route(
        '/order/create',
        ['controller' => 'OrderController', 'method'=>'create'],
    );
   
    $order_pay_route = new Route(
        '/order/create',
        ['controller' => 'OrderController', 'method'=>'pay'],
    );
   
    $routes = new RouteCollection();
    $routes->add('index_route', $index_route);
    $routes->add('product_fill_route', $product_fill_route);
    $routes->add('product_get_all_route', $product_get_all_route);
    $routes->add('order_create_route', $order_create_route);
    $routes->add('order_pay_route', $order_pay_route);
 
    // Init RequestContext object
    $context = new RequestContext();
    $context->fromRequest(Request::createFromGlobals());
 
    // Init UrlMatcher object
    $matcher = new UrlMatcher($routes, $context);
 
    // Find the current route
    $parameters = $matcher->match($context->getPathInfo());
 
    // How to generate a SEO URL
    $generator = new UrlGenerator($routes, $context);
    $url = $generator->generate('foo_placeholder_route', array(
      'id' => 123,
    ));
 
    echo '<pre>';
    print_r($parameters);
 
    echo 'Generated URL: ' . $url;
    exit;
}
catch (ResourceNotFoundException $e)
{
  echo $e->getMessage();
}