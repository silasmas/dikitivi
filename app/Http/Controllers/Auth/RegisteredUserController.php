<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Http\Controllers\ApiClientManager;

class RegisteredUserController extends Controller
{
    public static $api_client_manager;

    public function __construct()
    {
        $this::$api_client_manager = new ApiClientManager();
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Find users having the role "Membre" to verify if the register page can be displayed or not
        $role_data = 'Membre';
        $member_role = $this::$api_client_manager::call('GET', getApiURL() . '/role/search/' . $role_data, getApiToken());

        if (count($member_role->data) > 0) {
            abort(403);

        } else {
            return view('auth.register', ['member_role' => $member_role->data]);
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // User inputs
        $user_inputs = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'surname' => $request->surname,
            'gender' => $request->gender,
            'birth_date' => str_starts_with(app()->getLocale(), 'fr') || str_starts_with(app()->getLocale(), 'ln') ? explode('/', $request->register_birthdate)[2] . '-' . explode('/', $request->register_birthdate)[1] . '-' . explode('/', $request->register_birthdate)[0] : explode('/', $request->register_birthdate)[2] . '-' . explode('/', $request->register_birthdate)[0] . '-' . explode('/', $request->register_birthdate)[1],
            'city' => $request->city,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'p_o_box' => $request->p_o_box,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'password' => $request->register_password,
            'confirm_password' => $request->confirm_password,
            'belongs_to' => $request->belongs_to,
            'parental_code' => $request->parental_code,
            'api_token' => $request->api_token,
            'prefered_theme' => $request->prefered_theme,
            'country_id' => $request->country_id,
            'role_id' => $request->role_id
        ];
        // Register user API
        $user = $this::$api_client_manager::call('POST', getApiURL() . '/user', getApiToken(), $user_inputs);

        if ($user->success) {
            // Authentication datas (E-mail or Phone number)
            $auth_phone = Auth::attempt(['phone' => $user->data->user->phone, 'password' => $user_inputs['password']]);
            $auth_email = Auth::attempt(['email' => $user->data->user->email, 'password' => $user_inputs['password']]);
            if ($auth_phone || $auth_email) {
                $request->session()->regenerate();
                return redirect()->route('home');
            }

        } else {
            $resp_error = $user_inputs['firstname']                     // array[0]
                            . '-' . $user_inputs['lastname']            // array[1]
                            . '-' . $user_inputs['surname']             // array[2]
                            . '-' . $user_inputs['phone']               // array[3]
                            . '-' . $user_inputs['email']               // array[4]
                            . '-' . $user_inputs['password']            // array[5]
                            . '-' . $user_inputs['confirm_password']    // array[6]
                            . '-' . $user->message                      // array[7]
                            . '-' . $user->data;                        // array[8]
            return redirect('/register')->with('response_error', $resp_error);
        }    
    }
}
