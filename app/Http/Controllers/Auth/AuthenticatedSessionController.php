<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiClientManager;

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
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
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

                return redirect()->route('home');
            }

        } else {
			if (is_object($user->message)) {
				if (is_numeric($inputs['username'])) {
                    $error_data = $user->data . ', ' . __('notifications.unverified_token_phone') . '.<br><strong><a href="' . route('password.request', ['check' => 'phone']) . '">' . __('miscellaneous.check_now') . '</a></strong>' . ', ' . __('notifications.error_title');
                    $inputs_data = $inputs['username'] . ', ' . $inputs['password'];

                    return redirect('/login')->with('error_message_login', $error_data . '~' . $inputs_data);

				} else {
                    $error_data = $user->data . ', ' . __('notifications.unverified_token_email') . '.<br><strong><a href="' . route('password.request', ['check' => 'email']) . '">' . __('miscellaneous.check_now') . '</a></strong>' . ', ' . __('notifications.error_title');
                    $inputs_data = $inputs['username'] . ', ' . $inputs['password'];

                    return redirect('/login')->with('error_message_login', $error_data . '~' . $inputs_data);
				}

			} else {
                $error_data = $user->message . ', ' . $user->data . ', ' . __('notifications.error_title');
                $inputs_data = $inputs['username'] . ', ' . $inputs['password'];

                return redirect('/login')->with('error_message_login', $error_data . '~' . $inputs_data);
			}
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
