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
use App\Http\Controllers\sikas\PembayaranDinamisController;
use App\Http\Controllers\sikas\TellerController;
use App\Http\Controllers\sikas\SiswaController;
use App\Http\Controllers\sikas\KaryawanController;
use App\Http\Controllers\sikas\JenisPembayaranController;
use App\Http\Controllers\sikas\LaporanController;
use App\Http\Controllers\sikas\TabunganController;
use App\Http\Controllers\sikas\PengaturanController;
use App\Http\Controllers\sikas\JabatanController;
use App\Http\Controllers\sikas\JurusanController;
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
    Route::get('/transaksi/biaya-penunjang-pendidikan', [PembayaranController::class, 'PembayaranAkademik'])->name('sikas-transaksi--biaya-penunjang-pendidikan');
    Route::get('/transaksi/bpp-alumni', [PembayaranController::class, 'PembayaranAkademikAlumni'])->name('sikas-transaksi--bpp-alumni');
    Route::post('/transaksi/importBpp', [PembayaranController::class, 'importBpp'])->name('sikas-transaksi--importbpp');
    Route::get('/transaksi/history-pembayaran/{id}', [PembayaranController::class, 'historyTransaksiPembayaran'])->name('sikas-transaksi--pembayaran-history');
    Route::get('/transaksi/pengajuan-penambahan/{id}', [PembayaranController::class, 'pengajuanPenambahanPembayaran'])->name('sikas-transaksi--pembayaran-pengajuan-penambahan');
    Route::get('/transaksi/pengajuan-keringanan/{id}', [PembayaranController::class, 'pengajuanKeringananPembayaran'])->name('sikas-transaksi--pembayaran-pengajuan-keringanan');
    Route::get('/transaksi/dinamis/{id}', [PembayaranDinamisController::class, 'pembayaranDinamis'])->name('sikas-transaksi-dinamis--pembayaran-dinamis');
    Route::get('/transaksi/tabungan', [TabunganController::class, 'tabungan'])->name('sikas-transaksi--tabungan');
    Route::get('/transaksi/tabungan/siswa', [TabunganController::class, 'siswa'])->name('sikas-transaksi--tabungan-siswa');
    Route::get('/transaksi/tabungan/guru', [TabunganController::class, 'guru'])->name('sikas-transaksi--tabungan-guru');
    Route::post('/transaksi/importTabunganSiswa', [TabunganController::class, 'importTabunganSiswa'])->name('sikas-transaksi--importtabungansiswa');
    Route::post('/transaksi/importTabunganGuru', [TabunganController::class, 'importTabunganGuru'])->name('sikas-transaksi--importtabunganguru');
    // Route::get('/transaksi/pemasukan', [Main::class, 'TransaksiPemasukan'])->name('sikas-transaksi--pemasukan');
    // Route::post('/transaksi/importPemasukan', [Main::class, 'importPemasukan'])->name('sikas-transaksi--importpemasukan');
    Route::get('/transaksi/pengeluaran', [Main::class, 'TransaksiPengeluaran'])->name('sikas-transaksi--pengeluaran');
    Route::post('/transaksi/importPengeluaran', [Main::class, 'importPengeluaran'])->name('sikas-transaksi--importpengeluaran');
    Route::get('/transaksi/history-transaksi-siswa', [PembayaranController::class, 'historyTransaksiSiswa'])->name('sikas-transaksi--pembayaran-history-siswa');
    Route::get('/transaksi/history-transaksi-siswa/detail/{id}', [PembayaranController::class, 'historyTransaksiSiswaDetail'])->name('sikas-transaksi--pembayaran-history-siswa-detail');

    //Laporan Controller
    Route::get('/laporan', [LaporanController::class, 'index'])->name('sikas-laporan');
    Route::get('/laporan-penggunaan-dana', [LaporanController::class, 'penggunaanDana'])->name('sikas-laporan--penggunaan-dana');
    // Route::get('/laporan-pemasukan-dari-sumber-lain', [LaporanController::class, 'pemasukanSumberLain'])->name('sikas-laporan--pemasukan-dari-sumber-lain');
    Route::get('/laporan-pengajuan-keringanan', [LaporanController::class, 'pengajuanKeringanan'])->name('sikas-laporan--pengajuan-keringanan');
    Route::get('/laporan-pengajuan-penambahan', [LaporanController::class, 'pengajuanPenambahan'])->name('sikas-laporan--pengajuan-penambahan');
    Route::get('/laporan-biaya-penunjang-pendidikan', [LaporanController::class, 'pembayaranSPP'])->name('sikas-laporan--biaya-penunjang-pendidikan');
    Route::get('/laporan-pembayaran-tabungan', [LaporanController::class, 'pembayaranTabungan'])->name('sikas-laporan--pembayaran-tabungan');


    ///////////////////////////////////
    // ADMIN SESSION
    Route::group(['middleware' => 'adminsession'], function () {

        //Teller Controller
        Route::get('/teller', [TellerController::class, 'index'])->name('sikas-teller');
        Route::post('/teller/post', [TellerController::class, 'postTeller'])->name('sikas-postteller');

        //Siswa Controller
        Route::get('/siswa', [SiswaController::class, 'index'])->name('sikas-siswa');
        Route::post('/siswa/post', [SiswaController::class, 'postSiswa'])->name('sikas-postsiswa');
        Route::post('/siswa/import', [SiswaController::class, 'importSiswa'])->name('sikas-importsiswa');

        //Karyawan Controller
        Route::get('/karyawan', [KaryawanController::class, 'index'])->name('sikas-karyawan');
        Route::post('/karyawan/post', [KaryawanController::class, 'postKaryawan'])->name('sikas-postkaryawan');
        Route::post('/karyawan/import', [KaryawanController::class, 'importKaryawan'])->name('sikas-importkaryawan');

        //Jenis Pembayaran Controller
        Route::get('/jenis-transaksi', [JenisPembayaranController::class, 'index'])->name('sikas-jenis-pembayaran');
        Route::post('/jenis-transaksi/post', [JenisPembayaranController::class, 'postJenisPembayaran'])->name('sikas-jenis-pembayaran-post');

         // Jabatan Contoller
        Route::get('/master-jabatan', [JabatanController::class, 'index'])->name('sikas-master-jabatan');
        Route::post('/master-jabatan/post', [JabatanController::class, 'postJabatan'])->name('sikas-master-jabatan-post');

        // jurusan Contoller
        Route::get('/master-jurusan', [JurusanController::class, 'index'])->name('sikas-master-jurusan');
        Route::post('/master-jurusan/post', [JurusanController::class, 'postJurusan'])->name('sikas-master-jurusan-post');

        //Other
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('sikas-pengaturan');
        Route::get('/reset-tahun-ajar', [PengaturanController::class, 'resetTahunAjar'])->name('sikas-reset-tahun-ajar');
    });

    // Query
    Route::post('/query/dataSiswa', [QueryController::class, 'dataSiswa'])->name('sikas-query-datasiswa');
    Route::post('/query/dataGuru', [QueryController::class, 'dataGuru'])->name('sikas-query-dataguru');
    Route::post('/query/siswaById', [QueryController::class, 'siswaById'])->name('sikas-query-siswabyid');
    Route::post('/query/siswaByFilter', [QueryController::class, 'siswaByFilter'])->name('sikas-query-siswabyfilter');
    Route::post('/query/guruById', [QueryController::class, 'guruById'])->name('sikas-query-gurubyid');
    Route::post('/query/tellerById', [QueryController::class, 'tellerById'])->name('sikas-query-tellerbyid');
    Route::post('/query/strukturSekolahById', [QueryController::class, 'strukturSekolahById'])->name('sikas-query-struktursekolahbyid');
    Route::post('/query/jurusanById', [QueryController::class, 'jurusanById'])->name('sikas-query-jurusanbyid');
    Route::post('/query/jenisPembayaranById', [QueryController::class, 'jenisPembayaranById'])->name('sikas-query-jenispembayaranbyid');
    Route::post('/query/setorTabunganSiswa', [QueryController::class, 'setorTabunganSiswa'])->name('sikas-query-setortabungansiswa');
    Route::post('/query/penarikanTabunganSiswa', [QueryController::class, 'penarikanTabunganSiswa'])->name('sikas-query-penarikantabungansiswa');
    Route::post('/query/approvePenarikanTabunganSiswa', [QueryController::class, 'approvePenarikanTabunganSiswa'])->name('sikas-query-approvepenarikantabungansiswa');
    Route::post('/query/riwayatPembayaranSpp', [QueryController::class, 'riwayatPembayaranSpp'])->name('sikas-query-riwayatpembayaranspp');
    Route::post('/query/riwayatTabungan', [QueryController::class, 'riwayatTabungan'])->name('sikas-query-riwayattabungan');
    Route::post('/query/updateHistoryPembayaran', [QueryController::class, 'updateHistoryPembayaran'])->name('sikas-query-updatehistorypembayaran');
    Route::post('/query/deleteHistoryPembayaran', [QueryController::class, 'deleteHistoryPembayaran'])->name('sikas-query-deletehistorypembayaran');
    Route::post('/query/updateHistoryTabungan', [QueryController::class, 'updateHistoryTabungan'])->name('sikas-query-updatehistorytabungan');
    Route::post('/query/deleteHistoryTabungan', [QueryController::class, 'deleteHistoryTabungan'])->name('sikas-query-deletehistorytabungan');
    Route::post('/query/pengeluaran', [QueryController::class, 'pengeluaran'])->name('sikas-query-pengeluaran');
    Route::post('/query/approvePengeluaran', [QueryController::class, 'approvePengeluaran'])->name('sikas-query-approvepengeluaran');
    Route::post('/query/updatePengeluaran', [QueryController::class, 'updatePengeluaran'])->name('sikas-query-updatepengeluaran');
    Route::post('/query/deletePengeluaran', [QueryController::class, 'deletePengeluaran'])->name('sikas-query-deletepengeluaran');
    Route::post('/query/pemasukan', [QueryController::class, 'pemasukan'])->name('sikas-query-pemasukan');
    Route::post('/query/updatePemasukan', [QueryController::class, 'updatePemasukan'])->name('sikas-query-updatepemasukan');
    Route::post('/query/deletePemasukan', [QueryController::class, 'deletePemasukan'])->name('sikas-query-deletepemasukan');
    Route::post('/query/updateKaryawan', [QueryController::class, 'updateKaryawan'])->name('sikas-query-updatekaryawan');
    Route::post('/query/deleteKaryawan', [QueryController::class, 'deleteKaryawan'])->name('sikas-query-deletekaryawan');
    Route::post('/query/updateSiswa', [QueryController::class, 'updateSiswa'])->name('sikas-query-updatesiswa');
    Route::post('/query/deleteSiswa', [QueryController::class, 'deleteSiswa'])->name('sikas-query-deletesiswa');
    Route::post('/query/updateTeller', [QueryController::class, 'updateTeller'])->name('sikas-query-updateteller');
    Route::post('/query/deleteTeller', [QueryController::class, 'deleteTeller'])->name('sikas-query-deleteteller');
    Route::post('/query/getPembayaranBulananSiswa', [QueryController::class, 'getPembayaranBulananSiswa'])->name('sikas-query--get-pembayaran-bulanan-siswa');
    Route::post('/query/postPembayaranAkademik', [QueryController::class, 'postPembayaranAkademik'])->name('sikas-query--post-pembayaran-akademik');
    Route::post('/query/postPembayaranDinamis', [QueryController::class, 'postPembayaranDinamis'])->name('sikas-query--post-pembayaran-dinamis');
    Route::post('/query/postPengajuanKeringanan', [QueryController::class, 'postPengajuanKeringanan'])->name('sikas-query--post-pengajuan-keringanan');
    Route::post('/query/postPengajuanPenambahan', [QueryController::class, 'postPengajuanPenambahan'])->name('sikas-query--post-pengajuan-penambahan');
    Route::post('/query/updatePengajuanKeringanan', [QueryController::class, 'updatePengajuanKeringanan'])->name('sikas-query--update-pengajuan-keringanan');
    Route::post('/query/updatePengajuanPenambahan', [QueryController::class, 'updatePengajuanPenambahan'])->name('sikas-query--update-pengajuan-penambahan');
    Route::post('/query/deletePengajuanKeringanan', [QueryController::class, 'deletePengajuanKeringanan'])->name('sikas-query--delete-pengajuan-keringanan');
    Route::post('/query/deletePengajuanPenambahan', [QueryController::class, 'deletePengajuanPenambahan'])->name('sikas-query--delete-pengajuan-penambahan');
    Route::post('/query/updateJabatan', [QueryController::class, 'updateJabatan'])->name('sikas-query-updatejabatan');
    Route::post('/query/deleteJabatan', [QueryController::class, 'deleteJabatan'])->name('sikas-query-deletejabatan');
    Route::post('/query/updateJurusan', [QueryController::class, 'updateJurusan'])->name('sikas-query-updatejurusan');
    Route::post('/query/deleteJurusan', [QueryController::class, 'deleteJurusan'])->name('sikas-query-deletejurusan');
    Route::post('/query/updateJenisPembayaran', [QueryController::class, 'updateJenisPembayaran'])->name('sikas-query-updatejenispembayaran');
    Route::post('/query/deleteJenisPembayaran', [QueryController::class, 'deleteJenisPembayaran'])->name('sikas-query-deletejenispembayaran');
    Route::post('/query/laporanPembayaranSpp', [QueryController::class, 'laporanPembayaranSpp'])->name('sikas-query-laporanpembayaranspp');
    Route::post('/query/laporanPembayaranSppKelas', [QueryController::class, 'laporanPembayaranSppKelas'])->name('sikas-query-laporanpembayaransppkelas');
    Route::post('/query/laporanPembayaranTabungan', [QueryController::class, 'laporanPembayaranTabungan'])->name('sikas-query-laporanpembayarantabungan');
    Route::post('/query/laporanPengajuanKeringanan', [QueryController::class, 'laporanPengajuanKeringanan'])->name('sikas-query-laporanpengajuankeringanan');
    Route::post('/query/laporanPengajuanPenambahan', [QueryController::class, 'laporanPengajuanPenambahan'])->name('sikas-query-laporanpengajuanpenambahan');
    Route::post('/query/laporanPemasukanLain', [QueryController::class, 'laporanPemasukanLain'])->name('sikas-query-laporanpemasukanlain');
    Route::post('/query/laporanPenggunaanDana', [QueryController::class, 'laporanPenggunaanDana'])->name('sikas-query-laporanpenggunaandana');
    Route::post('/query/laporan', [QueryController::class, 'laporan'])->name('sikas-query-laporan');
    Route::post('/query/changePassword', [QueryController::class, 'changePassword'])->name('sikas-query-changepassword');
    Route::post('/query/resetTahunAjar', [QueryController::class, 'resetTahunAjar'])->name('sikas-query-resettahunajar');
    Route::post('/query/getPembayaranDinamis', [QueryController::class, 'getPembayaranDinamis'])->name('sikas-query-get-pembayaran-dinamis');
    Route::post('/query/getHistoryPembayaranDinamis', [QueryController::class, 'getHistoryPembayaranDinamis'])->name('sikas-query-get-history-pembayaran-dinamis');
    Route::get('/query/getSidebarPembayaranDinamis', [QueryController::class, 'getSidebarPembayaranDinamis'])->name('sikas-query-get-sidebar-pembayaran-dinamis');
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
