<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiClientManager;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class PasswordResetLinkController extends Controller
{
    public static $api_client_manager;

    public function __construct()
    {
        $this::$api_client_manager = new ApiClientManager();
    }

    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse | View
    {
        // User inputs
        $user_inputs = [
            'former_password' => $request->register_former_password,
            'new_password' => $request->register_password,
            'confirm_new_password' => $request->confirm_password
        ];
        $user = $this::$api_client_manager::call('PUT', getApiURL() . '/user/update_password/' . $request->user_id, $request->api_token, $user_inputs);

        if ($user->success) {
            return redirect('/login')->with('success_message', $user->message);

        } else {
			return view('auth.reset-password', [
				'former_password' => $request->register_former_password,
				'temporary_user_id' => $request->user_id,
				'temporary_user_api_token' => $request->api_token,
				'error_title' => __('notifications.error_title'),
				'error_message' => $user->message
			]);
        }
    }
}
