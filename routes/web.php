<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\sikas\Main;
use App\Http\Controllers\sikas\PembayaranController;
use App\Http\Controllers\sikas\TellerController;
use App\Http\Controllers\sikas\SiswaController;
use App\Http\Controllers\sikas\KaryawanController;
use App\Http\Controllers\sikas\JenisPembayaranController;
use App\Http\Controllers\sikas\LaporanController;
use App\Http\Controllers\sikas\TabunganController;
use App\Http\Controllers\sikas\Auth\AuthController;
use App\Http\Controllers\sikas\Query\QueryController;

$controller_path = 'App\Http\Controllers';
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//MAIN ROUTE SIKAS
Route::get('/', [Main::class, 'index'])->name('sikas-dashboard');
Route::get('/login', [Main::class, 'login'])->name('sikas-login');
Route::get('/register', [Main::class, 'register'])->name('sikas-register');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('sikas-authenticate');

// Session Middleware
Route::group(['middleware' => 'authsession'], function () {
    Route::get('/', [Main::class, 'index'])->name('sikas-dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('sikas-logout');

    // Transaksi
    Route::get('/transaksi', [Main::class, 'index'])->name('sikas-transaksi');
    Route::get('/transaksi/pembayaran', [PembayaranController::class, 'transaksiPembayaran'])->name('sikas-transaksi--pembayaran');
    Route::get('/transaksi/pembayaran/akademik', [PembayaranController::class, 'PembayaranAkademik'])->name('sikas-transaksi--pembayaran-akademik');
    Route::get('/transaksi/history-pembayaran/{id}', [PembayaranController::class, 'historyTransaksiPembayaran'])->name('sikas-transaksi--pembayaran-history');
    Route::get('/transaksi/pengajuan-keringanan/{id}', [PembayaranController::class, 'pengajuanKeringananPembayaran'])->name('sikas-transaksi--pembayaran-pengajuan-keringanan');
    Route::get('/transaksi/pembayaran/tabungan-siswa', [TabunganController::class, 'siswa'])->name('sikas-transaksi--pembayaran-tabungan-siswa');
    Route::get('/transaksi/pembayaran/tabungan-guru', [TabunganController::class, 'guru'])->name('sikas-transaksi--pembayaran-tabungan-guru');
    Route::get('/transaksi/pemasukan', [Main::class, 'TransaksiPemasukan'])->name('sikas-transaksi--pemasukan');
    Route::get('/transaksi/pengeluaran', [Main::class, 'TransaksiPengeluaran'])->name('sikas-transaksi--pengeluaran');
    Route::get('/transaksi/history-transaksi-siswa', [PembayaranController::class, 'historyTransaksiSiswa'])->name('sikas-transaksi--pembayaran-history-siswa');
    Route::get('/transaksi/history-transaksi-siswa/detail/{id}', [PembayaranController::class, 'historyTransaksiSiswaDetail'])->name('sikas-transaksi--pembayaran-history-siswa-detail');

    //Teller Controller
    Route::get('/teller', [TellerController::class, 'index'])->name('sikas-teller');

    //Siswa Controller
    Route::get('/siswa', [SiswaController::class, 'index'])->name('sikas-siswa');

    //Karyawan Controller
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('sikas-karyawan');

    //Jenis Pembayaran Controller
    Route::get('/jenis-pembayaran', [JenisPembayaranController::class, 'index'])->name('sikas-jenis-pembayaran');

    //Laporan Controller
    Route::get('/laporan', [LaporanController::class, 'index'])->name('sikas-laporan');
    Route::get('/laporan-penggunaan-dana', [LaporanController::class, 'penggunaanDana'])->name('sikas-laporan--penggunaan-dana');
    Route::get('/laporan-pemasukan-dari-sumber-lain', [LaporanController::class, 'pemasukanSumberLain'])->name('sikas-laporan--pemasukan-dari-sumber-lain');
    Route::get('/laporan-pengajuan-keringanan', [LaporanController::class, 'pengajuanKeringanan'])->name('sikas-laporan--pengajuan-keringanan');
    Route::get('/laporan-pembayaran-spp', [LaporanController::class, 'pembayaranSPP'])->name('sikas-laporan--pembayaran-spp');


    //Other
    Route::get('/pengguna', [Main::class, 'index'])->name('sikas-pengguna');
    Route::get('/pengaturan', [Main::class, 'index'])->name('sikas-pengaturan');

    // Query
    Route::post('/query/dataSiswa', [QueryController::class, 'dataSiswa'])->name('sikas-query-datasiswa');
    Route::post('/query/dataGuru', [QueryController::class, 'dataGuru'])->name('sikas-query-dataguru');
    Route::post('/query/siswaById', [QueryController::class, 'siswaById'])->name('sikas-query-siswabyid');
    Route::post('/query/guruById', [QueryController::class, 'guruById'])->name('sikas-query-gurubyid');
    Route::post('/query/setorTabunganSiswa', [QueryController::class, 'setorTabunganSiswa'])->name('sikas-query-setortabungansiswa');
    Route::post('/query/penarikanTabunganSiswa', [QueryController::class, 'penarikanTabunganSiswa'])->name('sikas-query-penarikantabungansiswa');
    Route::post('/query/riwayatTabungan', [QueryController::class, 'riwayatTabungan'])->name('sikas-query-riwayattabungan');
    Route::post('/query/updateHistoryPembayaran', [QueryController::class, 'updateHistoryPembayaran'])->name('sikas-query-updatehistorypembayaran');
    Route::post('/query/deleteHistoryPembayaran', [QueryController::class, 'deleteHistoryPembayaran'])->name('sikas-query-deletehistorypembayaran');
    Route::post('/query/updateHistoryTabungan', [QueryController::class, 'updateHistoryTabungan'])->name('sikas-query-updatehistorytabungan');
    Route::post('/query/deleteHistoryTabungan', [QueryController::class, 'deleteHistoryTabungan'])->name('sikas-query-deletehistorytabungan');
    Route::post('/query/pengeluaran', [QueryController::class, 'pengeluaran'])->name('sikas-query-pengeluaran');
    Route::post('/query/updatePengeluaran', [QueryController::class, 'updatePengeluaran'])->name('sikas-query-updatepengeluaran');
    Route::post('/query/deletePengeluaran', [QueryController::class, 'deletePengeluaran'])->name('sikas-query-deletepengeluaran');
    Route::post('/query/pemasukan', [QueryController::class, 'pemasukan'])->name('sikas-query-pemasukan');
    Route::post('/query/updatePemasukan', [QueryController::class, 'updatePemasukan'])->name('sikas-query-updatepemasukan');
    Route::post('/query/deletePemasukan', [QueryController::class, 'deletePemasukan'])->name('sikas-query-deletepemasukan');
    Route::post('/query/postPembayaranAkademik', [QueryController::class, 'postPembayaranAkademik'])->name('sikas-query--post-pembayaran-akademik');
    Route::post('/query/postPengajuanKeringanan', [QueryController::class, 'postPengajuanKeringanan'])->name('sikas-query--post-pengajuan-keringanan');
});

// Don't uncomment
// Route::get('/new-admin', [AuthController::class, 'newAdmin'])->name('sikas-newAdmin');


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//TEMPLATE EXAMPLE / RESOURCE
// Main Page Route
Route::get('/dashboard-example', $controller_path . '\dashboard\Analytics@index')->name('dashboard-analytics');

// layout
Route::get('/layouts/without-menu', $controller_path . '\layouts\WithoutMenu@index')->name('layouts-without-menu');
Route::get('/layouts/without-navbar', $controller_path . '\layouts\WithoutNavbar@index')->name('layouts-without-navbar');
Route::get('/layouts/fluid', $controller_path . '\layouts\Fluid@index')->name('layouts-fluid');
Route::get('/layouts/container', $controller_path . '\layouts\Container@index')->name('layouts-container');
Route::get('/layouts/blank', $controller_path . '\layouts\Blank@index')->name('layouts-blank');

// pages
Route::get('/pages/account-settings-account', $controller_path . '\pages\AccountSettingsAccount@index')->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', $controller_path . '\pages\AccountSettingsNotifications@index')->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', $controller_path . '\pages\AccountSettingsConnections@index')->name('pages-account-settings-connections');
Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', $controller_path . '\pages\MiscUnderMaintenance@index')->name('pages-misc-under-maintenance');

// authentication
Route::get('/auth/login-basic', $controller_path . '\authentications\LoginBasic@index')->name('auth-login-basic');
Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', $controller_path . '\authentications\ForgotPasswordBasic@index')->name('auth-reset-password-basic');

// cards
Route::get('/cards/basic', $controller_path . '\cards\CardBasic@index')->name('cards-basic');

// User Interface
Route::get('/ui/accordion', $controller_path . '\user_interface\Accordion@index')->name('ui-accordion');
Route::get('/ui/alerts', $controller_path . '\user_interface\Alerts@index')->name('ui-alerts');
Route::get('/ui/badges', $controller_path . '\user_interface\Badges@index')->name('ui-badges');
Route::get('/ui/buttons', $controller_path . '\user_interface\Buttons@index')->name('ui-buttons');
Route::get('/ui/carousel', $controller_path . '\user_interface\Carousel@index')->name('ui-carousel');
Route::get('/ui/collapse', $controller_path . '\user_interface\Collapse@index')->name('ui-collapse');
Route::get('/ui/dropdowns', $controller_path . '\user_interface\Dropdowns@index')->name('ui-dropdowns');
Route::get('/ui/footer', $controller_path . '\user_interface\Footer@index')->name('ui-footer');
Route::get('/ui/list-groups', $controller_path . '\user_interface\ListGroups@index')->name('ui-list-groups');
Route::get('/ui/modals', $controller_path . '\user_interface\Modals@index')->name('ui-modals');
Route::get('/ui/navbar', $controller_path . '\user_interface\Navbar@index')->name('ui-navbar');
Route::get('/ui/offcanvas', $controller_path . '\user_interface\Offcanvas@index')->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', $controller_path . '\user_interface\PaginationBreadcrumbs@index')->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', $controller_path . '\user_interface\Progress@index')->name('ui-progress');
Route::get('/ui/spinners', $controller_path . '\user_interface\Spinners@index')->name('ui-spinners');
Route::get('/ui/tabs-pills', $controller_path . '\user_interface\TabsPills@index')->name('ui-tabs-pills');
Route::get('/ui/toasts', $controller_path . '\user_interface\Toasts@index')->name('ui-toasts');
Route::get('/ui/tooltips-popovers', $controller_path . '\user_interface\TooltipsPopovers@index')->name('ui-tooltips-popovers');
Route::get('/ui/typography', $controller_path . '\user_interface\Typography@index')->name('ui-typography');

// extended ui
Route::get('/extended/ui-perfect-scrollbar', $controller_path . '\extended_ui\PerfectScrollbar@index')->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', $controller_path . '\extended_ui\TextDivider@index')->name('extended-ui-text-divider');

// icons
Route::get('/icons/boxicons', $controller_path . '\icons\Boxicons@index')->name('icons-boxicons');

// form elements
Route::get('/forms/basic-inputs', $controller_path . '\form_elements\BasicInput@index')->name('forms-basic-inputs');
Route::get('/forms/input-groups', $controller_path . '\form_elements\InputGroups@index')->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', $controller_path . '\form_layouts\VerticalForm@index')->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', $controller_path . '\form_layouts\HorizontalForm@index')->name('form-layouts-horizontal');

// tables
Route::get('/tables/basic', $controller_path . '\tables\Basic@index')->name('tables-basic');
