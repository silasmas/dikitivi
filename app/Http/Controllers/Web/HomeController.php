<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiClientManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class HomeController extends Controller
{
    public static $api_client_manager;

    public function __construct()
    {
        $this::$api_client_manager = new ApiClientManager();
    }

    // ==================================== HTTP GET METHODS ====================================
    /**
     * GET: Change language
     *
     * @param  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeLanguage($locale)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }

    /**
     * GET: Welcome/Home page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Select a status by name API
        $unread_status_name = 'Non lue';
        $unread_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/fr/' . $unread_status_name);
        // Select types by thier names API
        // -- FILMS
        $film_type_name = 'Long métrage';
        $film_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $film_type_name);
        // -- SERIES
        $series_type_name = 'Série TV';
        $series_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $series_type_name);
        // -- PROGRAMS
        $program_type_name = 'Programme TV';
        $program_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $program_type_name);
        // -- SONGS
        $song_type_name = 'Chanson';
        $song_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $song_type_name);
        // -- ALBUMS
        $album_type_name = 'Album musique';
        $album_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $album_type_name);

        if (session()->has('for_youth')) {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);
                // Select media trends API
                $medias_trends = $this::$api_client_manager::call('GET', getApiURL() . '/media/trends/' . date('Y') . '/' . $for_youth);
                // Select media lives API
                $medias_lives = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_live/' . $for_youth, null, null, $request->ip(), Auth::user()->id);
                // Select medias by type API
                // -- FILMS
                $medias_films = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $film_type->data->id, null, null, $request->ip(), Auth::user()->id);
                // -- SERIES
                $medias_series = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $series_type->data->id, null, null, $request->ip(), Auth::user()->id);
                // -- PROGRAMS
                $medias_programs = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $program_type->data->id, null, null, $request->ip(), Auth::user()->id);
                // -- SONGS
                $medias_songs = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $song_type->data->id, null, null, $request->ip(), Auth::user()->id);
                // -- ALBUMS
                $medias_albums = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $album_type->data->id, null, null, $request->ip(), Auth::user()->id);
                // Slides data
                $slides_data = array_merge((array_slice($medias_lives->data, 0, 2)), (array_slice($medias_series->data, 0, 2)), (array_slice($medias_albums->data, 0, 2)));

                return view('home', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user,
                    'unread_notifications' => $notifications->data,
                    'trends' => $medias_trends->data,
                    'lives' => $medias_lives->data,
                    'films' => $medias_films->data,
                    'series' => $medias_series->data,
                    'programs' => $medias_programs->data,
                    'songs' => $medias_songs->data,
                    'slides_data' => $slides_data,
                    'api_client_manager' => $this::$api_client_manager,
                ]);

            } else {
                return redirect()->route('login');
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);
                // Select media trends API
                $medias_trends = $this::$api_client_manager::call('GET', getApiURL() . '/media/trends/' . date('Y') . '/' . $for_youth);
                // Select media lives API
                $medias_lives = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_live/' . $for_youth, null, null, $request->ip(), Auth::user()->id);
                // Select medias by type API
                // -- FILMS
                $medias_films = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $film_type->data->id, null, null, $request->ip(), Auth::user()->id);
                // -- SERIES
                $medias_series = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $series_type->data->id, null, null, $request->ip(), Auth::user()->id);
                // -- PROGRAMS
                $medias_programs = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $program_type->data->id, null, null, $request->ip(), Auth::user()->id);
                // -- SONGS
                $medias_songs = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $song_type->data->id, null, null, $request->ip(), Auth::user()->id);
                // -- ALBUMS
                $medias_albums = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $album_type->data->id, null, null, $request->ip(), Auth::user()->id);
                // Slides data
                $slides_data = array_merge((array_slice($medias_lives->data, 0, 2)), (array_slice($medias_series->data, 0, 2)), (array_slice($medias_albums->data, 0, 2)));

                return view('home', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user,
                    'unread_notifications' => $notifications->data,
                    'trends' => $medias_trends->data,
                    'lives' => $medias_lives->data,
                    'films' => $medias_films->data,
                    'series' => $medias_series->data,
                    'programs' => $medias_programs->data,
                    'songs' => $medias_songs->data,
                    'slides_data' => $slides_data,
                    'api_client_manager' => $this::$api_client_manager,
                ]);

            } else {
                return view('welcome');
            }
        }
    }

    /**
     * GET: Media details page
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function mediaDatas(Request $request, $id)
    {
        // Select a status by name API
        $unread_status_name = 'Non lue';
        $unread_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/fr/' . $unread_status_name);
        // All media views API
        $views = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_views/' . $id);
        // All media likes API
        $likes = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_likes/' . $id);
        // Select a type by name API
        $watchlist_type_name = 'Watchlist';
        $watchlist_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $watchlist_type_name);

        if (session()->has('for_youth')) {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);
                // Select the current media API
                $current_media = $this::$api_client_manager::call('GET', getApiURL() . '/media/' . $id, Auth::user()->api_token, null, $request->ip(), Auth::user()->id);
                // Select other medias by current media type ID
                $other_medias = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $current_media->data->type->id, Auth::user()->api_token, null, $request->ip(), Auth::user()->id);
                // All user carts by type (Watchlist) API
                $user_watchlist = $this::$api_client_manager::call('GET', getApiURL() . '/cart/find_by_type/' . Auth::user()->id . '/' . $watchlist_type->data->id . '/', Auth::user()->api_token);

                if ($for_youth == 1 AND $for_youth != $current_media->data->for_youth) {
                    return redirect('/')->with('error_message', __('miscellaneous.adult_content'));

                } else {
                    return view('partials.media.datas', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user,
                        'unread_notifications' => $notifications->data,
                        'current_media' => $current_media->data,
                        'other_medias' => $other_medias->data,
                        'views' => $views->data,
                        'likes' => $likes->data,
                        'watchlist' => $user_watchlist->data->orders,
                        'api_client_manager' => $this::$api_client_manager,
                    ]);
                }

            } else {
                return redirect()->route('login');
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);
                // Select the current media API
                $current_media = $this::$api_client_manager::call('GET', getApiURL() . '/media/' . $id, Auth::user()->api_token, null, $request->ip(), Auth::user()->id);
                // Select other medias by current media type ID
                $other_medias = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $current_media->data->type->id, Auth::user()->api_token, null, $request->ip(), Auth::user()->id);
                // All user carts by type (Watchlist) API
                $user_watchlist = $this::$api_client_manager::call('GET', getApiURL() . '/cart/find_by_type/' . Auth::user()->id . '/' . $watchlist_type->data->id . '/', Auth::user()->api_token);

                if ($for_youth == 1 AND $for_youth != $current_media->data->for_youth) {
                    return redirect('/')->with('error_message', __('miscellaneous.adult_content'));

                } else {
                    return view('partials.media.datas', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user,
                        'unread_notifications' => $notifications->data,
                        'current_media' => $current_media->data,
                        'other_medias' => $other_medias->data,
                        'views' => $views->data,
                        'likes' => $likes->data,
                        'watchlist' => $user_watchlist->data->orders,
                        'api_client_manager' => $this::$api_client_manager,
                    ]);
                }

            } else {
                Session::put('url.intended', URL::previous());

                return view('welcome');
            }
        }
    }

    /**
     * GET: Media lives
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function live(Request $request)
    {
        // Select a status by name API
        $unread_status_name = 'Non lue';
        $unread_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/fr/' . $unread_status_name);

        if (session()->has('for_youth')) {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);
                // Select media lives API
                $medias_lives = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_live/' . $for_youth . '?page=' . $request->get('page'), null, null, $request->ip(), Auth::user()->id);

                return view('partials.media.live', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user,
                    'unread_notifications' => $notifications->data,
                    'lives' => $medias_lives->data,
                    'lastPage' => $medias_lives->lastPage,
                    'api_client_manager' => $this::$api_client_manager,
                ]);

            } else {
                return redirect()->route('login');
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);
                // Select media lives API
                $medias_lives = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_live/' . $for_youth . '?page=' . $request->get('page'), null, null, $request->ip(), Auth::user()->id);

                return view('partials.media.live', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user,
                    'unread_notifications' => $notifications->data,
                    'lives' => $medias_lives->data,
                    'lastPage' => $medias_lives->lastPage,
                    'api_client_manager' => $this::$api_client_manager,
                ]);

            } else {
                Session::put('url.intended', URL::previous());

                return view('welcome');
            }
        }
    }

    /**
     * GET: Media films
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function films(Request $request)
    {
        // Select a status by name API
        $unread_status_name = 'Non lue';
        $unread_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/fr/' . $unread_status_name);
        // Select a media by type API
        $film_type_name = 'Long métrage';
        $film_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $film_type_name);

        if (session()->has('for_youth')) {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);
                // Select medias by type API
                $medias_films = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $film_type->data->id . '?page=' . $request->get('page'), null, null, $request->ip(), Auth::user()->id);

                return view('partials.media.films', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user,
                    'unread_notifications' => $notifications->data,
                    'films' => $medias_films->data,
                    'lastPage' => $medias_films->lastPage,
                    'api_client_manager' => $this::$api_client_manager,
                ]);

            } else {
                return redirect()->route('login');
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);
                // Select medias by type API
                $medias_films = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $film_type->data->id . '?page=' . $request->get('page'), null, null, $request->ip(), Auth::user()->id);

                return view('partials.media.films', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user,
                    'unread_notifications' => $notifications->data,
                    'films' => $medias_films->data,
                    'lastPage' => $medias_films->lastPage,
                    'api_client_manager' => $this::$api_client_manager,
                ]);

            } else {
                Session::put('url.intended', URL::previous());

                return view('welcome');
            }
        }
    }

    /**
     * GET: Media series
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function series(Request $request)
    {
        // Select a status by name API
        $unread_status_name = 'Non lue';
        $unread_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/fr/' . $unread_status_name);
        // Select a media by type API
        $series_type_name = 'Série TV';
        $series_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $series_type_name);

        if (session()->has('for_youth')) {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);
                // Select medias by type API
                $medias_series = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $series_type->data->id . '?page=' . $request->get('page'), null, null, $request->ip(), Auth::user()->id);

                return view('partials.media.series', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user,
                    'unread_notifications' => $notifications->data,
                    'series' => $medias_series->data,
                    'lastPage' => $medias_series->lastPage,
                    'api_client_manager' => $this::$api_client_manager,
                ]);

            } else {
                return redirect()->route('login');
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);

                // Select medias by type API
                $medias_series = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $series_type->data->id . '?page=' . $request->get('page'), null, null, $request->ip(), Auth::user()->id);

                return view('partials.media.series', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user,
                    'unread_notifications' => $notifications->data,
                    'series' => $medias_series->data,
                    'lastPage' => $medias_series->lastPage,
                    'api_client_manager' => $this::$api_client_manager,
                ]);

            } else {
                Session::put('url.intended', URL::previous());

                return view('welcome');
            }
        }
    }

    /**
     * GET: Media programs
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function programs(Request $request)
    {
        // Select a status by name API
        $unread_status_name = 'Non lue';
        $unread_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/fr/' . $unread_status_name);
        // Select a media by type API
        $program_type_name = 'Programme TV';
        $program_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $program_type_name);

        if (session()->has('for_youth')) {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);
                // Select medias by type API
                $medias_programs = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $program_type->data->id . '?page=' . $request->get('page'), null, null, $request->ip(), Auth::user()->id);

                return view('partials.media.programs', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user,
                    'unread_notifications' => $notifications->data,
                    'programs' => $medias_programs->data,
                    'lastPage' => $medias_programs->lastPage,
                    'api_client_manager' => $this::$api_client_manager,
                ]);

            } else {
                return redirect()->route('login');
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);
                // Select medias by type API
                $medias_programs = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $program_type->data->id . '?page=' . $request->get('page'), null, null, $request->ip(), Auth::user()->id);

                return view('partials.media.programs', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user,
                    'unread_notifications' => $notifications->data,
                    'programs' => $medias_programs->data,
                    'lastPage' => $medias_programs->lastPage,
                    'api_client_manager' => $this::$api_client_manager,
                ]);

            } else {
                Session::put('url.intended', URL::previous());

                return view('welcome');
            }
        }
    }

    /**
     * GET: Media programs
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function programsEntity(Request $request, $entity)
    {
        // Select a status by name API
        $unread_status_name = 'Non lue';
        $unread_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/fr/' . $unread_status_name);
        // Select a category by name API
        $preach_category_name = 'Prédication';
        $preach_category = $this::$api_client_manager::call('GET', getApiURL() . '/category/search/fr/' . $preach_category_name);

        if (session()->has('for_youth')) {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);

                if ($entity == 'preach') {
                    // Select medias by categories API
                    $medias_preachs = $this::$api_client_manager::call('POST', getApiURL() . '/media/filter_by_categories/' . $for_youth . '?page=' . $request->get('page'), null, ['categories_ids' => [$preach_category->data->id]], $request->ip(), Auth::user()->id);

                    return view('partials.media.programs', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user,
                        'unread_notifications' => $notifications->data,
                        'preachs' => $medias_preachs->data,
                        'lastPage' => $medias_preachs->lastPage,
                        'api_client_manager' => $this::$api_client_manager,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.menu.preach'),
                    ]);
                }

            } else {
                return redirect()->route('login');
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);

                if ($entity == 'preach') {
                    // Select medias by categories API
                    $medias_preachs = $this::$api_client_manager::call('POST', getApiURL() . '/media/filter_by_categories/' . $for_youth . '?page=' . $request->get('page'), null, ['categories_ids' => [$preach_category->data->id]], $request->ip(), Auth::user()->id);

                    return view('partials.media.programs', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user,
                        'unread_notifications' => $notifications->data,
                        'preachs' => $medias_preachs->data,
                        'lastPage' => $medias_preachs->lastPage,
                        'api_client_manager' => $this::$api_client_manager,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.menu.preach'),
                    ]);
                }

            } else {
                Session::put('url.intended', URL::previous());

                return view('welcome');
            }
        }
    }

    /**
     * GET: Media songs
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function songs(Request $request)
    {
        // Select a status by name API
        $unread_status_name = 'Non lue';
        $unread_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/fr/' . $unread_status_name);
        // Select a media by type API
        $song_type_name = 'Chanson';
        $song_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $song_type_name);

        if (session()->has('for_youth')) {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);
                // Select medias by type API
                $medias_songs = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $song_type->data->id . '?page=' . $request->get('page'), null, null, $request->ip(), Auth::user()->id);

                return view('partials.media.songs', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user,
                    'unread_notifications' => $notifications->data,
                    'songs' => $medias_songs->data,
                    'lastPage' => $medias_songs->lastPage,
                    'api_client_manager' => $this::$api_client_manager,
                ]);

            } else {
                return redirect()->route('login');
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);
                // Select medias by type API
                $medias_songs = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $song_type->data->id . '?page=' . $request->get('page'), null, null, $request->ip(), Auth::user()->id);

                return view('partials.media.songs', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user,
                    'unread_notifications' => $notifications->data,
                    'songs' => $medias_songs->data,
                    'lastPage' => $medias_songs->lastPage,
                    'api_client_manager' => $this::$api_client_manager,
                ]);

            } else {
                Session::put('url.intended', URL::previous());

                return view('welcome');
            }
        }
    }

    /**
     * GET: Donation page
     *
     * @return \Illuminate\View\View
     */
    public function donate()
    {
        // Select all types by group API
        $transaction_types_name = 'Type de transaction';
        $transaction_types = $this::$api_client_manager::call('GET', getApiURL() . '/type/find_by_group/fr/' . $transaction_types_name);
        // Select all countries API
        $countries = $this::$api_client_manager::call('GET', getApiURL() . '/country');
        // Select all pricings API
        $pricings = $this::$api_client_manager::call('GET', getApiURL() . '/pricing');

        return view('donate', [
            'transaction_types' => $transaction_types->data,
            'countries' => $countries->data,
            'pricings' => $pricings->data
        ]);
    }

    /**
     * GET: About page
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        $titles = Lang::get('miscellaneous.public.about.content.titles');

        return view('about', ['titles' => $titles]);
    }

    /**
     * GET: About, inner pages
     *
     * @return \Illuminate\View\View
     */
    public function aboutEntity($entity)
    {
        $titles = Lang::get('miscellaneous.public.about.' . $entity . '.titles');
		$types = $this::$api_client_manager::call('GET', getApiURL() . '/type/find_by_group/fr/Type de média');
		$albums = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_type/fr/Album musique');
		$series = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_type/fr/Série TV');
		$medias = (collect($albums->data))->merge(collect($series->data));
		$categories = $this::$api_client_manager::call('GET', getApiURL() . '/category');
		$all_medias = $this::$api_client_manager::call('GET', getApiURL() . '/media?page=' . request()->get('page'));

		if (request()->has('id')) {
			$media = $this::$api_client_manager::call('GET', getApiURL() . '/media/' . request()->get('id'));

			return view('about', [
				'titles' => $titles,
				'entity' => $entity,
				'types' => $types->data,
				'belonging_medias' => $medias,
				'current_media' => $media->data,
				'categories' => $categories->data,
				'all_medias' => $all_medias->data,
                'lastPage' => $all_medias->lastPage,
				'entity' => $entity,
				'entity_title' => __('miscellaneous.public.about.' . $entity . '.title'),
				'entity_menu' => __('miscellaneous.menu.' . $entity),
			]);

		} else {
			return view('about', [
				'titles' => $titles,
				'entity' => $entity,
				'types' => $types->data,
				'belonging_medias' => $medias,
				'categories' => $categories->data,
				'all_medias' => $all_medias->data,
                'lastPage' => $all_medias->lastPage,
				'entity' => $entity,
				'entity_title' => __('miscellaneous.public.about.' . $entity . '.title'),
				'entity_menu' => __('miscellaneous.menu.' . $entity),
			]);
		}
    }

    /**
     * Display the message about transaction in waiting.
     *
     * @return \Illuminate\View\View
     */
    public function transactionWaiting()
    {
        return view('transaction_message');
    }

    /**
     * Display the message about transaction done.
     *
     * @return \Illuminate\View\View
     */
    public function transactionMessage($order_number, $user_id)
    {
        if (is_numeric($user_id)) {
            // Find payment by order number and user ID API
            $payment2 = $this::$api_client_manager::call('GET', getApiURL() . '/payment/find_by_order_number_user/' . $order_number . '/' . $user_id);

            return view('transaction_message', [
                'message_content' => __('miscellaneous.transaction_done'),
                'status_code' => (string) $payment2->data->status->id,
                'payment' => $payment2->data,
            ]);

        } else {
            // Find payment by order number API
            $payment1 = $this::$api_client_manager::call('GET', getApiURL() . '/payment/find_by_order_number/' . $order_number);

            return view('transaction_message', [
                'message_content' => __('miscellaneous.transaction_done'),
                'status_code' => (string) $payment1->data->status->id,
                'payment' => $payment1->data,
            ]);
        }
    }

    /**
     * GET: Current user account
     *
     * @param $amount
     * @param $currency
     * @param $code
     * @param $user_id
     * @return \Illuminate\View\View
     */
    public function donated($amount = null, $currency = null, $code, $user_id)
    {
        // Find status by name API
        $failed_status_name = 'Echoué';
        $failed_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/fr/' . $failed_status_name);

        if ($code == '0') {
            return view('transaction_message', [
                'status_code' => $code,
                'message_content' => __('notifications.processing_succeed'),
            ]);
        }

        if ($code == '1') {
            // Find payment by order number API
            $payment = $this::$api_client_manager::call('GET', getApiURL() . '/payment/find_by_order_number/' . Session::get('order_number'));

            if ($payment->success) {
                // Update payment status API
                $this::$api_client_manager::call('PUT', getApiURL() . '/payment/switch_status/' . $payment->data->id . '/' . $failed_status->data->id);
            }

            return view('transaction_message', [
                'status_code' => $code,
                'message_content' => __('notifications.process_canceled'),
            ]);
        }

        if ($code == '2') {
            // Find payment by order number API
            $payment = $this::$api_client_manager::call('GET', getApiURL() . '/payment/find_by_order_number/' . Session::get('order_number'));

            if ($payment->success) {
                // Update payment status API
                $this::$api_client_manager::call('PUT', getApiURL() . '/payment/switch_status/' . $payment->data->id . '/' . $failed_status->data->id);
            }

            return view('transaction_message', [
                'status_code' => $code,
                'message_content' => __('notifications.process_failed'),
            ]);
        }
    }

    // ==================================== HTTP POST METHODS ====================================
    /**
     * POST: Register offer
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function runDonate(Request $request)
    {
        $inputs = [
            'transaction_type_id' => $request->transaction_type_id,
            'pricing_id' => !empty($request->select_pricing) && is_numeric($request->select_pricing) ? $request->select_pricing : null,
            'amount' => $request->register_amount,
            'currency' => $request->select_currency,
            'other_phone' => $request->other_phone_code . $request->other_phone_number,
            'app_url' => $request->app_url,
            'user_id' => !empty($request->user_id) ? $request->user_id : null,
        ];
        // Find type by name API
        // -- MOBILE MONEY
        $mobile_money_type_name = 'Mobile money';
        $mobile_money_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $mobile_money_type_name);
        // -- BANK CARD
        $bank_card_type_name = 'Carte bancaire';
        $bank_card_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $bank_card_type_name);

        if ($inputs['transaction_type_id'] == null) {
            return redirect()->back()->with('error_message', __('miscellaneous.transaction_type_error'));
        }

        if ($inputs['transaction_type_id'] != null) {
            if ($inputs['transaction_type_id'] == $mobile_money_type->data->id) {
                if ($request->other_phone_code == null or $request->other_phone_number == null) {
                    return redirect()->back()->with('error_message', __('validation.custom.phone.incorrect'));
                }

                $donation = $this::$api_client_manager::call('POST', getApiURL() . '/donation', null, $inputs);

                if ($donation->success) {
                    return redirect()->route('transaction.waiting', [
                        'success_message' => $donation->data->result_response->order_number . '-' . (!empty($inputs['user_id']) ? $inputs['user_id'] : 'anonymous'),
                    ]);

                } else {
                    return redirect()->back()->with('error_message', $donation->message);
                }
            }

            if ($inputs['transaction_type_id'] == $bank_card_type->data->id) {
                $donation = $this::$api_client_manager::call('POST', getApiURL() . '/donation', null, $inputs);

                if ($donation->success) {
                    return redirect($donation->data->result_response->url)->with('order_number', $donation->data->result_response->order_number);

                } else {
                    return redirect()->back()->with('error_message', $donation->message);
                }
            }
        }
    }
}
