<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');                                   // Index
$routes->post('home/add_user', 'Home::add_user');                   // Add User
$routes->post('home/view_user', 'Home::get_user_by_id');            // Retrieve user data by ID for viewing user data
$routes->post('home/get_update_user', 'Home::get_user_by_id');      // retrieve user data by ID for updating user data
$routes->post('home/update_user', 'Home::update_user');             // Update user
$routes->post('home/delete_user', 'Home::delete_user');             // Delete user
