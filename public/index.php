<?php

require_once __DIR__.'/../vendor/autoload.php';

use Src\Core\Application;
use Src\Controllers\AdminController;
use Src\Controllers\CategoryController;
use Src\Controllers\CheckoutController;
use Src\Controllers\ProductController;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$app = new Application(dirname(__DIR__));

$app->router->get('/', [AdminController::class, 'dashboard']);

$app->router->get('/categories', [CategoryController::class, 'index']);
$app->router->get('/categories/add', [CategoryController::class, 'add']);
$app->router->post('/categories/store', [CategoryController::class, 'store']);
$app->router->get('/categories/edit/{number}', [CategoryController::class, 'edit']);
$app->router->post('/categories/update/{number}', [CategoryController::class, 'update']);
$app->router->get('/categories/delete/{number}', [CategoryController::class, 'delete']);

$app->router->get('/products', [ProductController::class, 'index']);
$app->router->get('/products/add', [ProductController::class, 'add']);
$app->router->post('/products/store', [ProductController::class, 'store']);
$app->router->get('/products/edit/{number}', [ProductController::class, 'edit']);
$app->router->post('/products/update/{number}', [ProductController::class, 'update']);
$app->router->get('/products/delete/{number}', [ProductController::class, 'delete']);

$app->router->get('/checkout/cart', [CheckoutController::class, 'cart']);
$app->router->post('/checkout/add-to-cart', [CheckoutController::class, 'addToCart']);
$app->router->post('/checkout', [CheckoutController::class, 'checkout']);

$app->run();
