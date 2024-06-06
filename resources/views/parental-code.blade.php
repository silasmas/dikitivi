@extends('layouts.app')

@section('app-content')

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
                                                <form method="POST" action="{{ route('parental_code') }}">
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
                                <div class="card border rounded-6 text-center shadow-0 overflow-hidden">
                                    <div class="card-body pt-0 pb-4 px-0">
                                        <h4 class="h4 mb-4">@lang('miscellaneous.login_title3')</h4>

                                        <form method="POST" action="{{ route('parental_code') }}">
        @csrf
                                            <input type="hidden" name="parent_id" value="{{ $current_user->id }}">

                                            <div class="form-floating mb-3">
                                                <input type="text" name="login_parental_code" id="login_parental_code" class="form-control mb-4" placeholder="@lang('miscellaneous.parental_code')" value="{{ \Session::has('error_message_login') ? explode(', ', explode('~', \Session::get('error_message_login'))[1])[0] : '' }}" {{ \Session::has('error_message_login') && !empty(explode(', ', explode('~', \Session::get('error_message_login'))[1])[0])  ? '' : 'autofocus' }}>
                                                <label for="login_parental_code">@lang('miscellaneous.parental_code')</label>
                                            </div>

                                        </form>
                                    </div>
                                </div>
    @endif

@endsection
