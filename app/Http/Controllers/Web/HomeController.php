<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiClientManager;

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
     * GET: Home page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pricings = $this::$api_client_manager::call('GET', getApiURL() . '/pricing');

        if (session()->has('age')) {

        } else {
        }
        
        return view('welcome', ['pricings' => $pricings]);
    }

    /**
     * GET: Home page
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('about');
    }

    /**
     * GET: Home page
     *
     * @return \Illuminate\View\View
     */
    public function aboutEntity($entity)
    {
        return view('about', [
            'entity' => $entity,
            'entity_title' => __('miscellaneous.public.about.' . $entity . '.title'),
            'entity_menu' => __('miscellaneous.menu.' . $entity),
        ]);
    }

    // ==================================== HTTP POST METHODS ====================================
}
