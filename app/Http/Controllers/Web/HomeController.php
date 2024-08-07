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

        clearstatcache();
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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (session()->has('for_youth')) {
            if (session()->get('for_youth') == 1) {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);

                    if ($user->data->user->age < 18) {
                        $for_youth = session()->get('for_youth');

                        return view('home', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user
                        ]);

                    } else {
                        // User age
                        $for_youth = 0;

                        return view('parental-code', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user
                        ]);
                    }

                } else {
                    return view('home', [
                        'for_youth' => session()->get('for_youth')
                    ]);
                }

            } else {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                    // User age
                    $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                    return view('home', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user
                    ]);

                } else {
                    return redirect()->route('login');
                }
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                return view('home', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user
                ]);

            } else {
                return view('welcome');
            }
        }
    }

    /**
     * GET: Count Like/Watchlist actions
     *
     * @return \Illuminate\View\View
     */
    public function countActions()
    {
        // All media views API
        $views = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_views/' . request()->get('media_id'));
        // All media likes API
        $likes = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_likes/' . request()->get('media_id'));

        return view('partials.count', [
            'views' => $views->data,
            'likes' => $likes->data
        ]);
    }

    /**
     * GET: Media details page
     *
     * @return \Illuminate\View\View
     */
    public function mediaDatas(Request $request, $id)
    {
        // All media views API
        $views = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_views/' . $id);
        // All media likes API
        $likes = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_likes/' . $id);

        if (session()->has('for_youth')) {
            if (session()->get('for_youth') == 1) {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);

                    if ($user->data->user->age < 18) {
                        $for_youth = session()->get('for_youth');
                        // Select the current media API
                        $current_media = $this::$api_client_manager::call('GET', getApiURL() . '/media/' . $id, $user->data->user->api_token, null, $request->ip(), $user->data->user->id);
                        // Select other medias by current media type ID
                        $other_medias = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $current_media->data->type->id, $user->data->user->api_token, null, $request->ip(), $user->data->user->id);

                        return view('partials.media.datas', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user,
                            'current_media' => $current_media->data,
                            'other_medias' => $other_medias->data,
                            'views' => $views->data,
                            'likes' => $likes->data
                        ]);

                    } else {
                        // User age
                        $for_youth = 0;

                        return view('parental-code', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user,
                            'views' => $views->data,
                            'likes' => $likes->data
                        ]);
                    }

                } else {
                    // Select the current media API
                    $current_media = $this::$api_client_manager::call('GET', getApiURL() . '/media/' . $id, null, null, $request->ip());
                    // Select other medias by current media type ID
                    $other_medias = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . session()->get('for_youth') . '/' . $current_media->data->type->id, null, null, $request->ip());

                    if ($current_media->data->for_youth != session()->get('for_youth')) {
                        return redirect('/')->with('error_message', __('miscellaneous.adult_content'));

                    } else {
                        return view('partials.media.datas', [
                            'for_youth' => session()->get('for_youth'),
                            'current_media' => $current_media->data,
                            'other_medias' => $other_medias->data,
                            'views' => $views->data,
                            'likes' => $likes->data
                        ]);
                    }
                }

            } else {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                    // User age
                    $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                    // Select the current media API
                    $current_media = $this::$api_client_manager::call('GET', getApiURL() . '/media/' . $id, $user->data->user->api_token, null, $request->ip(), $user->data->user->id);
                    // Select other medias by current media type ID
                    $other_medias = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $current_media->data->type->id, $user->data->user->api_token, null, $request->ip(), $user->data->user->id);

                    return view('partials.media.datas', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user,
                        'current_media' => $current_media->data,
                        'other_medias' => $other_medias->data,
                        'views' => $views->data,
                        'likes' => $likes->data
                    ]);

                } else {
                    return redirect()->route('login');
                }
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select the current media API
                $current_media = $this::$api_client_manager::call('GET', getApiURL() . '/media/' . $id, $user->data->user->api_token, null, $request->ip(), $user->data->user->id);
                // Select other medias by current media type ID
                $other_medias = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $current_media->data->type->id, $user->data->user->api_token, null, $request->ip(), $user->data->user->id);

                if ($for_youth == 1 AND $for_youth != $current_media->data->for_youth) {
                    return redirect('/')->with('error_message', __('miscellaneous.adult_content'));

                } else {
                    return view('partials.media.datas', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user,
                        'current_media' => $current_media->data,
                        'other_medias' => $other_medias->mediaDatas,
                        'views' => $views->data,
                        'likes' => $likes->data
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
     * @return \Illuminate\View\View
     */
    public function live()
    {
        if (session()->has('for_youth')) {
            if (session()->get('for_youth') == 1) {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);

                    if ($user->data->user->age < 18) {
                        $for_youth = session()->get('for_youth');

                        return view('partials.media.live', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user
                        ]);

                    } else {
                        // User age
                        $for_youth = 0;

                        return view('parental-code', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user
                        ]);
                    }

                } else {
                    return view('partials.media.live', [
                        'for_youth' => session()->get('for_youth')
                    ]);
                }

            } else {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                    // User age
                    $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                    return view('partials.media.live', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user
                    ]);

                } else {
                    return redirect()->route('login');
                }
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                return view('partials.media.live', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user
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
     * @return \Illuminate\View\View
     */
    public function films()
    {
        if (session()->has('for_youth')) {
            if (session()->get('for_youth') == 1) {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);

                    if ($user->data->user->age < 18) {
                        $for_youth = session()->get('for_youth');

                        return view('partials.media.films', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user
                        ]);

                    } else {
                        // User age
                        $for_youth = 0;

                        return view('parental-code', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user
                        ]);
                    }

                } else {
                    return view('partials.media.films', [
                        'for_youth' => session()->get('for_youth')
                    ]);
                }

            } else {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                    // User age
                    $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                    return view('partials.media.films', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user
                    ]);

                } else {
                    return redirect()->route('login');
                }
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                return view('partials.media.films', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user
                ]);

            } else {
                Session::put('url.intended', URL::previous());

                return view('welcome');
            }
        }
    }

    /**
     * GET: Media cartoons
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function cartoons(Request $request)
    {
        // Select a media by type API
        $cartoon_type_name = 'Dessins animés';
        $cartoon_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $cartoon_type_name);

        if (session()->has('for_youth')) {
            if (session()->get('for_youth') == 1) {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);

                    if ($user->data->user->age < 18) {
                        $for_youth = session()->get('for_youth');
                        // Select medias by type API
                        $medias_cartoons = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $cartoon_type->data->id . '?page=' . $request->get('page'), null, null, $request->ip(), $user->data->user->id);

                        return view('partials.media.cartoons', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user,
                            'cartoons' => $medias_cartoons->data,
                            'lastPage' => $medias_cartoons->lastPage
                        ]);

                    } else {
                        // User age
                        $for_youth = 0;

                        return view('parental-code', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user
                        ]);
                    }

                } else {
                    // Select medias by type API
                    $medias_cartoons = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . session()->get('for_youth') . '/' . $cartoon_type->data->id . '?page=' . $request->get('page'), null, null, $request->ip());

                    return view('partials.media.cartoons', [
                        'for_youth' => session()->get('for_youth'),
                        'cartoons' => $medias_cartoons->data,
                        'lastPage' => $medias_cartoons->lastPage
                    ]);
                }

            } else {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                    // User age
                    $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                    // Select medias by type API
                    $medias_cartoons = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $cartoon_type->data->id . '?page=' . $request->get('page'), null, null, $request->ip(), $user->data->user->id);

                    return view('partials.media.cartoons', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user,
                        'cartoons' => $medias_cartoons->data,
                        'lastPage' => $medias_cartoons->lastPage
                    ]);

                } else {
                    return redirect()->route('login');
                }
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select medias by type API
                $medias_cartoons = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_all_by_age_type/' . $for_youth . '/' . $cartoon_type->data->id . '?page=' . $request->get('page'), null, null, $request->ip(), $user->data->user->id);

                return view('partials.media.cartoons', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user,
                    'cartoons' => $medias_cartoons->data,
                    'lastPage' => $medias_cartoons->lastPage
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
     * @return \Illuminate\View\View
     */
    public function series()
    {
        if (session()->has('for_youth')) {
            if (session()->get('for_youth') == 1) {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);

                    if ($user->data->user->age < 18) {
                        $for_youth = session()->get('for_youth');

                        return view('partials.media.series', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user
                        ]);

                    } else {
                        // User age
                        $for_youth = 0;

                        return view('parental-code', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user
                        ]);
                    }

                } else {
                    return view('partials.media.series', [
                        'for_youth' => session()->get('for_youth')
                    ]);
                }

            } else {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                    // User age
                    $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                    return view('partials.media.series', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user
                    ]);

                } else {
                    return redirect()->route('login');
                }
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                return view('partials.media.series', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user
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
     * @return \Illuminate\View\View
     */
    public function programs()
    {
        if (session()->has('for_youth')) {
            if (session()->get('for_youth') == 1) {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);

                    if ($user->data->user->age < 18) {
                        $for_youth = session()->get('for_youth');

                        return view('partials.media.programs', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user
                        ]);

                    } else {
                        // User age
                        $for_youth = 0;

                        return view('parental-code', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user
                        ]);
                    }

                } else {
                    return view('partials.media.programs', [
                        'for_youth' => session()->get('for_youth')
                    ]);
                }

            } else {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                    // User age
                    $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                    return view('partials.media.programs', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user
                    ]);

                } else {
                    return redirect()->route('login');
                }
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                return view('partials.media.programs', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user
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
        // Select a category by name API
        $preach_category_name = 'Prédications';
        $preach_category = $this::$api_client_manager::call('GET', getApiURL() . '/category/search/fr/' . $preach_category_name);

        if (session()->has('for_youth')) {
            if (session()->get('for_youth') == 1) {
                if ($entity == 'preach') {
                    if (Auth::check()) {
                        // Select a user API
                        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);

                        if ($user->data->user->age < 18) {
                            $for_youth = session()->get('for_youth');

                            if ($entity == 'preach') {
                                // Select medias by categories API
                                $medias_preachs = $this::$api_client_manager::call('POST', getApiURL() . '/media/filter_by_categories/' . $for_youth . '?page=' . $request->get('page'), null, ['categories_ids' => [$preach_category->data->id]], $request->ip(), $user->data->user->id);

                                return view('partials.media.programs', [
                                    'for_youth' => $for_youth,
                                    'current_user' => $user->data->user,
                                    'preachs' => $medias_preachs->data,
                                    'lastPage' => $medias_preachs->lastPage,
                                    'entity' => $entity,
                                    'entity_title' => __('miscellaneous.menu.preach')
                                ]);
                            }

                        } else {
                            // User age
                            $for_youth = 0;

                            return view('parental-code', [
                                'for_youth' => $for_youth,
                                'current_user' => $user->data->user
                            ]);
                        }

                    } else {
                        // Select medias by categories API
                        $medias_preachs = $this::$api_client_manager::call('POST', getApiURL() . '/media/filter_by_categories/' . session()->get('for_youth') . '?page=' . $request->get('page'), null, ['categories_ids' => [$preach_category->data->id]], $request->ip());

                        return view('partials.media.programs', [
                            'for_youth' => session()->get('for_youth'),
                            'preachs' => $medias_preachs->data,
                            'lastPage' => $medias_preachs->lastPage,
                            'entity' => $entity,
                            'entity_title' => __('miscellaneous.menu.preach')
                        ]);
                    }
                }

            } else {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                    // User age
                    $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                    if ($entity == 'preach') {
                        // Select medias by categories API
                        $medias_preachs = $this::$api_client_manager::call('POST', getApiURL() . '/media/filter_by_categories/' . $for_youth . '?page=' . $request->get('page'), null, ['categories_ids' => [$preach_category->data->id]], $request->ip(), $user->data->user->id);

                        return view('partials.media.programs', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user,
                            'preachs' => $medias_preachs->data,
                            'lastPage' => $medias_preachs->lastPage,
                            'entity' => $entity,
                            'entity_title' => __('miscellaneous.menu.preach')
                        ]);
                    }

                } else {
                    return redirect()->route('login');
                }
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                if ($entity == 'preach') {
                    // Select medias by categories API
                    $medias_preachs = $this::$api_client_manager::call('POST', getApiURL() . '/media/filter_by_categories/' . $for_youth . '?page=' . $request->get('page'), null, ['categories_ids' => [$preach_category->data->id]], $request->ip(), $user->data->user->id);

                    return view('partials.media.programs', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user,
                        'preachs' => $medias_preachs->data,
                        'lastPage' => $medias_preachs->lastPage,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.menu.preach')
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
     * @return \Illuminate\View\View
     */
    public function songs()
    {
        if (session()->has('for_youth')) {
            if (session()->get('for_youth') == 1) {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);

                    if ($user->data->user->age < 18) {
                        $for_youth = session()->get('for_youth');
                        return view('partials.media.songs', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user
                        ]);

                    } else {
                        // User age
                        $for_youth = 0;

                        return view('parental-code', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user
                        ]);
                    }

                } else {
                    return view('partials.media.songs', [
                        'for_youth' => session()->get('for_youth')
                    ]);
                }

            } else {
                if (Auth::check()) {
                    // Select a user API
                    $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                    // User age
                    $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                    return view('partials.media.songs', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user
                    ]);

                } else {
                    return redirect()->route('login');
                }
            }

        } else {
            if (Auth::check()) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                return view('partials.media.songs', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user
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
                'message_content' => __('notifications.processing_succeed')
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
                'message_content' => __('notifications.process_canceled')
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
                'message_content' => __('notifications.process_failed')
            ]);
        }
    }

    // ==================================== HTTP POST METHODS ====================================
    /**
     * POST: Check parental code
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function parentalCode(Request $request)
    {
        if (!empty($request->login_parental_code)) {
            // Select a user API
            $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
            // Select all countries API
            $countries = $this::$api_client_manager::call('GET', getApiURL() . '/country');
            // Login API
            $users = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_parental_code/' . $request->parent_id . '/' . $request->login_parental_code);

            if ($users->success) {
                return view('parental-code', [
                    'children' => $users->data,
                    'for_youth' => 0,
                    'current_user' => $user->data->user,
                    'countries' => $countries->data,
                    'api_client_manager' => $this::$api_client_manager
                ]);

            } else {
                return redirect()->back()->with('error_message', $users->message);
            }

        } else {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            // Select a user API
            $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . $request->child_id);
            // Authentication datas (E-mail or Phone number or rather username)
            $auth_phone = Auth::attempt(['phone' => $user->data->user->phone, 'password' => $user->data->password_reset->former_password]);
            $auth_email = Auth::attempt(['email' => $user->data->user->email, 'password' => $user->data->password_reset->former_password]);
            $auth_username = Auth::attempt(['username' => $user->data->user->username, 'password' => $user->data->password_reset->former_password]);

            if ($auth_phone || $auth_email || $auth_username) {
                $request->session()->regenerate();

                if (Session::has('url.intended')) {
                    return redirect()->to(Session::get('url.intended'));

                } else {
                    return redirect()->to('/');
                }
            }
        }
    }

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
