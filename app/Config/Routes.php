<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public Landing Page & Auth routes
$routes->get('/', 'LandingController::index');
$routes->get('login', 'AuthController::login');
$routes->post('login/process', 'AuthController::process');
$routes->post('login/pin', 'AuthController::processPin');
$routes->get('logout', 'AuthController::logout');

// Lupa PIN & OTP Recovery
$routes->get('lupa-pin', 'AuthController::forgotPin');
$routes->post('lupa-pin/kirim-otp', 'AuthController::sendOtp');
$routes->get('verifikasi-otp', 'AuthController::verifyOtpPage');
$routes->post('verifikasi-otp/proses', 'AuthController::processVerifyOtp');
$routes->get('buat-pin-baru', 'AuthController::resetPinPage');
$routes->post('buat-pin-baru/proses', 'AuthController::processResetPin');

// Protected Routes (Semua yang login sebagai Administrator)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('dashboard/(:num)', 'DashboardController::index/$1');
    $routes->post('dashboard/simpan', 'DashboardController::simpanProyekDanNilai');
    $routes->get('dashboard/hitung', 'DashboardController::hitungUlang');
    $routes->get('dashboard/hapus/(:num)', 'DashboardController::hapusProyek/$1');
    $routes->get('dashboard/pdf', 'DashboardController::pdf');
    $routes->get('dashboard/pdf/(:num)', 'DashboardController::pdf/$1');

    $routes->get('pengaturan', 'KriteriaController::index');
    $routes->addRedirect('proyek', 'dashboard');
    $routes->addRedirect('proyek/(:any)', 'dashboard');
    $routes->get('periode', 'PeriodeController::index');
    $routes->get('hasil', 'DashboardController::index');
    $routes->get('hasil/(:num)', 'DashboardController::index/$1');
    $routes->get('hasil/pdf/(:num)', 'DashboardController::pdf/$1');
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
