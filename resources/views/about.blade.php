@extends('layouts.welcome')

@section('welcome-content')

    @if (Route::is('about'))
        @include('partials.about.about')
    @endif

    @if (Route::is('about.entity'))
        @include('partials.about.' . $entity)
    @endif

                    <div class="col-sm-4 detect-webview">
                        <div class="card border border-default shadow-0">
                            <div class="card-body">
                                <h4 class="h4 mb-4 text-black fw-bold">@lang('miscellaneous.public.about.other_links.title')</h4>

    @if (Route::is('about'))
                                <a href="{{ route('about.entity', ['entity' => 'terms_of_use']) }}" class="btn btn-sm dktv-btn-blue btn-block mb-2 pb-1 rounded-pill shadow-0">@lang('miscellaneous.public.about.terms_of_use.title')</a>
                                <a href="{{ route('about.entity', ['entity' => 'privacy_policy']) }}" class="btn btn-sm dktv-btn-blue btn-block mb-2 pb-1 rounded-pill shadow-0">@lang('miscellaneous.public.about.privacy_policy.title')</a>
                                {{-- <a href="{{ route('about.entity', ['entity' => 'contact']) }}" class="btn btn-sm dktv-btn-blue btn-block mb-2 pb-1 rounded-pill shadow-0">@lang('miscellaneous.public.about.contact.title')</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--// About Area -->

    @endif

    @if (Route::is('about.entity'))
        @if ($entity == 'terms_of_use')
                                <a href="{{ route('about') }}" class="btn btn-sm dktv-btn-blue btn-block mb-2 pb-1 rounded-pill shadow-0">@lang('miscellaneous.menu.about')</a>
                                <a href="{{ route('about.entity', ['entity' => 'privacy_policy']) }}" class="btn btn-sm dktv-btn-blue btn-block mb-2 pb-1 rounded-pill shadow-0">@lang('miscellaneous.public.about.privacy_policy.title')</a>
                                <a href="{{ route('about.entity', ['entity' => 'contact']) }}" class="btn btn-sm dktv-btn-blue btn-block mb-2 pb-1 rounded-pill shadow-0">@lang('miscellaneous.public.about.contact.title')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--// About Area -->

        @endif

        @if ($entity == 'privacy_policy')
                                <a href="{{ route('about') }}" class="btn btn-sm dktv-btn-blue btn-block mb-2 pb-1 rounded-pill shadow-0">@lang('miscellaneous.menu.about')</a>
                                <a href="{{ route('about.entity', ['entity' => 'terms_of_use']) }}" class="btn btn-sm dktv-btn-blue btn-block mb-2 pb-1 rounded-pill shadow-0">@lang('miscellaneous.public.about.terms_of_use.title')</a>
                                <a href="{{ route('about.entity', ['entity' => 'contact']) }}" class="btn btn-sm dktv-btn-blue btn-block mb-2 pb-1 rounded-pill shadow-0">@lang('miscellaneous.public.about.contact.title')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--// About Area -->

        @endif

        @if ($entity == 'contact')
                                <a href="{{ route('about') }}" class="btn btn-sm dktv-btn-blue btn-block mb-2 pb-1 rounded-pill shadow-0">@lang('miscellaneous.menu.about')</a>
                                <a href="{{ route('about.entity', ['entity' => 'terms_of_use']) }}" class="btn btn-sm dktv-btn-blue btn-block mb-2 pb-1 rounded-pill shadow-0">@lang('miscellaneous.public.about.terms_of_use.title')</a>
                                <a href="{{ route('about.entity', ['entity' => 'privacy_policy']) }}" class="btn btn-sm dktv-btn-blue btn-block mb-2 pb-1 rounded-pill shadow-0">@lang('miscellaneous.public.about.privacy_policy.title')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--// About Area -->

        <!-- Map location Area -->
        <div class="map-wrapper relative">
            <div class="gogle_map">
                <div id="googleMap">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3978.311381827949!2d15.264175774090075!3d-4.352566346663912!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a6a3107fc94200d%3A0xc35ccb7ced83c173!2s13%20Av.%20du%20Grand%20Seminaire%2C%20Kinshasa!5e0!3m2!1sfr!2scd!4v1708708658879!5m2!1sfr!2scd" style="width:100%; height: 100%; border:0;" allowfullscreen="true" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <div class="contact-info-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 ms-auto">
                            <div class="contact-info-inner">
                                <!-- Single-contact-info -->
                                <div class="single-contact-info">
                                    <div class="contact-info-icon">
                                        <i class="zmdi zmdi-home"></i>
                                    </div>
                                    <div class="contact-info-text">
                                        <p>@lang('miscellaneous.public.footer.head_office.address')</p>
                                    </div>
                                </div>
                                <!--// Single-contact-info -->

                                {{-- <!-- Single-contact-info -->
                                <div class="single-contact-info">
                                    <div class="contact-info-icon">
                                        <i class="zmdi zmdi-phone"></i>
                                    </div>
                                    <div class="contact-info-text">
                                        <p><a href="#" class="text-white">@lang('miscellaneous.public.footer.head_office.phone')</a></p>
                                    </div>
                                </div>
                                <!--// Single-contact-info --> --}}

                                <!-- Single-contact-info -->
                                <div class="single-contact-info">
                                    <div class="contact-info-icon">
                                        <i class="zmdi zmdi-email"></i>
                                    </div>
                                    <div class="contact-info-text">
                                        <p><a href="#" class="text-white">@lang('miscellaneous.public.footer.head_office.email')</a> </p>
                                    </div>
                                </div>
                                <!--// Single-contact-info -->

                                <!-- Single-contact-info -->
                                <div class="single-contact-info">
                                    <div class="contact-info-icon">
                                        <i class="zmdi zmdi-globe-alt"></i>
                                    </div>
                                    <div class="contact-info-text">
                                        <p><a href="{{ route('home') }}" class="text-white">www.dikitivi.com</a></p>
                                    </div>
                                </div>
                                <!--// Single-contact-info -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--// Map location Area -->

        @endif
    @endif

@endsection
