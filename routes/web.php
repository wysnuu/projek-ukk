<?php

use App\Models\User;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminUkuranController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\AdminTransaksiDetailController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminInfoController;
use App\Http\Controllers\KasirTransaksiController;
use App\Http\Controllers\KasirTransaksiDetailController;
use App\Http\Controllers\KasirInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\PasswordReset;

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

Route::get('/login', [AdminAuthController::class, 'index'])->name('login')->middleware('guest');
Route::get('/register', [AdminAuthController::class, 'register'])->name('register');
Route::post('/register/do', [AdminAuthController::class, 'doRegister'])->name('doRegister');
Route::post('/login/do', [AdminAuthController::class, 'doLogin'])->middleware('guest');
Route::get('/logout', [AdminAuthController::class, 'logout'])->middleware('auth');
Route::get('/forgot-password', function () {
    return view('admin.auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('admin.auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8',
        're_password' => 'required|same:password|min:8',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 're_password', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

Route::get('/', function () {
    $data = [
        'content' => 'admin.dashboard.index'
    ];
    return view('admin.layouts.wrapper', $data);
})->middleware('auth');

Route::prefix('/admin')->as('Admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $today = Carbon::today();
        $data = [
            'userCount' => \App\Models\User::count(),
            'kategori' => \App\Models\Kategori::count(),
            'produk' => \App\Models\Produk::count(),
            'ukuran' => \App\Models\Ukuran::count(),
            'totalTransaksi' => \App\Models\Transaksi::count(),
            'td' => \App\Models\Transaksi::whereDate('created_at', $today)->count(),
            'totalBiayaPembelian' => \App\Models\Transaksi::whereDate('created_at', $today)->sum('total'),
            'content' => 'admin.dashboard.index',
        ];
        return view('admin.layouts.wrapper', $data);
    });
    Route::group(['middleware' => ['auth', 'ceklevel:Admin']], function () {
        Route::resource('/kategori', AdminKategoriController::class);
        Route::resource('/ukuran', AdminUkuranController::class);
        Route::resource('/produk', AdminProdukController::class);
        Route::resource('/transaksi', AdminTransaksiController::class);
        Route::get('/transaksi', [AdminTransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/filter', [AdminTransaksiController::class, 'filter']);
        Route::post('/transaksi/detail/create', [AdminTransaksiDetailController::class, 'create']);
        Route::get('/transaksi/{id}/print', [AdminTransaksiController::class, 'print']);
        Route::get('/transaksi/{id}/print/all', [AdminTransaksiController::class, 'all']);
        Route::get('/transaksi/{id}/show', [AdminTransaksiController::class, 'show']);
        Route::get('/transaksi/detail/delete', [AdminTransaksiDetailController::class, 'delete']);
        Route::get('/transaksi/detail/selesai/{id}', [AdminTransaksiDetailController::class, 'done']);
        Route::get('/transaksi/detail/pending/{id}', [AdminTransaksiDetailController::class, 'pending']);
        Route::resource('/user', AdminUserController::class);
        Route::get('/info', [AdminInfoController::class, 'index']);
    });
});

Route::group(['middleware' => ['auth', 'ceklevel:Kasir']], function () {
    Route::prefix('/kasir')->as('Kasir')->middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            $today = Carbon::today();
            $data = [
                'userCount' => \App\Models\User::count(),
                'kategori' => \App\Models\Kategori::count(),
                'produk' => \App\Models\Produk::count(),
                'ukuran' => \App\Models\Ukuran::count(),
                'totalTransaksi' => \App\Models\Transaksi::count(),
                'td' => \App\Models\Transaksi::whereDate('created_at', $today)->count(),
                'totalBiayaPembelian' => \App\Models\Transaksi::whereDate('created_at', $today)->sum('total'),
                'content' => 'kasir.dashboard.index',
            ];
            return view('kasir.layouts.wrapper', $data);
        });
        Route::resource('/transaksi', KasirTransaksiController::class);
        Route::post('/transaksi/{id}/dibayarkan', [KasirTransaksiController::class, 'dibayarkan']);
        Route::post('/transaksi/detail/create', [KasirTransaksiDetailController::class, 'create']);
        Route::get('/transaksi/{id}/print', [KasirTransaksiController::class, 'print']);
        Route::get('/transaksi/{id}/show', [KasirTransaksiController::class, 'show']);
        Route::get('/transaksi/detail/delete', [KasirTransaksiDetailController::class, 'delete']);
        Route::get('/transaksi/detail/selesai/{id}', [KasirTransaksiDetailController::class, 'done']);
        Route::get('/transaksi/detail/pending/{id}', [KasirTransaksiDetailController::class, 'pending']);
        Route::get('/info', [KasirInfoController::class, 'index']);
    });
});
