@extends('layouts.guest')

@section('guest-content')

                                <div class="card border rounded-0 text-center shadow-0">
                                    <div class="card-body py-5">
                                        <h4 class="h4 mb-4 text-center">@lang('auth.reset-password')</h4>

                                        <form method="POST" action="{{ route('password.email') }}">
    @csrf
                                            <input type="hidden" name="register_former_password" value="{{ $former_password }}">
                                            <input type="hidden" name="user_id" value="{{ !empty($temporary_user_id) ? $temporary_user_id : $temporary_user->id }}">
                                            <input type="hidden" name="api_token" value="{{ !empty($temporary_user_api_token) ? $temporary_user_api_token : $temporary_user->api_token }}">

                                            <div class="form-floating mb-3">
                                                <input type="password" name="register_password" id="register_password" class="form-control" placeholder="@lang('miscellaneous.account.update_password.new_password')" autofocus>
                                                <label for="register_password">@lang('miscellaneous.account.update_password.new_password')</label>
                                            </div>

                                            <div class="form-floating mb-4">
                                                <input type="password" name="register_password" id="register_password" class="form-control" placeholder="@lang('miscellaneous.account.update_password.confirm_password')">
                                                <label for="register_password">@lang('miscellaneous.account.update_password.confirm_password')</label>
                                            </div>

                                            <button type="submit" class="btn btn-block dktv-btn-blue rounded-pill shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.register')</button>
                                            <a href="{{ route('login') }}" class="btn btn-block dktv-btn-gray border-0 rounded-pill text-dark shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.cancel')</a>
                                        </form>
                                    </div>
                                </div>

@endsection
