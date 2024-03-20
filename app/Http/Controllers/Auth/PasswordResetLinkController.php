<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\ApiClientManager;

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
        $countries = $this::$api_client_manager::call('GET', getApiURL() . '/country');

        return view('auth.forgot-password', ['countries' => $countries->data]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // User inputs
        $user_inputs = [
            'former_password' => $request->register_former_password,
            'new_password' => $request->register_password,
            'confirm_new_password' => $request->confirm_password
        ];
        $user = $this::$api_client_manager::call('POST', getApiURL() . '/user/update_password/' . $request->user_id, $request->api_token, $user_inputs);

        if ($user->success) {
            return response()->redirectTo('/login');

        } else {
            $error_data = $user->message . '-' . $user->data;
            $inputs_data = $request->former_password        // array[0]
                            . '-' . $request->user_id       // array[1]
                            . '-' . $request->api_token;    // array[2]

            return redirect()->back()->with('error_message', $error_data . '~' . $inputs_data);
        }
    }
}
