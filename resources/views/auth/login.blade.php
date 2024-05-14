@extends('layouts.guest')

@section('guest-content')

    @if (!empty($children))
                                <h4 class="h4 mb-4 text-muted text-center">@lang('auth.select-your-profile')</h4>

                                <div class="row mb-4 g-2">
        @foreach ($children as $child)
                                    <div class="col-lg-5 col-sm-6 col-11 mx-auto">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="bg-image mb-3">
                                                    <img src="{{ asset($child->avatar_url) }}" alt="{{ $child->firstname . ' ' . $child->lastname }}" class="img-fluid img-thumbnail rounded-circle">
                                                    <div class="mask"></div>
                                                </div>

                                                <h5 class="mb-3 text-center text-truncate">{{ $child->firstname . ' ' . $child->lastname }}</h5>
                                                <form method="POST" action="{{ route('login') }}">
            @csrf
                                                    <input type="hidden" name="child_id" value="{{ $child->id }}">
                                                    <button type="submit" class="btn btn-block dktv-btn-green rounded-pill mb-4 shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.login_title1')</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
        @endforeach
                                </div>
    @else
                                <div class="card border rounded-0 text-center shadow-0">
                                    <div class="card-body py-5">
                                        <h4 class="h4 mb-4 text-center">@lang('miscellaneous.login_title2')</h4>

                                        <form method="POST" action="{{ route('login') }}">
        @csrf

        @if (\Session::has('for_youth'))
            @if (\Session::get('for_youth') == 0)
                                            <div class="form-floating mb-3">
                                                <input type="text" name="login_username" id="login_username" class="form-control" placeholder="@lang('miscellaneous.login_username')" value="{{ \Session::has('error_message_login') ? explode(', ', explode('~', \Session::get('error_message_login'))[1])[0] : '' }}" {{ \Session::has('error_message_login') && !empty(explode(', ', explode('~', \Session::get('error_message_login'))[1])[0])  ? '' : 'autofocus' }}>
                                                <label for="login_username">@lang('miscellaneous.login_username')</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input type="password" name="login_password" id="login_password" class="form-control" placeholder="@lang('miscellaneous.password.label')" {{ \Session::has('error_message_login') && !empty(explode(', ', explode('~', \Session::get('error_message_login'))[1])[0]) ? 'autofocus' : '' }}>
                                                <label for="login_password">@lang('miscellaneous.password.label')</label>
                                            </div>
            @endif

            @if (\Session::get('for_youth') == 1)
                                            <div class="form-floating mb-3">
                                                <input type="text" name="login_parental_code" id="login_parental_code" class="form-control" placeholder="@lang('miscellaneous.parental_code')" value="{{ \Session::has('error_message_login') ? explode(', ', explode('~', \Session::get('error_message_login'))[1])[0] : '' }}" {{ \Session::has('error_message_login') && !empty(explode(', ', explode('~', \Session::get('error_message_login'))[1])[0])  ? '' : 'autofocus' }}>
                                                <label for="login_parental_code">@lang('miscellaneous.parental_code')</label>
                                            </div>
            @endif
        @else
                                            <div class="form-floating mb-3">
                                                <input type="text" name="login_username" id="login_username" class="form-control" placeholder="@lang('miscellaneous.login_username')" value="{{ \Session::has('error_message_login') ? explode(', ', explode('~', \Session::get('error_message_login'))[1])[0] : '' }}" {{ \Session::has('error_message_login') && !empty(explode(', ', explode('~', \Session::get('error_message_login'))[1])[0])  ? '' : 'autofocus' }}>
                                                <label for="login_username">@lang('miscellaneous.login_username')</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input type="password" name="login_password" id="login_password" class="form-control" placeholder="@lang('miscellaneous.password.label')" {{ \Session::has('error_message_login') && !empty(explode(', ', explode('~', \Session::get('error_message_login'))[1])[0]) ? 'autofocus' : '' }}>
                                                <label for="login_password">@lang('miscellaneous.password.label')</label>
                                            </div>
        @endif

                                            <div class="row mb-3">
                                                <div class="col-sm-6 d-flex justify-content-center mx-auto">
                                                    <div class="form-check">
                                                        <input type="checkbox" id="login_remember" class="form-check-input" />
                                                        <label class="form-check-label" for="login_remember">@lang('miscellaneous.remember_me')</label>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6{{ \Session::has('for_youth') ? (\Session::get('for_youth') == 1 ? ' d-none' : '') : '' }}">
                                                    <a href="{{ route('password.request') }}">@lang('miscellaneous.forgotten_password')</a>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-block dktv-btn-blue rounded-pill mb-4 shadow-0" style="text-transform: inherit!important;">@lang('auth.login')</button>

        @if (\Session::has('for_youth'))
            @if (\Session::get('for_youth') == 0)
                                            <a href="{{ route('choose_age', ['for_youth' => 1]) }}" class="btn btn-block dktv-btn-yellow border-0 rounded-pill text-dark shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.iam_child')</a>
            @endif

            @if (\Session::get('for_youth') == 1)
                                            <a href="{{ route('choose_age', ['for_youth' => 0]) }}" class="btn btn-block dktv-btn-green border-0 rounded-pill text-dark shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.iam_adult')</a>
            @endif
        @endif
                                            <a href="{{ route('register') }}" class="btn btn-block dktv-btn-gray border-0 rounded-pill text-dark shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.go_register')</a>
                                        </form>
                                    </div>
                                </div>
    @endif

@endsection
