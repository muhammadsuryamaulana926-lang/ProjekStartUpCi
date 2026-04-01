<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('/dashboard', 'Startup::index');
$routes->get('/data-startup', 'Startup::data_startup');
$routes->get('/tambah-startup', 'Startup::tambah_startup');
$routes->post('/save-startup', 'Startup::save_startup');
$routes->post('/save-tim', 'Startup::tambahTim');
$routes->post('/update-tim', 'Startup::updateTim');
$routes->post('/update-startup', 'Startup::update_startup');
$routes->get('/edit-startup/(:any)', 'Startup::edit_startup/$1');
$routes->post('/edit-startup', 'Startup::edit_startup');
$routes->get('/detail/(:any)', 'Startup::detail/$1');
$routes->get('/delete-startup/(:any)', 'Startup::delete_startup/$1');
$routes->get('/delete-tim/(:any)', 'Startup::delete_tim/$1');
