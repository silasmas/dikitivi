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
class AccountController extends Controller
{
    public static $api_client_manager;

    public function __construct()
    {
        $this::$api_client_manager = new ApiClientManager();

        $this->middleware('auth');
    }

    // ==================================== HTTP GET METHODS ====================================
    /**
     * GET: Welcome/Home page
     *
     * @return \Illuminate\View\View
     */
    public function account()
    {
        // Select a status by name API
        $unread_status_name = 'Non lue';
        $unread_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/fr/' . $unread_status_name);

        // Select a user API
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
        // User age
        $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
        // Select all unread notifications API
        $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);

        return view('account', [
            'for_youth' => $for_youth,
            'current_user' => $user->data->user,
            'unread_notifications' => $notifications->data,
            'api_client_manager' => $this::$api_client_manager,
        ]);
    }

    /**
     * GET: Welcome/Home page
     *
     * @param  $entity
     * @return \Illuminate\View\View
     */
    public function accountEntity($entity)
    {
        // Select a status by name API
        $unread_status_name = 'Non lue';
        $unread_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/fr/' . $unread_status_name);

        // Select a user API
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
        // User age
        $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
        // Select all unread notifications API
        $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . Auth::user()->id, Auth::user()->api_token);

        if ($entity == 'watchlist') {
            return view('account', [
                'for_youth' => $for_youth,
                'current_user' => $user->data->user,
                'unread_notifications' => $notifications->data,
                'api_client_manager' => $this::$api_client_manager,
                'entity' => $entity,
                'entity_title' => __('miscellaneous.account.watchlist'),
            ]);
        }

        if ($entity == 'children') {
            return view('account', [
                'for_youth' => $for_youth,
                'current_user' => $user->data->user,
                'unread_notifications' => $notifications->data,
                'api_client_manager' => $this::$api_client_manager,
                'entity' => $entity,
                'entity_title' => __('miscellaneous.account.child.title'),
            ]);
        }
    }

    // ==================================== HTTP POST METHODS ====================================
}
