<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

/* Routes Authentication */
$routes->get('/', 'AuthController::index', ['filter' => 'authenticate']);
$routes->post('/cek-login', 'AuthController::cek_login', ['filter' => 'authenticate']);
$routes->get('/logout', 'AuthController::logout', ['filter' => 'redirectIfAuthenticated']);

$routes->get('/home', 'HomeController::index', ['filter' => 'redirectIfAuthenticated']);

/* Routes Administrator or Apoteker */
$routes->get('/supplier', 'SupplierController::index', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/supplier/create', 'SupplierController::create', ['filter' => 'redirectIfAuthenticated']);
$routes->post('/supplier/store', 'SupplierController::store', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/supplier/edit/(:any)', 'SupplierController::edit/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->post('/supplier/update/(:any)', 'SupplierController::update/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->delete('/supplier/delete/(:any)', 'SupplierController::delete/$1', ['filter' => 'redirectIfAuthenticated']);

$routes->get('/kategori', 'KategoriController::index', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/kategori/create', 'KategoriController::create', ['filter' => 'redirectIfAuthenticated']);
$routes->post('/kategori/store', 'KategoriController::store', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/kategori/edit/(:any)', 'KategoriController::edit/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->post('/kategori/update/(:any)', 'KategoriController::update/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->delete('/kategori/delete/(:any)', 'KategoriController::delete/$1', ['filter' => 'redirectIfAuthenticated']);

$routes->get('/merk', 'MerkController::index', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/merk/create', 'MerkController::create', ['filter' => 'redirectIfAuthenticated']);
$routes->post('/merk/store', 'MerkController::store', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/merk/edit/(:any)', 'MerkController::edit/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->post('/merk/update/(:any)', 'MerkController::update/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->delete('/merk/delete/(:any)', 'MerkController::delete/$1', ['filter' => 'redirectIfAuthenticated']);

$routes->get('/rak', 'RakController::index', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/rak/create', 'RakController::create', ['filter' => 'redirectIfAuthenticated']);
$routes->post('/rak/store', 'RakController::store', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/rak/edit/(:any)', 'RakController::edit/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->post('/rak/update/(:any)', 'RakController::update/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->delete('/rak/delete/(:any)', 'RakController::delete/$1', ['filter' => 'redirectIfAuthenticated']);

$routes->get('/databarang', 'DataBarangController::index', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/databarang/create', 'DataBarangController::create', ['filter' => 'redirectIfAuthenticated']);
$routes->post('/databarang/store', 'DataBarangController::store', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/databarang/edit/(:any)', 'DataBarangController::edit/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->post('/databarang/update/(:any)', 'DataBarangController::update/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->delete('/databarang/delete/(:any)', 'DataBarangController::delete/$1', ['filter' => 'redirectIfAuthenticated']);

$routes->get('barangmasuk', 'BarangMasukController::index', ['filter' => 'redirectIfAuthenticated']);
$routes->get('barangmasuk/create', 'BarangMasukController::create', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangmasuk/getDataBarang', 'BarangMasukController::getDataBarang', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangmasuk/storeTemp', 'BarangMasukController::storeTemp', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangmasuk/dataTemp', 'BarangMasukController::dataTemp', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangmasuk/delete', 'BarangMasukController::delete', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangmasuk/selesaiTransaksi', 'BarangMasukController::selesaiTransaksi', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/barangmasuk/edit/(:any)', 'BarangMasukController::edit/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangmasuk/dataDetail', 'BarangMasukController::dataDetail', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangmasuk/editItem', 'BarangMasukController::editItem', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangmasuk/editDetailItem', 'BarangMasukController::editDetailItem', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangmasuk/deleteDetail', 'BarangMasukController::deleteDetail', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangmasuk/storeBarangMasuk', 'BarangMasukController::storeBarangMasuk', ['filter' => 'redirectIfAuthenticated']);

$routes->get('barangkeluar', 'BarangKeluarController::index', ['filter' => 'redirectIfAuthenticated']);
$routes->get('barangkeluar/create', 'BarangKeluarController::create', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangkeluar/getDataBarang', 'BarangKeluarController::getDataBarang', ['filter' => 'redirectIfAuthenticated']);
// $routes->post('barangkeluar/storeTemp', 'BarangKeluarController::storeTemp', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangkeluar/dataTemp', 'BarangKeluarController::dataTemp', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangkeluar/delete', 'BarangKeluarController::delete', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangkeluar/selesaiTransaksi', 'BarangKeluarController::selesaiTransaksi', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/barangkeluar/edit/(:any)', 'BarangKeluarController::edit/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangkeluar/dataDetail', 'BarangKeluarController::dataDetail', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangkeluar/editItem', 'BarangKeluarController::editItem', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangkeluar/editDetailItem', 'BarangKeluarController::editDetailItem', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangkeluar/deleteDetail', 'BarangKeluarController::deleteDetail', ['filter' => 'redirectIfAuthenticated']);
$routes->post('barangkeluar/storeBarangKeluar', 'BarangKeluarController::storeBarangKeluar', ['filter' => 'redirectIfAuthenticated']);

$routes->get('stockopname', 'StockOpnameController::index', ['filter' => 'redirectIfAuthenticated']);
$routes->get('stockopname/create', 'StockOpnameController::create', ['filter' => 'redirectIfAuthenticated']);
$routes->post('stockopname/store', 'StockOpnameController::store', ['filter' => 'redirectIfAuthenticated']);
$routes->get('stockopname/edit/(:any)', 'StockOpnameController::edit/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->post('stockopname/update', 'StockOpnameController::update', ['filter' => 'redirectIfAuthenticated']);
$routes->delete('stockopname/delete/(:any)', 'StockOpnameController::delete/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->post('stockopname/getStockBarang', 'StockOpnameController::getStockBarang', ['filter' => 'redirectIfAuthenticated']);

/* Routes Cetak */
$routes->get('cetak/barangmasuk', 'CetakController::indexBarangMasuk', ['filter' => 'redirectIfAuthenticated']);
$routes->post('cetak/dataBarangMasuk', 'CetakController::dataBarangMasuk', ['filter' => 'redirectIfAuthenticated']);
$routes->post('cetak/printBarangMasuk', 'CetakController::printBarangMasuk', ['filter' => 'redirectIfAuthenticated']);

$routes->get('cetak/barangkeluar', 'CetakController::indexBarangKeluar', ['filter' => 'redirectIfAuthenticated']);
$routes->post('cetak/dataBarangKeluar', 'CetakController::dataBarangKeluar', ['filter' => 'redirectIfAuthenticated']);
$routes->post('cetak/printBarangKeluar', 'CetakController::printBarangKeluar', ['filter' => 'redirectIfAuthenticated']);

$routes->get('cetak/stockopname', 'CetakController::indexStockOpname', ['filter' => 'redirectIfAuthenticated']);
$routes->post('cetak/dataStockOpname', 'CetakController::dataStockOpname', ['filter' => 'redirectIfAuthenticated']);
$routes->post('cetak/printStockOpname', 'CetakController::printStockOpname', ['filter' => 'redirectIfAuthenticated']);

$routes->get('cetak/supplier', 'CetakController::indexSupplier', ['filter' => 'redirectIfAuthenticated']);
$routes->post('cetak/dataSupplier', 'CetakController::dataSupplier', ['filter' => 'redirectIfAuthenticated']);
$routes->post('cetak/printSupplier', 'CetakController::printSupplier', ['filter' => 'redirectIfAuthenticated']);

$routes->get('notification', 'NotificationController::index', ['filter' => 'redirectIfAuthenticated']);
$routes->get('barang-menipis', 'NotificationController::menipis', ['filter' => 'redirectIfAuthenticated']);
$routes->get('barang-habis', 'NotificationController::habis', ['filter' => 'redirectIfAuthenticated']);

/* Routes Owner */
$routes->get('/data-user', 'UserController::index', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/data-user/create', 'UserController::create', ['filter' => 'redirectIfAuthenticated']);
$routes->post('/data-user/store', 'UserController::store', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/data-user/edit/(:any)', 'UserController::edit/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->post('/data-user/update/(:any)', 'UserController::update/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->delete('/data-user/delete/(:any)', 'UserController::delete/$1', ['filter' => 'redirectIfAuthenticated']);

/* Default Routes */
$routes->get('profile', 'ProfileController::index', ['filter' => 'redirectIfAuthenticated']);
$routes->post('profile/changePassword', 'ProfileController::changePassword', ['filter' => 'redirectIfAuthenticated']);
$routes->get('profile/ubahProfile', 'ProfileController::ubahProfile', ['filter' => 'redirectIfAuthenticated']);
$routes->post('profile/changeProfile', 'ProfileController::changeProfile', ['filter' => 'redirectIfAuthenticated']);
$routes->get('profile/ubahPicture', 'ProfileController::ubahPicture', ['filter' => 'redirectIfAuthenticated']);
$routes->post('profile/changePicture', 'ProfileController::changePicture', ['filter' => 'redirectIfAuthenticated']);

$routes->get('/data-cabang', 'CabangController::index', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/data-cabang/create', 'CabangController::create', ['filter' => 'redirectIfAuthenticated']);
$routes->post('/data-cabang/store', 'CabangController::store', ['filter' => 'redirectIfAuthenticated']);
$routes->get('/data-cabang/edit/(:any)', 'CabangController::edit/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->post('/data-cabang/update/(:any)', 'CabangController::update/$1', ['filter' => 'redirectIfAuthenticated']);
$routes->delete('/data-cabang/delete/(:any)', 'CabangController::delete/$1', ['filter' => 'redirectIfAuthenticated']);

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
