<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
//$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/(:any)/cart', 'Home::cart/$1');
$routes->get('/(:any)/place_order', 'Home::place_order/$1');
$routes->get('/(:any)/products/(:any)', 'Home::product_detail/$1/$2');
$routes->get('/(:any)/order_detail/(:any)', 'Home::order_detail/$1/$2');
$routes->get('/(:any)/signin', '\Myth\Auth\Controllers\AuthController::login/$1');
$routes->post('signin', '\Myth\Auth\Controllers\AuthController::attemptLogin');
$routes->get('logout', '\Myth\Auth\Controllers\AuthController::logout');
$routes->get('User', 'User::index');
$routes->get('/(:any)/register', '\Myth\Auth\Controllers\AuthController::register/$1');
$routes->post('register', '\Myth\Auth\Controllers\AuthController::attemptRegister');
//$routes->get('/(:any)/signin', 'Home::signin/$1');
$routes->get('/(:segment)', 'Home::index/$1');
$routes->get('/not_found', 'Home::not_found');
//$routes->get('permission/create', 'Permission::create');
//...


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
