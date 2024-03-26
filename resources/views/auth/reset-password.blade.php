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

                                            <div class="mb-3">
                                                <label for="register_password">@lang('miscellaneous.account.update_password.new_password')</label>
                                                <div class="input-group">
                                                    <input type="password" name="register_password" id="register_password" class="form-control" placeholder="@lang('miscellaneous.account.update_password.new_password')" autofocus>
                                                    <div class="input-group-btn px-2 border-0">
                                                        <button class="btn btn-default bg-transparent border-0" type="button" onclick="event.stopPropagation(); event.preventDefault(); passwordVisible(this, 'register_password')"><i class="bi bi-eye"></i></button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="confirm_password">@lang('miscellaneous.account.update_password.confirm_password')</label>
                                                <div class="input-group">
                                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="@lang('miscellaneous.account.update_password.confirm_password')">
                                                    <div class="input-group-btn px-2 border-0">
                                                        <button class="btn btn-default bg-transparent border-0" type="button" onclick="event.stopPropagation(); event.preventDefault(); passwordVisible(this, 'confirm_password')"><i class="bi bi-eye"></i></button>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-block dktv-btn-blue rounded-pill shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.register')</button>
                                            <a href="{{ route('login') }}" class="btn btn-block dktv-btn-gray border-0 rounded-pill text-dark shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.cancel')</a>
                                        </form>
                                    </div>
                                </div>

@endsection
