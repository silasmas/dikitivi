<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiClientManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        clearstatcache();
    }

    // ==================================== HTTP GET METHODS ====================================
    /**
     * GET: Account page
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
        // Select all unread notifications API
        $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . $user->data->user->id, $user->data->user->api_token);
        // Select all countries API
        $countries = $this::$api_client_manager::call('GET', getApiURL() . '/country');

        if (session()->has('for_youth')) {
            if (session()->get('for_youth') == 1) {
                if ($user->data->user->age < 18) {
                    // User age
                    $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                    return view('account', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user,
                        'unread_notifications' => $notifications->data,
                        'countries' => $countries->data,
                        'api_client_manager' => $this::$api_client_manager,
                    ]);

                } else {
                    // User age
                    $for_youth = 0;

                    return view('parental-code', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user,
                        'unread_notifications' => $notifications->data,
                        'api_client_manager' => $this::$api_client_manager,
                    ]);
                }

            } else {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select all unread notifications API
                $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . $user->data->user->id, $user->data->user->api_token);
                // Select all countries API
                $countries = $this::$api_client_manager::call('GET', getApiURL() . '/country');

                return view('account', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user,
                    'unread_notifications' => $notifications->data,
                    'countries' => $countries->data,
                    'api_client_manager' => $this::$api_client_manager,
                ]);
            }

        } else {
            // Select a user API
            $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, Auth::user()->api_token);
            // User age
            $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
            // Select all unread notifications API
            $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . $user->data->user->id, $user->data->user->api_token);
            // Select all countries API
            $countries = $this::$api_client_manager::call('GET', getApiURL() . '/country');

            return view('account', [
                'for_youth' => $for_youth,
                'current_user' => $user->data->user,
                'unread_notifications' => $notifications->data,
                'countries' => $countries->data,
                'api_client_manager' => $this::$api_client_manager,
            ]);
        }
    }

    /**
     * GET: Other account pages
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
        // Select all unread notifications API
        $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_status_user/' . $unread_status->data->id . '/' . $user->data->user->id, $user->data->user->api_token);

        if (session()->has('for_youth')) {
            if (session()->get('for_youth') == 1) {
                if ($user->data->user->age < 18) {
                    // User age
                    $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                    if ($entity == 'watchlist') {
                        // Select a type by name API
                        $watchlist_type_name = 'Watchlist';
                        $watchlist_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $watchlist_type_name);
                        // All user carts by type (Watchlist) API
                        $user_watchlist = $this::$api_client_manager::call('GET', getApiURL() . '/cart/find_by_type/' . $user->data->user->id . '/' . $watchlist_type->data->id, $user->data->user->api_token);
                        // Paginate result
                        $paginate_result = paginate($user_watchlist->data->orders, 7);

                        return view('account', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user,
                            'unread_notifications' => $notifications->data,
                            'watchlist_id' => $user_watchlist->data->id,
                            'watchlist' => $paginate_result,
                            'lastPage' => $paginate_result->lastPage(),
                            'api_client_manager' => $this::$api_client_manager,
                            'entity' => $entity,
                            'entity_title' => __('miscellaneous.account.watchlist'),
                        ]);
                    }

                    if ($entity == 'children') {
                        if (request()->has('id')) {
                            // Select a user API
                            $child = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . request()->get('id'), $user->data->user->api_token);
                            // Recently viewed medias API
                            $viewed_medias = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_viewed_medias/' . $child->data->user->id, $user->data->user->api_token);

                            return view('account', [
                                'for_youth' => $for_youth,
                                'current_user' => $user->data->user,
                                'unread_notifications' => $notifications->data,
                                'child' => $child->data->user,
                                'viewed_medias' => $viewed_medias->data,
                                'lastPage' => $viewed_medias->lastPage,
                                'api_client_manager' => $this::$api_client_manager,
                                'entity' => $entity,
                                'entity_title' => __('miscellaneous.account.child.title'),
                            ]);

                        } else {
                            if (!empty($user->data->user->parental_code)) {
                                // All user children API
                                $children = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_parental_code/' . $user->data->user->id . '/' . $user->data->user->parental_code, $user->data->user->api_token);

                                return view('account', [
                                    'for_youth' => $for_youth,
                                    'current_user' => $user->data->user,
                                    'unread_notifications' => $notifications->data,
                                    'api_client_manager' => $this::$api_client_manager,
                                    'children' => $children->data,
                                    'entity' => $entity,
                                    'entity_title' => __('miscellaneous.account.child.title'),
                                ]);

                            } else {
                                return view('account', [
                                    'for_youth' => $for_youth,
                                    'current_user' => $user->data->user,
                                    'unread_notifications' => $notifications->data,
                                    'api_client_manager' => $this::$api_client_manager,
                                    'children' => [],
                                    'entity' => $entity,
                                    'entity_title' => __('miscellaneous.account.child.title'),
                                ]);
                            }
                        }
                    }

                    if ($entity == 'videos') {
                        if (request()->has('act')) {
                            if (request()->get('act') == 'add') {
                                return view('account', [
                                    'for_youth' => $for_youth,
                                    'current_user' => $user->data->user,
                                    'unread_notifications' => $notifications->data,
                                    'api_client_manager' => $this::$api_client_manager,
                                    'entity' => $entity,
                                    'entity_title' => __('miscellaneous.account.my_videos'),
                                ]);
                            }

                            if (request()->get('act') == 'update') {
                                return view('account', [
                                    'for_youth' => $for_youth,
                                    'current_user' => $user->data->user,
                                    'unread_notifications' => $notifications->data,
                                    'api_client_manager' => $this::$api_client_manager,
                                    'entity' => $entity,
                                    'entity_title' => __('miscellaneous.account.my_videos'),
                                ]);
                            }

                        } else {
                            return view('account', [
                                'for_youth' => $for_youth,
                                'current_user' => $user->data->user,
                                'unread_notifications' => $notifications->data,
                                'api_client_manager' => $this::$api_client_manager,
                                'entity' => $entity,
                                'entity_title' => __('miscellaneous.account.my_videos'),
                            ]);
                        }
                    }

                } else {
                    // User age
                    $for_youth = 0;

                    return view('parental-code', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user,
                        'unread_notifications' => $notifications->data,
                        'api_client_manager' => $this::$api_client_manager,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.account.parental_control'),
                    ]);
                }

            } else {
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                if ($entity == 'watchlist') {
                    // Select a type by name API
                    $watchlist_type_name = 'Watchlist';
                    $watchlist_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $watchlist_type_name);
                    // All user carts by type (Watchlist) API
                    $user_watchlist = $this::$api_client_manager::call('GET', getApiURL() . '/cart/find_by_type/' . $user->data->user->id . '/' . $watchlist_type->data->id, $user->data->user->api_token);
                    // Paginate result
                    $paginate_result = paginate($user_watchlist->data->orders, 7);

                    return view('account', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user,
                        'unread_notifications' => $notifications->data,
                        'watchlist_id' => $user_watchlist->data->id,
                        'watchlist' => $paginate_result,
                        'lastPage' => $paginate_result->lastPage(),
                        'api_client_manager' => $this::$api_client_manager,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.account.watchlist'),
                    ]);
                }

                if ($entity == 'children') {
                    if (request()->has('id')) {
                        // Select a user API
                        $child = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . request()->get('id'), $user->data->user->api_token);
                        // Recently viewed medias API
                        $viewed_medias = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_viewed_medias/' . $child->data->user->id, $user->data->user->api_token);

                        return view('account', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user,
                            'unread_notifications' => $notifications->data,
                            'child' => $child->data->user,
                            'viewed_medias' => $viewed_medias->data,
                            'lastPage' => $viewed_medias->lastPage,
                            'api_client_manager' => $this::$api_client_manager,
                            'entity' => $entity,
                            'entity_title' => __('miscellaneous.account.child.title'),
                        ]);

                    } else {
                        if (!empty($user->data->user->parental_code)) {
                            // All user children API
                            $children = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_parental_code/' . $user->data->user->id . '/' . $user->data->user->parental_code, $user->data->user->api_token);

                            return view('account', [
                                'for_youth' => $for_youth,
                                'current_user' => $user->data->user,
                                'unread_notifications' => $notifications->data,
                                'api_client_manager' => $this::$api_client_manager,
                                'children' => $children->data,
                                'entity' => $entity,
                                'entity_title' => __('miscellaneous.account.child.title'),
                            ]);

                        } else {
                            return view('account', [
                                'for_youth' => $for_youth,
                                'current_user' => $user->data->user,
                                'unread_notifications' => $notifications->data,
                                'api_client_manager' => $this::$api_client_manager,
                                'children' => [],
                                'entity' => $entity,
                                'entity_title' => __('miscellaneous.account.child.title'),
                            ]);
                        }
                    }
                }

                if ($entity == 'videos') {
                    if (request()->has('act')) {
                        if (request()->get('act') == 'add') {
                            return view('account', [
                                'for_youth' => $for_youth,
                                'current_user' => $user->data->user,
                                'unread_notifications' => $notifications->data,
                                'api_client_manager' => $this::$api_client_manager,
                                'entity' => $entity,
                                'entity_title' => __('miscellaneous.account.my_videos'),
                            ]);
                        }

                        if (request()->get('act') == 'update') {
                            return view('account', [
                                'for_youth' => $for_youth,
                                'current_user' => $user->data->user,
                                'unread_notifications' => $notifications->data,
                                'api_client_manager' => $this::$api_client_manager,
                                'entity' => $entity,
                                'entity_title' => __('miscellaneous.account.my_videos'),
                            ]);
                        }

                    } else {
                        return view('account', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user,
                            'unread_notifications' => $notifications->data,
                            'api_client_manager' => $this::$api_client_manager,
                            'entity' => $entity,
                            'entity_title' => __('miscellaneous.account.my_videos'),
                        ]);
                    }
                }
            }

        } else {
            if ($entity == 'watchlist') {
                // User age
                $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                // Select a type by name API
                $watchlist_type_name = 'Watchlist';
                $watchlist_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/fr/' . $watchlist_type_name);
                // All user carts by type (Watchlist) API
                $user_watchlist = $this::$api_client_manager::call('GET', getApiURL() . '/cart/find_by_type/' . $user->data->user->id . '/' . $watchlist_type->data->id, $user->data->user->api_token);
                // Paginate result
                $paginate_result = paginate($user_watchlist->data->orders, 7);

                return view('account', [
                    'for_youth' => $for_youth,
                    'current_user' => $user->data->user,
                    'unread_notifications' => $notifications->data,
                    'watchlist_id' => $user_watchlist->data->id,
                    'watchlist' => $paginate_result,
                    'lastPage' => $paginate_result->lastPage(),
                    'api_client_manager' => $this::$api_client_manager,
                    'entity' => $entity,
                    'entity_title' => __('miscellaneous.account.watchlist'),
                ]);
            }

            if ($entity == 'children') {
                if (request()->has('id')) {
                    // User age
                    $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                    // Select a user API
                    $child = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . request()->get('id'), $user->data->user->api_token);
                    // Recently viewed medias API
                    $viewed_medias = $this::$api_client_manager::call('GET', getApiURL() . '/media/find_viewed_medias/' . $child->data->user->id, $user->data->user->api_token);

                    return view('account', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user,
                        'unread_notifications' => $notifications->data,
                        'child' => $child->data->user,
                        'viewed_medias' => $viewed_medias->data,
                        'lastPage' => $viewed_medias->lastPage,
                        'api_client_manager' => $this::$api_client_manager,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.account.child.title'),
                    ]);

                } else {
                    if (!empty($user->data->user->parental_code)) {
                        // User age
                        $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;
                        // All user children API
                        $children = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_parental_code/' . $user->data->user->id . '/' . $user->data->user->parental_code, $user->data->user->api_token);

                        return view('account', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user,
                            'unread_notifications' => $notifications->data,
                            'api_client_manager' => $this::$api_client_manager,
                            'children' => $children->data,
                            'entity' => $entity,
                            'entity_title' => __('miscellaneous.account.child.title'),
                        ]);

                    } else {
                        // User age
                        $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                        return view('account', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user,
                            'unread_notifications' => $notifications->data,
                            'api_client_manager' => $this::$api_client_manager,
                            'children' => [],
                            'entity' => $entity,
                            'entity_title' => __('miscellaneous.account.child.title'),
                        ]);
                    }
                }
            }

            if ($entity == 'videos') {
                if (request()->has('act')) {
                    if (request()->get('act') == 'add') {
                        // User age
                        $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                        return view('account', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user,
                            'unread_notifications' => $notifications->data,
                            'api_client_manager' => $this::$api_client_manager,
                            'entity' => $entity,
                            'entity_title' => __('miscellaneous.account.my_videos'),
                        ]);
                    }

                    if (request()->get('act') == 'update') {
                        // User age
                        $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                        return view('account', [
                            'for_youth' => $for_youth,
                            'current_user' => $user->data->user,
                            'unread_notifications' => $notifications->data,
                            'api_client_manager' => $this::$api_client_manager,
                            'entity' => $entity,
                            'entity_title' => __('miscellaneous.account.my_videos'),
                        ]);
                    }

                } else {
                    // User age
                    $for_youth = !empty($user->data->user->age) ? ($user->data->user->age < 18 ? 1 : 0) : 1;

                    return view('account', [
                        'for_youth' => $for_youth,
                        'current_user' => $user->data->user,
                        'unread_notifications' => $notifications->data,
                        'api_client_manager' => $this::$api_client_manager,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.account.my_videos'),
                    ]);
                }
            }
        }
    }

    /**
     * DELETE: Other account datas pages
     *
     * @param  $entity
     * @param  $id
     * @return \Illuminate\View\View
     */
    public function accountEntityDatas($entity, $id)
    {
        if ($entity == 'children') {
            // Delete a user API
            $user = $this::$api_client_manager::call('DELETE', getApiURL() . '/user/' . $id, Auth::user()->api_token);

            if ($user->success) {
                return redirect()->to('/account/children')->with('success_message', $user->message);

            } else {
                return redirect()->to('/account/children')->with('error_message', $user->message);
            }
        }
    }

    // ==================================== HTTP POST METHODS ====================================
    /**
     * POST: Update account
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function updateAccount(Request $request)
    {
        // Udpate avatar if it is set
        if (isset($request->data_recto) OR !empty($request->data_recto)) {
            // Update user identity API
            $user = $this::$api_client_manager::call('PUT', getApiURL() . '/user/add_image/' . $request->user_id, $request->api_token, [
                'user_id' => $request->user_id,
                'image_name' => $request->register_image_name,
                'image_64_recto' => $request->data_recto,
                'image_64_verso' => $request->data_verso
            ]);

            if ($user->success) {
                return redirect()->back()->with('success_message', $user->message);

            } else {
                return redirect()->back()->with('error_message', $user->message);
            }

        } else {
            // user inputs
            $inputs = [
                'id' => $request->user_id,
                'firstname' => $request->register_firstname,
                'lastname' => $request->register_lastname,
                'surname' => $request->register_surname,
                'gender' => $request->register_gender,
                'birth_date' => !empty($request->register_birthdate) ? (str_starts_with(app()->getLocale(), 'fr') || str_starts_with(app()->getLocale(), 'ln') ? explode('/', $request->register_birthdate)[2] . '-' . explode('/', $request->register_birthdate)[1] . '-' . explode('/', $request->register_birthdate)[0] : explode('/', $request->register_birthdate)[2] . '-' . explode('/', $request->register_birthdate)[0] . '-' . explode('/', $request->register_birthdate)[1]) : null,
                'city' => $request->register_city,
                'address_1' => $request->register_address_1,
                'address_2' => $request->register_address_2,
                'p_o_box' => $request->register_p_o_box,
                'email' => $request->register_email,
                'phone' => $request->register_phone,
                'username' => $request->register_username,
                'country_id' => $request->country_id
            ];

            // Update user API
            $user = $this::$api_client_manager::call('PUT', getApiURL() . '/user/' . $request->user_id, $request->api_token, $inputs);

            if ($user->success) {
                return redirect()->back()->with('success_message', $user->message);

            } else {
                return redirect()->back()->with('error_message', $user->message);
            }
        }
    }

    /**
     * POST: Update other account data
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $entity
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function updateAccountEntity(Request $request, $entity)
    {
        if ($entity == 'update_password') {
            // user inputs
            $inputs = [
                'former_password' => $request->register_former_password,
                'new_password' => $request->register_new_password,
                'confirm_new_password' => $request->register_confirm_new_password
            ];

            // Update user API
            $user = $this::$api_client_manager::call('PUT', getApiURL() . '/user/update_password/' . $request->user_id, $request->api_token, $inputs);

            if ($user->success) {
                return redirect()->back()->with('success_message', $user->message);

            } else {
                return redirect()->back()->with('error_message', $user->message);
            }
        }

        if ($entity == 'add_child') {
            // user inputs
            $inputs = [
                'firstname' => $request->register_firstname,
                'lastname' => $request->register_lastname,
                'surname' => $request->register_surname,
                'gender' => $request->register_gender,
                'belongs_to' => $request->belongs_to,
                'birth_date' => !empty($request->register_birthdate) ? (str_starts_with(app()->getLocale(), 'fr') || str_starts_with(app()->getLocale(), 'ln') ? explode('/', $request->register_birthdate)[2] . '-' . explode('/', $request->register_birthdate)[1] . '-' . explode('/', $request->register_birthdate)[0] : explode('/', $request->register_birthdate)[2] . '-' . explode('/', $request->register_birthdate)[0] . '-' . explode('/', $request->register_birthdate)[1]) : null,
                'username' => friendlyUsername($request->register_firstname . ' ' . $request->register_lastname)
            ];

            // Add a user API
            $user = $this::$api_client_manager::call('POST', getApiURL() . '/user', $request->api_token, $inputs);

            if ($user->success) {
                // Udpate avatar if it is set
                if ($request->data_profile != null) {
                    $this::$api_client_manager::call('PUT', getApiURL() . '/user/update_avatar_picture/' . $user->data->user->id, $request->api_token, [
                        'user_id' => $user->data->user->id,
                        'image_64' => $request->data_profile
                    ]);
                }

                return redirect()->back()->with('success_message', $user->message);

            } else {
                return redirect()->back()->with('error_message', $user->message);
            }
        }

        if ($entity == 'update_child') {
            // user inputs
            $inputs = [
                'id' => $request->user_id,
                'firstname' => $request->register_firstname,
                'lastname' => $request->register_lastname,
                'surname' => $request->register_surname,
                'username' => $request->register_username,
                'gender' => $request->register_gender,
                'birth_date' => !empty($request->register_birthdate) ? (str_starts_with(app()->getLocale(), 'fr') || str_starts_with(app()->getLocale(), 'ln') ? explode('/', $request->register_birthdate)[2] . '-' . explode('/', $request->register_birthdate)[1] . '-' . explode('/', $request->register_birthdate)[0] : explode('/', $request->register_birthdate)[2] . '-' . explode('/', $request->register_birthdate)[0] . '-' . explode('/', $request->register_birthdate)[1]) : null,
                'username' => $request->register_username
            ];

            // Update user API
            $user = $this::$api_client_manager::call('PUT', getApiURL() . '/user/' . $request->user_id, $request->api_token, $inputs);

            if ($user->success) {
                // Udpate avatar if it is changed
                if ($request->data_profile != null) {
                    $this::$api_client_manager::call('PUT', getApiURL() . '/user/update_avatar_picture/' . $user->data->id, $request->api_token, [
                        'user_id' => $user->data->id,
                        'image_64' => $request->data_profile
                    ]);
                }

                return redirect()->back()->with('success_message', $user->message);

            } else {
                return redirect()->back()->with('error_message', $user->message);
            }
        }
    }
}
