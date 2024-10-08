<?php
/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
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
|--------------------------------------------------------------------------
| ROUTES FOR EVERY ROLES
|--------------------------------------------------------------------------
*/
// Generate symbolic link
Route::get('/symlink', function () { return view('symlink'); })->name('generate_symlink');
// Clear cache
Route::get('/clear-cache', function() { $exitCode = Artisan::call('optimize:clear'); return redirect('/'); });
// Count views/likes
Route::get('/count', 'App\Http\Controllers\Web\HomeController@countActions')->name('count_actions');
// Choose age
Route::get('/choose_age/{for_youth}', function (Request $request, $for_youth) {
    // If user is connected
    if (Auth::check()) {
        // If it's a child, deconnect user and ask parental code
        if ($for_youth == 1) {
            session()->put('for_youth', $for_youth);

            return redirect()->back();
        }

        // If it's a child, deconnect user and ask parental code
        if ($for_youth == 0) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            session()->put('for_youth', $for_youth);

            return redirect('/login');
        }

    } else {
        session()->put('for_youth', $for_youth);

        if ($for_youth == 1) {
            return redirect('/');
        }

        if ($for_youth == 0) {
            return redirect()->back();
        }
    }

})->whereNumber('for_youth')->name('choose_age');
// Home
Route::get('/', 'App\Http\Controllers\Web\HomeController@index')->name('home');
Route::get('/language/{locale}', 'App\Http\Controllers\Web\HomeController@changeLanguage')->name('change_language');
Route::get('/search', 'App\Http\Controllers\Web\HomeController@search')->name('search');
Route::get('/notification', 'App\Http\Controllers\Web\HomeController@notification')->name('notification.home');
Route::post('/parental-code', 'App\Http\Controllers\Web\HomeController@parentalCode')->name('parental_code');
Route::get('/about', 'App\Http\Controllers\Web\HomeController@about')->name('about');
Route::get('/about/{entity}', 'App\Http\Controllers\Web\HomeController@aboutEntity')->name('about.entity');
Route::get('/media/{id}', 'App\Http\Controllers\Web\HomeController@mediaDatas')->whereNumber('id')->name('media.datas');
Route::get('/live', 'App\Http\Controllers\Web\HomeController@live')->name('live.home');
Route::get('/films', 'App\Http\Controllers\Web\HomeController@films')->name('films.home');
Route::get('/cartoons', 'App\Http\Controllers\Web\HomeController@cartoons')->name('cartoons.home');
Route::get('/series', 'App\Http\Controllers\Web\HomeController@series')->name('series.home');
Route::get('/programs', 'App\Http\Controllers\Web\HomeController@programs')->name('programs.home');
Route::get('/programs/{entity}', 'App\Http\Controllers\Web\HomeController@programsEntity')->name('programs.entity.home');
Route::get('/songs', 'App\Http\Controllers\Web\HomeController@songs')->name('songs.home');
Route::get('/books', 'App\Http\Controllers\Web\HomeController@books')->name('books.home');
Route::get('/books/{id}', 'App\Http\Controllers\Web\HomeController@bookDatas')->whereNumber('id')->name('book.datas');
Route::post('/action/{entity}', 'App\Http\Controllers\Web\HomeController@action')->name('action.entity');
// Donation
Route::get('/donation', 'App\Http\Controllers\Web\HomeController@donate')->name('donation');
Route::post('/donation', 'App\Http\Controllers\Web\HomeController@runDonate');
Route::get('/transaction_waiting', 'App\Http\Controllers\Web\HomeController@transactionWaiting')->name('transaction.waiting');
Route::get('/transaction_message/{orderNumber}/{userId}', 'App\Http\Controllers\Web\HomeController@transactionMessage')->name('transaction.message');
Route::get('/donated/{amount}/{currency}/{code}/{user_id}', 'App\Http\Controllers\Web\HomeController@donated')->whereNumber(['amount', 'code'])->name('donated');
// Account
Route::get('/account', 'App\Http\Controllers\Web\AccountController@account')->name('account');
Route::post('/account', 'App\Http\Controllers\Web\AccountController@updateAccount');
Route::get('/account/{entity}', 'App\Http\Controllers\Web\AccountController@accountEntity')->name('account.entity');
Route::post('/account/{entity}', 'App\Http\Controllers\Web\AccountController@updateAccountEntity');
Route::get('/account/{entity}/{id}', 'App\Http\Controllers\Web\AccountController@accountEntityDatas')->whereNumber('id')->name('account.entity.datas');
Route::get('/members/{id}', 'App\Http\Controllers\Web\AccountController@memberDetails')->whereNumber('id')->name('members');

/*
|--------------------------------------------------------------------------
| ROUTES FOR "Contrôleur"
|--------------------------------------------------------------------------
*/
// MediaControl
Route::get('/controller', 'App\Http\Controllers\Web\MediaControlController@index')->name('controller.home');
Route::get('/youth', 'App\Http\Controllers\Web\MediaControlController@youth')->name('controller.youth.home');
Route::get('/youth/{entity}', 'App\Http\Controllers\Web\MediaControlController@youthEntity')->name('controller.youth.entity');
Route::get('/youth/{entity}/{id}', 'App\Http\Controllers\Web\MediaControlController@youthEntityDatas')->whereNumber('id')->name('controller.youth.entity.datas');
Route::get('/adult', 'App\Http\Controllers\Web\MediaControlController@adult')->name('controller.adult.home');
Route::get('/adult/{entity}', 'App\Http\Controllers\Web\MediaControlController@adultEntity')->name('controller.adult.entity');
Route::get('/adult/{entity}/{id}', 'App\Http\Controllers\Web\MediaControlController@adultEntityDatas')->whereNumber('id')->name('controller.adult.entity.datas');

require __DIR__.'/auth.php';
