<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\Group;
use App\Models\Media;
use App\Models\Pricing;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\Resources\Country as ResourcesCountry;
use App\Http\Resources\Media as ResourcesMedia;
use App\Http\Resources\Pricing as ResourcesPricing;
use App\Http\Resources\Type as ResourcesType;
use App\Http\Controllers\ApiClientManager;
use Carbon\Carbon;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
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
            // Select medias by type
            // -- PROGRAMS
            $medias_programs = $for_youth == 1 ? Media::where([['for_youth', $for_youth], ['type_id', 6], ['is_public', 1]])->orderByDesc('created_at')->paginate(12) : Media::where([['type_id', 6], ['is_public', 1]])->orderByDesc('created_at')->paginate(12);
            $medias_programs_preach = $for_youth == 1 ? Media::where('for_youth', $for_youth)->whereHas('categories', function ($query) {$query->whereIn('categories.id', [14]);})->where('medias.is_public', 1)->orderByDesc('medias.created_at')->paginate(12) : Media::whereHas('categories', function ($query) {$query->whereIn('categories.id', [14]);})->where('medias.is_public', 1)->orderByDesc('medias.created_at')->paginate(12);
            // -- FILMS
            $medias_films = $for_youth == 1 ? Media::where([['for_youth', $for_youth], ['type_id', 3], ['is_public', 1]])->orderByDesc('created_at')->paginate(12) : Media::where([['type_id', 3], ['is_public', 1]])->orderByDesc('created_at')->paginate(12);
            // -- CARTOONS
            $medias_cartoons = $for_youth == 1 ? Media::where([['for_youth', $for_youth], ['type_id', 19], ['is_public', 1]])->orderByDesc('created_at')->paginate(12) : Media::where([['type_id', 19], ['is_public', 1]])->orderByDesc('created_at')->paginate(12);
            // -- SERIES
            $medias_series = $for_youth == 1 ? Media::where([['for_youth', $for_youth], ['type_id', 4], ['is_public', 1]])->orderByDesc('created_at')->paginate(12) : Media::where([['type_id', 4], ['is_public', 1]])->orderByDesc('created_at')->paginate(12);
            // -- SONGS
            $medias_songs = $for_youth == 1 ? Media::where([['for_youth', $for_youth], ['type_id', 8], ['is_public', 1]])->orderByDesc('created_at')->paginate(12) : Media::where([['type_id', 8], ['is_public', 1]])->orderByDesc('created_at')->paginate(12);
            // -- ALBUMS
            $medias_albums = $for_youth == 1 ? Media::where([['for_youth', $for_youth], ['type_id', 7], ['is_public', 1]])->orderByDesc('created_at')->paginate(12) : Media::where([['type_id', 7], ['is_public', 1]])->orderByDesc('created_at')->paginate(12);
            // Select media trends
            $medias_trends = Media::getMediaSessions(date('Y'), $for_youth);
            // Select media lives
            $medias_lives = $for_youth == 1 ? Media::where([['for_youth', $for_youth], ['is_live', 1], ['type_id', 6], ['is_public', 1]])->orderByDesc('created_at')->paginate(12) : Media::where([['is_live', 1], ['type_id', 6], ['is_public', 1]])->orderByDesc('created_at')->paginate(12);
            // Select all countries
            $countries = Country::all();
            // Select all pricings
            $pricings = Pricing::all();
            // Select all types by group (Type de transaction)
            $group = Group::where('group_name->fr', 'Type de transaction')->first();
            $transaction_types = Type::where('group_id', $group->id)->get();

            View::share('api_client_manager', $api_client_manager);
            View::composer(['home', 'partials.media.programs'], function ($view) use ($medias_programs, $medias_programs_preach) {
                $view->with('programs', ResourcesMedia::collection($medias_programs)->toArray(request()));
                $view->with('preachs', ResourcesMedia::collection($medias_programs_preach)->toArray(request()));
                $view->with('lastPage_programs', $medias_programs->lastPage());
                $view->with('lastPage_preachs', $medias_programs_preach->lastPage());
            });
            View::composer(['home', 'partials.media.films'], function ($view) use ($medias_films) {
                $view->with('films', ResourcesMedia::collection($medias_films)->toArray(request()));
                $view->with('lastPage_films', $medias_films->lastPage());
            });
            View::composer(['home', 'partials.media.cartoons'], function ($view) use ($medias_cartoons) {
                $view->with('cartoons', ResourcesMedia::collection($medias_cartoons)->toArray(request()));
                $view->with('lastPage_cartoons', $medias_cartoons->lastPage());
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

            view()->composer('*', function ($view) use ($countries, $pricings, $transaction_types) {
                $view->with('current_locale', app()->getLocale());
                $view->with('available_locales', config('app.available_locales'));
                $view->with('countries', ResourcesCountry::collection($countries)->toArray(request()));
                $view->with('pricings', ResourcesPricing::collection($pricings)->toArray(request()));
                $view->with('transaction_types', ResourcesType::collection($transaction_types)->toArray(request()));
            });

        } else {
            $for_youth = session()->has('for_youth') ? session()->get('for_youth') : 1;
            // Select medias by type API
            // -- PROGRAMS
            $medias_programs = Media::where([['for_youth', $for_youth], ['type_id', 6], ['is_public', 1]])->orderByDesc('created_at')->paginate(12);
            $medias_programs_preach = Media::where('for_youth', $for_youth)->whereHas('categories', function ($query) {$query->whereIn('categories.id', [14]);})->where('medias.is_public', 1)->orderByDesc('medias.created_at')->paginate(12);
            // -- FILMS
            $medias_films = Media::where([['for_youth', $for_youth], ['type_id', 3], ['is_public', 1]])->orderByDesc('created_at')->paginate(12);
            // -- CARTOONS
            $medias_cartoons = Media::where([['for_youth', $for_youth], ['type_id', 19], ['is_public', 1]])->orderByDesc('created_at')->paginate(12);
            // -- SERIES
            $medias_series = Media::where([['for_youth', $for_youth], ['type_id', 4], ['is_public', 1]])->orderByDesc('created_at')->paginate(12);
            // -- SONGS
            $medias_songs = Media::where([['for_youth', $for_youth], ['type_id', 8], ['is_public', 1]])->orderByDesc('created_at')->paginate(12);
            // -- ALBUMS
            $medias_albums = Media::where([['for_youth', $for_youth], ['type_id', 7], ['is_public', 1]])->orderByDesc('created_at')->paginate(12);
            // Select media trends API
            $medias_trends = Media::getMediaSessions(date('Y'), $for_youth);
            // Select media lives API
            $medias_lives = Media::where([['for_youth', $for_youth], ['is_live', 1], ['type_id', 6], ['is_public', 1]])->orderByDesc('created_at')->paginate(12);
            // Select all countries
            $countries = Country::all();
            // Select all pricings
            $pricings = Pricing::all();
            // Select all types by group (Type de transaction)
            $group = Group::where('group_name->fr', 'Type de transaction')->first();
            $transaction_types = Type::where('group_id', $group->id)->get();

            View::share('api_client_manager', $api_client_manager);
            View::composer(['home', 'partials.media.programs'], function ($view) use ($medias_programs, $medias_programs_preach) {
                $view->with('programs', ResourcesMedia::collection($medias_programs)->toArray(request()));
                $view->with('preachs', ResourcesMedia::collection($medias_programs_preach)->toArray(request()));
                $view->with('lastPage_programs', $medias_programs->lastPage());
                $view->with('lastPage_preachs', $medias_programs_preach->lastPage());
            });
            View::composer(['home', 'partials.media.films'], function ($view) use ($medias_films) {
                $view->with('films', ResourcesMedia::collection($medias_films)->toArray(request()));
                $view->with('lastPage_films', $medias_films->lastPage());
            });
            View::composer(['home', 'partials.media.cartoons'], function ($view) use ($medias_cartoons) {
                $view->with('cartoons', ResourcesMedia::collection($medias_cartoons)->toArray(request()));
                $view->with('lastPage_cartoons', $medias_cartoons->lastPage());
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

            view()->composer('*', function ($view) use ($countries, $pricings, $transaction_types) {
                $view->with('current_locale', app()->getLocale());
                $view->with('available_locales', config('app.available_locales'));
                $view->with('countries', ResourcesCountry::collection($countries)->toArray(request()));
                $view->with('pricings', ResourcesPricing::collection($pricings)->toArray(request()));
                $view->with('transaction_types', ResourcesType::collection($transaction_types)->toArray(request()));
            });
        }
    }
}
