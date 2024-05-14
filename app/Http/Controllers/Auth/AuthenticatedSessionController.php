<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiClientManager;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class AuthenticatedSessionController extends Controller
{
    public static $api_client_manager;

    public function __construct()
    {
        $this::$api_client_manager = new ApiClientManager();
    }

    /**
     * Display the login view.
     */
    public function create()
    {
        Session::put('url.intended', URL::previous());

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        if (!empty($request->login_parental_code)) {
            // Login API
            $users = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_parental_code/' . $request->login_parental_code);

            if ($users->success) {
                return view('auth.login', 'children', $users->data);

            } else {
                $error_data = $users->message . ', ' . $users->message . ', ' . __('notifications.error_title');

                return redirect()->back()->with('error_message_login', $error_data . '~' . $request->login_parental_code);
            }

        } else {
            if ($request->child_id) {
                // Select a user API
                $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . $request->child_id);

                // Authentication datas (E-mail or Phone number or rather username)
                $auth_phone = Auth::attempt(['phone' => $user->data->user->phone, 'password' => $user->data->password_reset->former_password]);
                $auth_email = Auth::attempt(['email' => $user->data->user->email, 'password' => $user->data->password_reset->former_password]);
                $auth_username = Auth::attempt(['username' => $user->data->username, 'password' => $user->data->password_reset->former_password]);

                if ($auth_phone || $auth_email || $auth_username) {
                    $request->session()->regenerate();

                    if (Session::has('url.intended')) {
                        return redirect()->to(Session::get('url.intended'));

                    } else {
                        return redirect()->to('/');
                    }
                }

            } else {
                // Get inputs
                $inputs = [
                    'username' => $request->login_username,
                    'password' => $request->login_password
                ];
                // Login API
                $user = $this::$api_client_manager::call('POST', getApiURL() . '/user/login', null, $inputs);

                if ($user->success) {
                    // Authentication datas (E-mail or Phone number or rather username)
                    $auth_phone = Auth::attempt(['phone' => $user->data->phone, 'password' => $inputs['password']], $request->remember);
                    $auth_email = Auth::attempt(['email' => $user->data->email, 'password' => $inputs['password']], $request->remember);
                    $auth_username = Auth::attempt(['username' => $user->data->username, 'password' => $inputs['password']], $request->remember);

                    if ($auth_phone || $auth_email || $auth_username) {
                        $request->session()->regenerate();

                        if (Session::has('url.intended')) {
                            return redirect()->to(Session::get('url.intended'));

                        } else {
                            return redirect()->to('/');
                        }
                    }

                } else {
                    if (is_object($user->data)) {
                        if (is_numeric($inputs['username'])) {
                            $error_data = $user->message . ', ' . __('notifications.unverified_token_phone') . '.<br><strong><a href="' . route('password.request', ['check' => 'phone']) . '">' . __('miscellaneous.check_now') . '</a></strong>' . ', ' . __('notifications.error_title');
                            $inputs_data = $inputs['username'] . ', ' . $inputs['password'];

                            return redirect()->back()->with('error_message_login', $error_data . '~' . $inputs_data);

                        } else {
                            $error_data = $user->message . ', ' . __('notifications.unverified_token_email') . '.<br><strong><a href="' . route('password.request', ['check' => 'email']) . '">' . __('miscellaneous.check_now') . '</a></strong>' . ', ' . __('notifications.error_title');
                            $inputs_data = $inputs['username'] . ', ' . $inputs['password'];

                            return redirect()->back()->with('error_message_login', $error_data . '~' . $inputs_data);
                        }

                    } else {
                        $error_data = $user->message . ', ' . $user->message . ', ' . __('notifications.error_title');
                        $inputs_data = $inputs['username'] . ', ' . $inputs['password'];

                        return redirect()->back()->with('error_message_login', $error_data . '~' . $inputs_data);
                    }
                }
            }
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
