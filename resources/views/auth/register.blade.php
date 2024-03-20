@extends('layouts.guest')

@section('guest-content')

                                <div class="card border rounded-0 text-center shadow-0">
                                    <div class="card-body py-5">
                                        <h4 class="h4 mb-4 text-center">@lang('miscellaneous.register_title2')</h4>

                                        <form method="POST" action="{{ route('register') }}">
    @csrf

    @if (!empty($token_sent))
                                            <input type="hidden" name="email" value="{{ $email }}">
                                            <input type="hidden" name="phone" value="{{ $phone }}">
                                            <input type="hidden" name="token" value="{{ $token_sent }}">

                                            <div class="row mb-4">
                                                <div class="col-sm-8 mx-auto">
                                                    <div class="d-flex">
                                                        <div class="flex-fill me-1">
                                                            <input type="text" name="check_digit_1" id="check_digit_1" class="form-control text-center" autofocus onkeydown="tokenWritter('check_digit_1')">
                                                        </div>
                                                        <div class="flex-fill me-1">
                                                            <input type="text" name="check_digit_2" id="check_digit_2" class="form-control text-center" onkeydown="tokenWritter('check_digit_2')">
                                                        </div>
                                                        <div class="flex-fill me-1">
                                                            <input type="text" name="check_digit_3" id="check_digit_3" class="form-control text-center" onkeydown="tokenWritter('check_digit_3')">
                                                        </div>
                                                        <div class="flex-fill me-1">
                                                            <input type="text" name="check_digit_4" id="check_digit_4" class="form-control text-center" onkeydown="tokenWritter('check_digit_4')">
                                                        </div>
                                                        <div class="flex-fill me-1">
                                                            <input type="text" name="check_digit_5" id="check_digit_5" class="form-control text-center" onkeydown="tokenWritter('check_digit_5')">
                                                        </div>
                                                        <div class="flex-fill me-1">
                                                            <input type="text" name="check_digit_6" id="check_digit_6" class="form-control text-center" onkeydown="tokenWritter('check_digit_6')">
                                                        </div>
                                                        <div class="flex-fill">
                                                            <input type="text" name="check_digit_7" id="check_digit_7" class="form-control text-center" onkeydown="tokenWritter('check_digit_7')">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-block dktv-btn-green rounded-pill shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.send')</button>
                                            <a href="{{ route('home') }}" class="btn btn-block dktv-btn-gray border-0 rounded-pill text-dark shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.cancel')</a>

    @else
        @if (!empty($temporary_user))
                                            <input type="hidden" name="temporary_user_id" value="{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[11] : $temporary_user->id }}">
                                            <input type="hidden" name="api_token" value="{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[12] : $temporary_user->api_token }}">

                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" name="register_firstname" id="register_firstname" class="form-control" placeholder="@lang('miscellaneous.firstname')" value="{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[0] : $temporary_user->firstname }}" autofocus>
                                                        <label for="register_firstname">@lang('miscellaneous.firstname')</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" name="register_lastname" id="register_lastname" class="form-control" placeholder="@lang('miscellaneous.lastname')" value="{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[1] : $temporary_user->lastname }}">
                                                        <label for="register_lastname">@lang('miscellaneous.lastname')</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" name="register_surname" id="register_surname" class="form-control" placeholder="@lang('miscellaneous.surname')" value="{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[2] : $temporary_user->surname }}">
                                                        <label for="register_surname">@lang('miscellaneous.surname')</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" name="register_birthdate" id="register_birthdate" class="form-control" placeholder="@lang('miscellaneous.birth_date.label')" value="{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[4] : '' }}">
                                                        <label for="register_birthdate">@lang('miscellaneous.birth_date.label')</label>
                                                    </div>
                                                </div>

                                                <div class="{{ empty($temporary_user->email) ? 'col-md-6' : 'col-12' }}">
                                                    <label class="form-label mb-0 d-block">@lang('miscellaneous.gender_title')</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="register_gender" id="register_gender_1" value="M"{{ \Session::has('error_message') ? (explode('-', explode('~', \Session::get('error_message'))[1])[3] == 'M' ? ' checked' : '') : '' }}>
                                                        <label class="form-check-label" for="register_gender_1">@lang('miscellaneous.gender1')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="register_gender" id="register_gender_2" value="F"{{ \Session::has('error_message') ? (explode('-', explode('~', \Session::get('error_message'))[1])[3] == 'F' ? ' checked' : '') : '' }}>
                                                        <label class="form-check-label" for="register_gender_2">@lang('miscellaneous.gender2')</label>
                                                    </div>
                                                </div>

            @if (empty($temporary_user->email))
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" name="register_email" id="register_email" class="form-control" placeholder="@lang('miscellaneous.email')" value="{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[9] : '' }}">
                                                        <label for="register_email">@lang('miscellaneous.email')</label>
                                                    </div>
                                                </div>
            @endif

            @if (empty($temporary_user->phone))
                                                <div class="col-12">
                                                    <div class="row g-3">
                                                        <div class="col-sm-5">
                                                            <div class="form-floating pt-0">
                                                                <select name="select_country" id="select_country1" class="form-select pt-2 shadow-0">
                                                                    <option class="small" selected disabled>@lang('miscellaneous.choose_country')</option>
                @forelse ($countries as $country)
                                                                    <option value="{{ '+' . $country->country_phone_code . '-' . $country->id }}">{{ $country->country_name }}</option>
                @empty
                                                                    <option>@lang('miscellaneous.empty_list')</option>
                @endforelse
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-7">
                                                            <div class="input-group">
                                                                <span id="phone_code_text1" class="input-group-text d-inline-block h-100" style="padding-top: 0.3rem; padding-bottom: 0.5rem; line-height: 1.35;">
                                                                    <small class="text-muted m-0 p-0" style="font-size: 0.75rem;">@lang('miscellaneous.phone_code')</small><br>
                                                                    <span class="text-value">xxxx</span> 
                                                                </span>

                                                                <div class="form-floating">
                                                                    <input type="hidden" id="country_id1" name="country_id" value="">
                                                                    <input type="hidden" id="phone_code1" name="phone_code" value="">
                                                                    <input type="tel" name="phone_number" id="phone_number" class="form-control" placeholder="@lang('miscellaneous.phone')">
                                                                    <label for="phone_number">@lang('miscellaneous.phone')</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
            @endif

                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" name="register_city" id="register_city" class="form-control" placeholder="@lang('miscellaneous.address.city')" value="{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[5] : '' }}">
                                                        <label for="register_city">@lang('miscellaneous.address.city')</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-span-2">
                                                    <div class="form-floating">
                                                        <input type="text" name="register_p_o_box" id="register_p_o_box" class="form-control" placeholder="@lang('miscellaneous.p_o_box')" value="{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[8] : '' }}">
                                                        <label for="register_p_o_box">@lang('miscellaneous.p_o_box')</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <textarea name="register_address_1" id="register_address_1" class="form-control" placeholder="@lang('miscellaneous.address.line1')">{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[6] : '' }}</textarea>
                                                        <label for="register_address_1">@lang('miscellaneous.address.line1')</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <textarea name="register_address_2" id="register_address_2" class="form-control" placeholder="@lang('miscellaneous.address.line2')">{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[7] : '' }}</textarea>
                                                        <label for="register_address_2">@lang('miscellaneous.address.line2')</label>
                                                    </div>
                                                </div>

                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <div class="col-md-6 mx-auto">
                                                            <div class="form-floating">
                                                                <input type="text" name="register_username" id="register_username" class="form-control" placeholder="@lang('miscellaneous.username')" value="{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[10] : '' }}">
                                                                <label for="register_username">@lang('miscellaneous.username')</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="password" name="register_password" id="register_password" class="form-control" placeholder="@lang('miscellaneous.password.label')">
                                                        <label for="register_password">@lang('miscellaneous.password.label')</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="@lang('miscellaneous.confirm_password.label')">
                                                        <label for="confirm_password">@lang('miscellaneous.confirm_password.label')</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-block dktv-btn-pink rounded-pill shadow-0" style="text-transform: inherit!important;">@lang('auth.register')</button>
                                            <a href="{{ route('home') }}" class="btn btn-block dktv-btn-gray border-0 rounded-pill text-dark shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.cancel')</a>

        @else
                                            <input type="hidden" name="role_id" value="{{ $role_id }}">

                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" name="register_firstname" id="register_firstname" class="form-control" placeholder="@lang('miscellaneous.firstname')" value="{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[0] : '' }}" autofocus required>
                                                        <label for="register_firstname">@lang('miscellaneous.firstname')</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" name="register_lastname" id="register_lastname" class="form-control" placeholder="@lang('miscellaneous.surname')" value="{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[1] : '' }}">
                                                        <label for="register_lastname">@lang('miscellaneous.lastname')</label>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-floating">
                                                        <input type="text" name="register_email" id="register_email" class="form-control" placeholder="@lang('miscellaneous.email')" value="{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[2] : '' }}">
                                                        <label for="register_email">@lang('miscellaneous.email')</label>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="row g-3">
                                                        <div class="col-sm-5">
                                                            <div class="form-floating pt-0">
                                                                <select name="select_country" id="select_country1" class="form-select pt-2 shadow-0">
                                                                    <option class="small" selected disabled>@lang('miscellaneous.choose_country')</option>
            @forelse ($countries as $country)
                                                                    <option value="{{ '+' . $country->country_phone_code . '-' . $country->id }}">{{ $country->country_name }}</option>
            @empty
                                                                    <option>@lang('miscellaneous.empty_list')</option>
            @endforelse
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-7">
                                                            <div class="input-group">
                                                                <span id="phone_code_text1" class="input-group-text d-inline-block h-100" style="padding-top: 0.3rem; padding-bottom: 0.5rem; line-height: 1.35;">
                                                                    <small class="text-muted m-0 p-0" style="font-size: 0.75rem;">@lang('miscellaneous.phone_code')</small><br>
                                                                    <span class="text-value">xxxx</span> 
                                                                </span>

                                                                <div class="form-floating">
                                                                    <input type="hidden" id="country_id1" name="country_id" value="">
                                                                    <input type="hidden" id="phone_code1" name="phone_code" value="">
                                                                    <input type="tel" name="phone_number" id="phone_number" class="form-control" placeholder="@lang('miscellaneous.phone')">
                                                                    <label for="phone_number">@lang('miscellaneous.phone')</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-block dktv-btn-pink rounded-pill shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.start')</button>
                                            <a href="{{ route('login') }}" class="btn btn-block dktv-btn-gray border-0 rounded-pill text-dark shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.go_login')</a>
        @endif
    @endif
                                        </form>
                                    </div>
                                </div>

@endsection
