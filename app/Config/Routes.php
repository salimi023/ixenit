<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('home/add_user', 'Home::add_user');
$routes->post('home/view_user', 'Home::get_user_by_id');
$routes->post('home/get_update_user', 'Home::get_user_by_id');
$routes->post('home/update_user', 'Home::update_user');
