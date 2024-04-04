<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiClientManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

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

        $this->middleware('auth')->except(['changeLanguage', 'index', 'about', 'aboutEntity']);
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
        if (session()->has('for_youth') OR Auth::check()) {
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

            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->age) ? ($user->data->age < 18 ? 1 : 0) : 1;
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

                return view('home', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data,
                    'unread_notifications' => $notifications->data,
                    'trends' => $medias_trends->data,
                    'lives' => $medias_lives->data,
                    'films' => $medias_films->data,
                    'series' => $medias_series->data,
                    'programs' => $medias_programs->data,
                    'songs' => $medias_songs->data,
                    'albums' => $medias_albums->data,
                ]);

            } else {
                // User age
                $for_youth = session()->get('for_youth');
                // Select media trends API
                $medias_trends = $this::$api_client_manager::call('GET', getApiURL() . '/media/trends/' . date('Y') . '/' . $for_youth);
                // Select media lives API
                $medias_lives = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_live/' . $for_youth, null, null, $request->ip());
                // Select medias by type API
                // -- FILMS
                $medias_films = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $film_type->data->id, null, null, $request->ip());
                // -- SERIES
                $medias_series = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $series_type->data->id, null, null, $request->ip());
                // -- PROGRAMS
                $medias_programs = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $program_type->data->id, null, null, $request->ip());
                // -- SONGS
                $medias_songs = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $song_type->data->id, null, null, $request->ip());
                // -- ALBUMS
                $medias_albums = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $album_type->data->id, null, null, $request->ip());

                return view('home', [
                    'for_youth' => $for_youth,
                    'trends' => $medias_trends->data,
                    'lives' => $medias_lives->data,
                    'films' => $medias_films->data,
                    'series' => $medias_series->data,
                    'programs' => $medias_programs->data,
                    'songs' => $medias_songs->data,
                    'albums' => $medias_albums->data,
                ]);
            }

        } else {
            return view('welcome');
        }
    }

    /**
     * GET: Home page
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        $titles = Lang::get('miscellaneous.public.about.content.titles');

        return view('about', ['titles' => $titles]);
    }

    /**
     * GET: Home page
     *
     * @return \Illuminate\View\View
     */
    public function aboutEntity($entity)
    {
        $titles = Lang::get('miscellaneous.public.about.' . $entity . '.titles');

        return view('about', [
            'titles' => $titles,
            'entity' => $entity,
            'entity_title' => __('miscellaneous.public.about.' . $entity . '.title'),
            'entity_menu' => __('miscellaneous.menu.' . $entity),
        ]);
    }

    // ==================================== HTTP POST METHODS ====================================
}
