<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('home/add_user', 'Home::add_user');
$routes->post('home/view_user', 'Home::view_user');
