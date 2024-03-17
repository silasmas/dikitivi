
        <!-- About Area -->
        <div id="pricing" class="pricing-plan-area section-pt py-5 border-top border-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 m-auto">
                        <!-- Section Title -->
                        <div class="section-title mb-3 text-center">
                            <h2>@lang('miscellaneous.public.about.terms_of_use.title')</h2>
                            <p>@lang('miscellaneous.public.about.terms_of_use.description')</p>
                        </div><!--// Section Title -->
                    </div>
                </div>

                <hr class="mt-4 mb-5">

                <div class="row">
                    <div class="col-lg-9 col-sm-8">
@foreach ($titles as $ttl)
    @if ($ttl['ref'] == 'mission')
                        <hr class="my-5">

                        <h3 class="h3 mb-4 fw-bold">{{ $ttl['title'] }}</h3>

        @foreach ($ttl['contents'] as $cnt)
                        <div class="mb-4">
                            <p class="mb-1 fs-6 text-secondary"><i class="bi bi-chevron-double-right me-2 align-middle fs-5 text-danger"></i> {!! $cnt['content'] !!}</p>
                        </div>
        @endforeach

                        <hr class="my-5">
    @else
                        <h3 class="h3 mb-4 fw-bold">{{ $ttl['title'] }}</h3>

        @foreach ($ttl['contents'] as $cnt)
                        <div class="mb-4">
                            <h5 class="h5 mb-1 fw-semibold dktv-text-green">{{ $cnt['subtitle'] }}</h5>

                            <p class="mb-1 fs-6 text-secondary">{!! $cnt['content'] !!}</p>
                        </div>
        @endforeach
    @endif
@endforeach
                    </div>

