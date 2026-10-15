<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public Landing Page & Auth routes
$routes->get('/', 'LandingController::index');
$routes->get('login', 'AuthController::login');
$routes->post('login/process', 'AuthController::process');
$routes->get('logout', 'AuthController::logout');

// Protected Routes (Semua yang login sebagai Administrator)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('proyek', 'ProyekController::index');
    $routes->get('periode', 'PeriodeController::index');
    $routes->get('hasil', 'HasilController::index');
    $routes->get('hasil/(:num)', 'HasilController::index/$1');
    $routes->get('hasil/pdf/(:num)', 'HasilController::pdf/$1');
    $routes->get('riwayat', 'RiwayatController::index');
});

// Admin Only Routes
$routes->group('', ['filter' => 'admin'], static function ($routes) {
    // Proyek CRUD
    $routes->get('proyek/create', 'ProyekController::create');
    $routes->post('proyek/store', 'ProyekController::store');
    $routes->get('proyek/edit/(:num)', 'ProyekController::edit/$1');
    $routes->post('proyek/update/(:num)', 'ProyekController::update/$1');
    $routes->get('proyek/delete/(:num)', 'ProyekController::delete/$1');

    // Kriteria & Bobot & Pengaturan
    $routes->get('kriteria', 'KriteriaController::index');
    $routes->post('kriteria/update', 'KriteriaController::update');
    $routes->post('pengaturan/update', 'KriteriaController::updatePengaturan');

    // Periode Penilaian & Hitung SAW
    $routes->get('periode/create', 'PeriodeController::create');
    $routes->post('periode/store', 'PeriodeController::store');
    $routes->get('periode/edit/(:num)', 'PeriodeController::edit/$1');
    $routes->post('periode/update/(:num)', 'PeriodeController::update/$1');
    $routes->get('periode/delete/(:num)', 'PeriodeController::delete/$1');
    $routes->get('periode/hitung/(:num)', 'PeriodeController::hitungSaw/$1');

    // Input Penilaian Data Mentah
    $routes->get('penilaian/(:num)', 'PenilaianController::index/$1');
    $routes->get('penilaian/(:num)/(:num)', 'PenilaianController::edit/$1/$2');
    $routes->post('penilaian/(:num)/(:num)', 'PenilaianController::save/$1/$2');
    $routes->post('penilaian/(:num)/batch', 'PenilaianController::saveBatch/$1');
    $routes->post('penilaian/(:num)/add', 'PenilaianController::addProyek/$1');
    $routes->get('penilaian/(:num)/remove/(:num)', 'PenilaianController::removeProyek/$1/$2');

    // Manajemen Pengguna
    $routes->get('users', 'UserController::index');
    $routes->get('users/create', 'UserController::create');
    $routes->post('users/store', 'UserController::store');
    $routes->get('users/edit/(:num)', 'UserController::edit/$1');
    $routes->post('users/update/(:num)', 'UserController::update/$1');
    $routes->get('users/toggle/(:num)', 'UserController::toggle/$1');
});
