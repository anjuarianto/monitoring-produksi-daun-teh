<?php

use App\Http\Controllers\AbsenKaryawanController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\BlokController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DaunController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\TimbanganController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return redirect('/login');
})->name('home');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//    data daun
    Route::get('/daun', [DaunController::class, 'index'])->name('daun.index');
    Route::get('/daun/{laporan_id}', [DaunController::class, 'show'])->name('daun.show');

//    opsi mandor
    Route::get('/opsi-mandor', [\App\Http\Controllers\OpsiMandorController::class, 'index'])->name('opsi-mandor.index');
    Route::get('/opsi-mandor/{id}/edit', [\App\Http\Controllers\OpsiMandorController::class, 'edit'])->name('opsi-mandor.edit');
    Route::put('/opsi-mandor/{id}', [\App\Http\Controllers\OpsiMandorController::class, 'update'])->name('opsi-mandor.update');

    Route::get('/laporan-table', [\App\Http\Controllers\LaporanTableController::class, 'index'])->name('laporan-table.index');
    Route::get('/laporan-table/{laporan}', [\App\Http\Controllers\LaporanTableController::class, 'show'])->name('laporan-table.show');
    Route::get('/laporan-table/{laporan}/export', [\App\Http\Controllers\LaporanTableController::class, 'export'])->name('laporan-table.export');
    Route::resource('laporan', LaporanController::class);
    Route::resource('absen-karyawan', AbsenKaryawanController::class);
    Route::resource('golongan', GolonganController::class);
    Route::resource('blok', BlokController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);

    Route::get('/produksi', [ProduksiController::class, 'index'])->name('produksi.index');
    Route::get('/produksi-hasil', [\App\Http\Controllers\ProduksiHasilController::class, 'index'])->name('produksi-hasil.index');
    Route::get('/laporan/timbangan/{timbangan}', [TimbanganController::class, 'show'])->name('timbangan.view');
    Route::get('/laporan/timbangan/{timbangan}/edit', [TimbanganController::class, 'edit'])->name('timbangan.edit');
    Route::put('/laporan/timbangan/{timbangan}', [TimbanganController::class, 'update'])->name('timbangan.update');

    Route::post('/hasil', [\App\Http\Controllers\HasilController::class, 'store'])->name('hasil.store');
    Route::put('/hasil/{hasil}', [\App\Http\Controllers\HasilController::class, 'update'])->name('hasil.update');
    Route::delete('/hasil/{hasil}', [\App\Http\Controllers\HasilController::class, 'destroy'])->name('hasil.destroy');

    Route::group(['prefix' => 'karyawan', 'as' => 'karyawan.'], function () {
        Route::get('/', [KaryawanController::class, 'index'])->name('index');
        Route::get('/show/{karyawan}', [KaryawanController::class, 'show'])->name('show');
        Route::get('/edit/{karyawan}', [KaryawanController::class, 'edit'])->name('edit');
        Route::put('/update/{karyawan}', [KaryawanController::class, 'update'])->name('update');
        Route::delete('{karyawan}', [KaryawanController::class, 'destroy'])->name('destroy');
    });


    Route::get('/profile/change-password', [PasswordController::class, 'edit'])->name('profile.change-password.edit');
    Route::put('/profile/change-password', [PasswordController::class, 'update'])->name('profile.change-password.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
