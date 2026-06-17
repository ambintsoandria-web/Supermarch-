<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'ImportController::index');
$routes->get('/import', 'ImportController::index');
$routes->post('/import/upload', 'ImportController::upload');