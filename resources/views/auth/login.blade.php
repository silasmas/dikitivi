@extends('layouts.guest')

@section('guest-content')

                                <div class="card border rounded-0 text-center shadow-0">
                                    <div class="card-body py-5">
                                        <h4 class="h4 mb-4 text-center">@lang('miscellaneous.login_title2')</h4>

                                        <form method="POST" action="{{ route('login') }}">
    @csrf
                                            <div class="form-floating mb-3">
                                                <input type="username" name="login_username" id="login_username" class="form-control" aria-describedby="login_username_error" placeholder="@lang('miscellaneous.login_username')" value="{{ \Session::has('response_error') ? explode('-', \Session::get('response_error'))[0] : '' }}" {{ \Session::has('response_error') && !empty(explode('-', \Session::get('response_error'))[0])  ? '' : 'autofocus' }}>
                                                <label for="login_username">@lang('miscellaneous.login_username')</label>
    @if (\Session::has('response_error') && explode('-', \Session::get('response_error'))[2] == explode('-', \Session::get('response_error'))[0])
                                                <small id="login_username_error" class="form-text text-danger">{{ explode('-', \Session::get('response_error'))[3] }}</small>
    @endif
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input type="password" name="login_password" id="login_password" class="form-control" aria-describedby="login_password_error" placeholder="@lang('miscellaneous.password.label')" {{ \Session::has('response_error') && !empty(explode('-', \Session::get('response_error'))[0]) ? 'autofocus' : '' }}>
                                                <label for="login_password">@lang('miscellaneous.password.label')</label>
    @if (\Session::has('response_error') && explode('-', \Session::get('response_error'))[2] == explode('-', \Session::get('response_error'))[1])
                                                <small id="login_password_error" class="form-text text-danger">{{ explode('-', \Session::get('response_error'))[3] }}</small>
    @endif
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-6 d-flex justify-content-center">
                                                    <div class="form-check">
                                                        <input type="checkbox" id="login_remember" class="form-check-input" />
                                                        <label class="form-check-label" for="login_remember">@lang('miscellaneous.remember_me')</label>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <a href="{{ route('password.request') }}">@lang('miscellaneous.forgotten_password')</a>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-block dktv-btn-blue rounded-pill shadow-0" style="text-transform: inherit!important;">@lang('auth.login')</button>
                                            <a href="{{ route('register') }}" class="btn btn-block dktv-btn-gray border-0 rounded-pill text-dark shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.go_register')</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--// login-register End -->

@endsection
