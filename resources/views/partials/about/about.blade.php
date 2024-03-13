
        <!-- Pricing Area -->
        <div id="pricing" class="pricing-plan-area section-pt py-5 border-top border-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 m-auto">
                        <!-- Section Title -->
                        <div class="section-title mb-3 text-center">
                            <h2>@lang('miscellaneous.public.home.pricing.title')</h2>
                            <p>@lang('miscellaneous.public.home.pricing.content')</p>
                        </div><!--// Section Title -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 m-auto">
                        <form id="data" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="media_title" class="form-label visually-hidden">Video Title</label>
                                <input type="text" name="media_title" id="media_title" class="form-control" placeholder="Video Title">
                            </div>
                            <div class="mb-3">
                                <label for="youtube_video" class="form-label">Upload video</label>
                                <input type="file" name="youtube_video" id="youtube_video" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label for="cover_url" class="form-label">Upload cover</label>
                                <input type="file" name="cover_url" id="cover_url" class="form-control" />
                            </div>

                            <button class="btn btn-primary w-100 mb-3 shadow-0">@lang('miscellaneous.send')</button>
                            <p class="text-center"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--// Pricing Area -->

