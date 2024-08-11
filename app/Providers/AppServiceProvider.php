<?php

namespace App\Providers;

use App\Http\Controllers\ApiClientManager;
use App\Http\Resources\Media as ResourcesMedia;
use App\Models\Cart;
use App\Models\Media;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Select a status by name API
        // $unread_status_name = 'Non%20lue';
        // $unread_status = $api_client_manager::call('GET', getApiURL() . '/status/search/fr/' . $unread_status_name);
        // Select medias by type API
        // -- PROGRAMS
        // $program_type_name = 'Programme%20TV';
        // $program_type = $api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $program_type_name);
        // -- FILMS
        // $film_type_name = 'Long%20métrage';
        // $film_type = $api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $film_type_name);
        // -- SERIES
        // $series_type_name = 'Série%20TV';
        // $series_type = $api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $series_type_name);
        // -- SONGS
        // $song_type_name = 'Chanson';
        // $song_type = $api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $song_type_name);
        // -- ALBUMS
        // $album_type_name = 'Album%20musique';
        // $album_type = $api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $album_type_name);

        // $user = $api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);

        // if (Auth::check()) {
        //     // Select a user API
        //     $for_youth = session()->has('for_youth') ? session()->get('for_youth') : (!empty(Auth::user()->birth_date) ? (Carbon::parse(Auth::user()->birth_date)->age < 18 ? 1 : 0) : 1);
        //     // Select all unread notifications API
        //     $notifications = $api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/11/' . Auth::user()->id, Auth::user()->api_token);
        //     // Select medias by type API
        //     // -- PROGRAMS
        //     $medias_programs = $api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/6' . '?page=' . request()->get('page'), null, null, request()->ip(), Auth::user()->id);
        //     // -- FILMS
        //     $medias_films = $api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/3' . '?page=' . request()->get('page'), null, null, request()->ip(), Auth::user()->id);
        //     // -- SERIES
        //     $medias_series = $api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/4' . '?page=' . request()->get('page'), null, null, request()->ip(), Auth::user()->id);
        //     // -- SONGS
        //     $medias_songs = $api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/8' . '?page=' . request()->get('page'), null, null, request()->ip(), Auth::user()->id);
        //     // -- ALBUMS
        //     $medias_albums = $api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/7' . '?page=' . request()->get('page'), null, null, request()->ip(), Auth::user()->id);
        //     // Select media trends API
        //     $medias_trends = $api_client_manager::call('GET', getApiURL() . '/media/trends/' . date('Y') . '/' . $for_youth);
        //     // Select media lives API
        //     $medias_lives = $api_client_manager::call('GET', getApiURL() . '/media/find_live/' . $for_youth . '?page=' . request()->get('page'), null, null, request()->ip(), Auth::user()->id);
        //     // Select a type by name API
        //     $watchlist_type_name = 'Watchlist';
        //     $watchlist_type = $api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $watchlist_type_name);
        //     // All user carts by type (Watchlist) API
        //     $user_watchlist = $api_client_manager::call('GET', getApiURL() . '/cart/find_by_type/' . Auth::user()->id . '/' . $watchlist_type->data->id, Auth::user()->api_token);

        //     View::share('api_client_manager', $api_client_manager);
        //     View::share('unread_notifications', $notifications->data);
        //     View::composer(['home', 'partials.media.programs'], function ($view) use ($medias_programs) {
        //         $view->with('programs', $medias_programs->data);
        //         $view->with('lastPage_programs', $medias_programs->lastPage);
        //     });
        //     View::composer(['home', 'partials.media.films'], function ($view) use ($medias_films) {
        //         $view->with('films', $medias_films->data);
        //         $view->with('lastPage_films', $medias_films->lastPage);
        //     });
        //     View::composer(['home', 'partials.media.series'], function ($view) use ($medias_series) {
        //         $view->with('series', $medias_series->data);
        //         $view->with('lastPage_series', $medias_series->lastPage);
        //     });
        //     View::composer(['home', 'partials.media.songs'], function ($view) use ($medias_albums, $medias_songs) {
        //         $view->with('albums', $medias_albums->data);
        //         $view->with('songs', $medias_songs->data);
        //         $view->with('lastPage_songs', $medias_songs->lastPage);
        //     });
        //     View::composer(['home', 'partials.media.live'], function ($view) use ($medias_trends, $medias_lives) {
        //         $view->with('trends', $medias_trends->data);
        //         $view->with('lives', $medias_lives->data);
        //         $view->with('lastPage_lives', $medias_lives->lastPage);
        //     });

        //     view()->composer('*', function ($view) use ($user_watchlist) {
        //         $view->with('current_locale', app()->getLocale());
        //         $view->with('available_locales', config('app.available_locales'));
        //         $view->with('watchlist', $user_watchlist->data);
        //         $view->with('watchlist_id', $user_watchlist->data->id);
        //     });

        // } else {
        //     $for_youth = session()->has('for_youth') ? session()->get('for_youth') : 1;
        //     // Select medias by type API
        //     // -- PROGRAMS
        //     $medias_programs = $api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/6' . '?page=' . request()->get('page'), null, null, request()->ip());
        //     // -- FILMS
        //     $medias_films = $api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/3' . '?page=' . request()->get('page'), null, null, request()->ip());
        //     // -- SERIES
        //     $medias_series = $api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/4' . '?page=' . request()->get('page'), null, null, request()->ip());
        //     // -- SONGS
        //     $medias_songs = $api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/8' . '?page=' . request()->get('page'), null, null, request()->ip());
        //     // -- ALBUMS
        //     $medias_albums = $api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/7' . '?page=' . request()->get('page'), null, null, request()->ip());
        //     // Select media trends API
        //     $medias_trends = $api_client_manager::call('GET', getApiURL() . '/media/trends/' . date('Y') . '/' . $for_youth);
        //     // Select media lives API
        //     $medias_lives = $api_client_manager::call('GET', getApiURL() . '/media/find_live/' . $for_youth . '?page=' . request()->get('page'), null, null, request()->ip(), null);

        //     View::share('api_client_manager', $api_client_manager);
        //     View::composer(['home', 'partials.media.programs'], function ($view) use ($medias_programs) {
        //         $view->with('programs', $medias_programs->data);
        //         $view->with('lastPage_programs', $medias_programs->lastPage);
        //     });
        //     View::composer(['home', 'partials.media.films'], function ($view) use ($medias_films) {
        //         $view->with('films', $medias_films->data);
        //         $view->with('lastPage_films', $medias_films->lastPage);
        //     });
        //     View::composer(['home', 'partials.media.series'], function ($view) use ($medias_series) {
        //         $view->with('series', $medias_series->data);
        //         $view->with('lastPage_series', $medias_series->lastPage);
        //     });
        //     View::composer(['home', 'partials.media.songs'], function ($view) use ($medias_albums, $medias_songs) {
        //         $view->with('albums', $medias_albums->data);
        //         $view->with('songs', $medias_songs->data);
        //         $view->with('lastPage_songs', $medias_songs->lastPage);
        //     });
        //     View::composer(['home', 'partials.media.live'], function ($view) use ($medias_trends, $medias_lives) {
        //         $view->with('trends', $medias_trends->data);
        //         $view->with('lives', $medias_lives->data);
        //         $view->with('lastPage_lives', $medias_lives->lastPage);
        //     });

        //     view()->composer('*', function ($view) {
        //         $view->with('current_locale', app()->getLocale());
        //         $view->with('available_locales', config('app.available_locales'));
        //     });
        // }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $api_client_manager = new ApiClientManager();

        if (Auth::check()) {
            // Select a user
            $for_youth = session()->has('for_youth') ? session()->get('for_youth') : (!empty(Auth::user()->birth_date) ? (Carbon::parse(Auth::user()->birth_date)->age < 18 ? 1 : 0) : 1);
            // Select all unread notifications
            $notifications = Notification::where([['status_id', 11], ['user_id', Auth::user()->id]])->orderByDesc('created_at')->get();
            // Select medias by type
            // -- PROGRAMS
            $medias_programs = Media::where([['for_youth', $for_youth], ['type_id', 6]])->orderByDesc('created_at')->paginate(12);
            // -- FILMS
            $medias_films = Media::where([['for_youth', $for_youth], ['type_id', 3]])->orderByDesc('created_at')->paginate(12);
            // -- SERIES
            $medias_series = Media::where([['for_youth', $for_youth], ['type_id', 4]])->orderByDesc('created_at')->paginate(12);
            // -- SONGS
            $medias_songs = Media::where([['for_youth', $for_youth], ['type_id', 8]])->orderByDesc('created_at')->paginate(12);
            // -- ALBUMS
            $medias_albums = Media::where([['for_youth', $for_youth], ['type_id', 7]])->orderByDesc('created_at')->paginate(12);
            // Select media trends
            $medias_trends = Media::where('for_youth', $for_youth)->whereHas('sessions', function ($query) {$query->whereYear('sessions.created_at', '=', date('Y'));})->distinct()->orderByDesc('created_at')->limit(5)->get();
            // Select media lives
            $medias_lives = Media::where([['for_youth', $for_youth], ['is_live', 1], ['type_id', 6]])->orderByDesc('created_at')->paginate(12);
            // Select user watchlist
            $user_watchlist = Cart::where([['user_id', Auth::user()->id], ['type_id', 14]])->first();

            if (is_null($user_watchlist)) {
                $user_watchlist = Cart::create([
                    'type_id' => 14,
                    'user_id' => Auth::user()->id
                ]);
            }

            View::share('api_client_manager', $api_client_manager);
            View::share('unread_notifications', $notifications);
            View::composer(['home', 'partials.media.programs'], function ($view) use ($medias_programs) {
                $view->with('programs', ResourcesMedia::collection($medias_programs)->toArray(request()));
                $view->with('lastPage_programs', $medias_programs->lastPage());
            });
            View::composer(['home', 'partials.media.films'], function ($view) use ($medias_films) {
                $view->with('films', ResourcesMedia::collection($medias_films)->toArray(request()));
                $view->with('lastPage_films', $medias_films->lastPage());
            });
            View::composer(['home', 'partials.media.series'], function ($view) use ($medias_series) {
                $view->with('series', ResourcesMedia::collection($medias_series)->toArray(request()));
                $view->with('lastPage_series', $medias_series->lastPage());
            });
            View::composer(['home', 'partials.media.songs'], function ($view) use ($medias_albums, $medias_songs) {
                $view->with('albums', ResourcesMedia::collection($medias_albums)->toArray(request()));
                $view->with('songs', ResourcesMedia::collection($medias_songs)->toArray(request()));
                $view->with('lastPage_songs', $medias_songs->lastPage());
            });
            View::composer(['home', 'partials.media.live'], function ($view) use ($medias_trends, $medias_lives) {
                $view->with('trends', ResourcesMedia::collection($medias_trends)->toArray(request()));
                $view->with('lives', ResourcesMedia::collection($medias_lives)->toArray(request()));
                $view->with('lastPage_lives', $medias_lives->lastPage());
            });

            view()->composer('*', function ($view) use ($user_watchlist) {
                $view->with('current_locale', app()->getLocale());
                $view->with('available_locales', config('app.available_locales'));
                $view->with('watchlist', $user_watchlist);
                $view->with('watchlist_id', $user_watchlist->id);
            });

        } else {
            $for_youth = session()->has('for_youth') ? session()->get('for_youth') : 1;
            // Select medias by type API
            // -- PROGRAMS
            $medias_programs = Media::where([['for_youth', $for_youth], ['type_id', 6]])->orderByDesc('created_at')->paginate(12);
            // -- FILMS
            $medias_films = Media::where([['for_youth', $for_youth], ['type_id', 3]])->orderByDesc('created_at')->paginate(12);
            // -- SERIES
            $medias_series = Media::where([['for_youth', $for_youth], ['type_id', 4]])->orderByDesc('created_at')->paginate(12);
            // -- SONGS
            $medias_songs = Media::where([['for_youth', $for_youth], ['type_id', 8]])->orderByDesc('created_at')->paginate(12);
            // -- ALBUMS
            $medias_albums = Media::where([['for_youth', $for_youth], ['type_id', 7]])->orderByDesc('created_at')->paginate(12);
            // Select media trends API
            $medias_trends = Media::where('for_youth', $for_youth)->whereHas('sessions', function ($query) {$query->whereYear('sessions.created_at', '=', date('Y'));})->distinct()->orderByDesc('created_at')->limit(5)->get();
            // Select media lives API
            $medias_lives = Media::where([['for_youth', $for_youth], ['is_live', 1], ['type_id', 6]])->orderByDesc('created_at')->paginate(12);

            View::share('api_client_manager', $api_client_manager);
            View::composer(['home', 'partials.media.programs'], function ($view) use ($medias_programs) {
                $view->with('programs', ResourcesMedia::collection($medias_programs)->toArray(request()));
                $view->with('lastPage_programs', $medias_programs->lastPage());
            });
            View::composer(['home', 'partials.media.films'], function ($view) use ($medias_films) {
                $view->with('films', ResourcesMedia::collection($medias_films)->toArray(request()));
                $view->with('lastPage_films', $medias_films->lastPage());
            });
            View::composer(['home', 'partials.media.series'], function ($view) use ($medias_series) {
                $view->with('series', ResourcesMedia::collection($medias_series)->toArray(request()));
                $view->with('lastPage_series', $medias_series->lastPage());
            });
            View::composer(['home', 'partials.media.songs'], function ($view) use ($medias_albums, $medias_songs) {
                $view->with('albums', ResourcesMedia::collection($medias_albums)->toArray(request()));
                $view->with('songs', ResourcesMedia::collection($medias_songs)->toArray(request()));
                $view->with('lastPage_songs', $medias_songs->lastPage());
            });
            View::composer(['home', 'partials.media.live'], function ($view) use ($medias_trends, $medias_lives) {
                $view->with('trends', ResourcesMedia::collection($medias_trends)->toArray(request()));
                $view->with('lives', ResourcesMedia::collection($medias_lives)->toArray(request()));
                $view->with('lastPage_lives', $medias_lives->lastPage());
            });

            view()->composer('*', function ($view) {
                $view->with('current_locale', app()->getLocale());
                $view->with('available_locales', config('app.available_locales'));
            });
        }
    }
}
