
            <!-- Breadcrumb -->
            <div class="breadcrumb-area bg-image" data-bgimage="{{ asset('assets/img/pub/bg-home.png') }}">
                <div class="container">
                    <div class="in-breadcrumb">
                        <div class="row">
                            <div class="col text-center">
@if (Route::is('about'))
                                <h2>@lang('miscellaneous.public.about.title')</h2>

                                <!-- breadcrumb-list start -->
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                    </li>
                                    <li class="breadcrumb-item active">@lang('miscellaneous.menu.about')</li>
                                </ul>
                                <!-- breadcrumb-list end -->
@endif

@if (Route::is('about.entity'))
                                <h2>{{ $entity_title }}</h2>

                                <!-- breadcrumb-list start -->
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('about') }}">@lang('miscellaneous.menu.about')</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ $entity_menu }}</li>
                                </ul>
                                <!-- breadcrumb-list end -->
@endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--// Breadcrumb -->
