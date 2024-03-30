@extends('layouts.guest')

@section('guest-content')

                                <div class="card border rounded-6 text-center shadow-0 overflow-hidden">
                                    <div class="card-body pt-0 pb-4 px-0">
                                        <div class="bg-image">
                                            <img src="{{ asset('assets/img/coming-soon.png') }}" alt="" class="img-fluid">
                                            <div class="mask"></div>
                                        </div>

                                        <p class="lead mt-4 mb-0">@lang('miscellaneous.coming_soon')</p>
                                    </div>
                                </div>

@endsection
