@extends('layouts.guest')

@section('guest-content')

                                <div class="card border rounded-0 text-center shadow-0">
                                    <div class="card-body py-5">
                                        <h4 class="h4 mb-2 text-center">@lang('auth.reset-password')</h4>
                                        <p class="mb-4 text-secondary">@lang('auth.verify-email-phone')</p>

                                        <form method="POST" action="{{ route('register') }}">
    @csrf

                                            <input type="hidden" name="redirect" value="reset_password">

                                            <div class="row mb-4">
                                                <div class="form-floating mb-3">
                                                    <input type="text" name="register_email" id="register_email" class="form-control" placeholder="@lang('miscellaneous.email')" value="{{ \Session::has('error_message') ? explode('-', explode('~', \Session::get('error_message'))[1])[2] : '' }}">
                                                    <label for="register_email">@lang('miscellaneous.email')</label>
                                                </div>

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

                                            <button type="submit" class="btn btn-block dktv-btn-pink rounded-pill shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.start')</button>
                                            <a href="{{ route('login') }}" class="btn btn-block dktv-btn-gray border-0 rounded-pill text-dark shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.go_login')</a>
                                        </form>
                                    </div>
                                </div>

@endsection
