<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiClientManager;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class RegisteredUserController extends Controller
{
    public static $api_client_manager;

    public function __construct()
    {
        $this::$api_client_manager = new ApiClientManager();
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        // Find users having the role "Membre" to verify if the register page can be displayed or not
        $role_data = 'Membre';
        $member_role = $this::$api_client_manager::call('GET', getApiURL() . '/role/search/' . $role_data);
        $countries = $this::$api_client_manager::call('GET', getApiURL() . '/country');

        return view('auth.register', [
            'role_id' => $member_role->data->id,
            'countries' => $countries->data,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public function store(Request $request): RedirectResponse|View
    {
        if (!empty($request->token)) {
            $given_token = $request->check_digit_1 . $request->check_digit_2 . $request->check_digit_3 . $request->check_digit_4 . $request->check_digit_5 . $request->check_digit_6 . $request->check_digit_7;

            $pr = $this::$api_client_manager::call('POST', getApiURL() . '/password_reset/check_token', null, [
                'email' => $request->email,
                'phone' => $request->phone,
                'token' => $given_token,
            ]);

            if ($pr->success) {
                $countries = $this::$api_client_manager::call('GET', getApiURL() . '/country');

                if (!empty($request->redirect) && $request->redirect == 'reset_password') {
                    return view('auth.reset-password', [
                        'temporary_user' => $pr->data->user,
                        'former_password' => $pr->data->password_reset->former_password,
                    ]);

                } else {
                    return view('auth.register', [
                        'temporary_user' => $pr->data->user,
                        'countries' => $countries->data
                    ]);
                }

            } else {
                if (!empty($request->redirect) && $request->redirect == 'reset_password') {
                    return view('auth.register', [
						'email' => $request->email,
						'phone' => $request->phone,
                        'token_sent' => $request->token,
                        'redirect' => $request->redirect,
						'error_title' => __('notifications.error_title'),
                        'error_message' => !empty($pr->data) ? $pr->data : $pr->message
                    ]);

                } else {
                    return view('auth.register', [
						'email' => $request->email,
						'phone' => $request->phone,
                        'token_sent' => $request->token,
						'error_title' => __('notifications.error_title'),
                        'error_message' => !empty($pr->data) ? $pr->data : $pr->message
                    ]);
                }
            }

        } else {
            // User inputs
            $user_inputs = [
                'id' => !empty($temporary_user) && !empty($temporary_user->data->id) ? $temporary_user->data->id : null,
                'firstname' => !empty($temporary_user) && !empty($temporary_user->data->firstname) ? $temporary_user->data->firstname : $request->register_firstname,
                'lastname' => !empty($temporary_user) && !empty($temporary_user->data->lastname) ? $temporary_user->data->lastname : $request->register_lastname,
                'surname' => $request->register_surname,
                'gender' => $request->register_gender,
                'birth_date' => !empty($request->register_birthdate) ? (str_starts_with(app()->getLocale(), 'fr') || str_starts_with(app()->getLocale(), 'ln') ? explode('/', $request->register_birthdate)[2] . '-' . explode('/', $request->register_birthdate)[1] . '-' . explode('/', $request->register_birthdate)[0] : explode('/', $request->register_birthdate)[2] . '-' . explode('/', $request->register_birthdate)[0] . '-' . explode('/', $request->register_birthdate)[1]) : null,
                'city' => $request->register_city,
                'address_1' => $request->register_address_1,
                'address_2' => $request->register_address_2,
                'p_o_box' => $request->register_p_o_box,
                'email' => !empty($temporary_user) && !empty($temporary_user->data->email) ? $temporary_user->data->email : $request->register_email,
                'phone' => !empty($temporary_user) && !empty($temporary_user->data->phone) ? $temporary_user->data->phone : $request->phone_code . $request->phone_number,
                'username' => $request->register_username,
                'password' => $request->register_password,
                'confirm_password' => $request->confirm_password,
                'country_id' => !empty($temporary_user) && !empty($temporary_user->data->country_id) ? $temporary_user->data->country_id : $request->country_id,
                'role_id' => !empty($temporary_user) && !empty($temporary_user->data->role_id) ? $temporary_user->data->role_id : $request->role_id
            ];

            if (!empty($request->temporary_user_id)) {
                // Update user API
                $user = $this::$api_client_manager::call('PUT', getApiURL() . '/user/' . $request->temporary_user_id, $request->api_token, $user_inputs);

                // dd($user_inputs['birth_date']);
                if ($user->success) {
                    return redirect('/login')->with('success_message', __('notifications.create_account_success'));

                } else {
                    $input_birthday_exists = !empty($user_inputs['birth_date']);
                    $lang_check = str_starts_with(app()->getLocale(), 'fr') || str_starts_with(app()->getLocale(), 'ln');
                    $cond1 = explode('-', $user_inputs['birth_date'])[2] . '/' . explode('-', $user_inputs['birth_date'])[1] . '/' . explode('-', $user_inputs['birth_date'])[0];
                    $cond2 = explode('-', $user_inputs['birth_date'])[1] . '/' . explode('-', $user_inputs['birth_date'])[2] . '/' . explode('-', $user_inputs['birth_date'])[0];

                    $error_data = $user->message . '-' . (!empty($user->data) ? $user->data : $user->message) . '-' . __('notifications.error_title');
                    $inputs_data = $user_inputs['firstname']                                                // array[0]
                                    . '-' . $user_inputs['lastname']                                        // array[1]
                                    . '-' . $user_inputs['surname']                                         // array[2]
                                    . '-' . $user_inputs['gender']                                          // array[3]
                                    . '-' . $input_birthday_exists ? ($lang_check ? $cond1 : $cond2) : null // array[4]
                                    . '-' . $user_inputs['city']                                            // array[5]
                                    . '-' . $user_inputs['address_1']                                       // array[6]
                                    . '-' . $user_inputs['address_2']                                       // array[7]
                                    . '-' . $user_inputs['p_o_box']                                         // array[8]
                                    . '-' . $user_inputs['email']                                           // array[9]
                                    . '-' . $user_inputs['username']                                        // array[10]
                                    . '-' . $request->temporary_user_id                                     // array[11]
                                    . '-' . $request->api_token;                                            // array[12]

                    return redirect()->back()->with('error_message', $error_data . '~' . $inputs_data);
                }

            } else {
                if (!empty($request->redirect)) {
                    // Find password reset by email or phone API
                    $password_reset = $this::$api_client_manager::call('GET', getApiURL() . '/password_reset/search_by_email_or_phone/' . (!empty($user_inputs['email']) ? $user_inputs['email'] : $user_inputs['phone']) , null, $user_inputs);

                    if ($password_reset->success) {
                        return view('auth.register', [
                            'redirect' => $request->redirect,
                            'token_sent' => __('miscellaneous.yes'),
                            'email' => $user_inputs['email'],
                            'phone' => $user_inputs['phone']
                        ]);

                    } else {
                        $error_data = $password_reset->message . '-' . (!empty($password_reset->data) ? $password_reset->data : $password_reset->message) . '-' . __('notifications.error_title');
                        $inputs_data = $user_inputs['email']		// array[0]
                                        . '-' . $request->redirect;	// array[1]

                        return redirect()->back()->with('error_message', $error_data . '~' . $inputs_data);
                    }

                } else {
                    // Register user API
                    $user = $this::$api_client_manager::call('POST', getApiURL() . '/user', null, $user_inputs);

                    if ($user->success) {
                        return view('auth.register', [
                            'token_sent' => __('miscellaneous.yes'),
                            'email' => $user_inputs['email'],
                            'phone' => $user_inputs['phone']
                        ]);

                    } else {
                        $error_data = $user->message . '-' . (!empty($user->data) ? $user->data : $user->message) . '-' . __('notifications.error_title');
                        $inputs_data = $user_inputs['firstname']        // array[0]
                                        . '-' . $user_inputs['lastname']// array[1]
                                        . '-' . $user_inputs['email'];  // array[2]

                        return redirect()->back()->with('error_message', $error_data . '~' . $inputs_data);
                    }
                }
            }
        }
    }
}
