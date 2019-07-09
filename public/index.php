<?php
require_once '../vendor/autoload.php';
 
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use src\controllers\OrderController;
use src\controllers\DefaultController;
use src\controllers\ProductController;
 
try
{
    $index_route = new Route(
        '/',
        ['_controller' => DefaultController::class, '_method'=>'index']
    );
 
    $product_fill_route = new Route(
        '/product/fill-table',
        ['_controller' => ProductController::class, '_method'=>'fillProductTable'],
    );
   
    $product_get_all_route = new Route(
        '/product/get-list',
        ['_controller' => ProductController::class, '_method'=>'getList'],
    );
   
    $order_create_route = new Route(
        '/order/create',
        ['_controller' => OrderController::class, '_method'=>'create'],
    );
   
    $order_pay_route = new Route(
        '/order/pay',
        ['_controller' => OrderController::class, '_method'=>'pay'],
    );
   
    $routes = new RouteCollection();
    $routes->add('index_route', $index_route);
    $routes->add('product_fill_route', $product_fill_route);
    $routes->add('product_get_all_route', $product_get_all_route);
    $routes->add('order_create_route', $order_create_route);
    $routes->add('order_pay_route', $order_pay_route);
 
    $request = Request::createFromGlobals();
    $context = new RequestContext();
    $context->fromRequest($request);
 
    $matcher = new UrlMatcher($routes, $context);
    $params = $matcher->match($context->getPathInfo());
    $controller = $params['_controller'];
    $method = $params['_method'];
    unset($params);
    
    (new $controller($request))->$method();
}
catch (ResourceNotFoundException $e)
{
  echo $e->getMessage();
}