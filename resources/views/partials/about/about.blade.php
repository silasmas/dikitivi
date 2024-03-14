
        <!-- Pricing Area -->
        <div id="pricing" class="pricing-plan-area section-pt py-5 border-top border-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 m-auto">
                        <!-- Section Title -->
                        <div class="section-title mb-3 text-center">
                            <h2>@lang('miscellaneous.public.about.title')</h2>
                            <p></p>
                        </div><!--// Section Title -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 m-auto">
                        <form id="data" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="media_title" class="form-label mb-1 visually-hidden">Video Title</label>
                                <input type="text" name="media_title" id="media_title" class="form-control" placeholder="Video Title">
                            </div>

                            <div class="mb-3">
                                <label for="author_names" class="form-label mb-1 visually-hidden">Author names</label>
                                <input type="text" name="author_names" id="author_names" class="form-control" placeholder="Author names">
                            </div>

                            <div class="mb-3">
                                <label for="author_names" class="form-label mb-1 visually-hidden">For Youth</label>
                                <div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="for_youth" id="for_youth_1" value="1">
									<label class="form-check-label" for="for_youth_1">Yes</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="for_youth" id="for_youth_0" value="0">
									<label class="form-check-label" for="for_youth_0">No</label>
								</div>
                            </div>

                            <div class="mb-3">
                                <label for="youtube_video" class="form-label mb-1">Upload video</label>
                                <input type="file" name="youtube_video" id="youtube_video" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label for="cover_url" class="form-label mb-1">Upload cover</label>
                                <input type="file" name="cover_url" id="cover_url" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label for="cover_url" class="form-label mb-1">Media type</label>
                                <select name="type_id" id="type_id" class="form-select" aria-label="Media type">
									<option class="small" selected disabled>Choose a type</option>
@forelse ($types->data as $type)
									<option value="{{ $type->id }}">{{ $type->type_name }}</option>
@empty
@endforelse
								</select>
                            </div>

                            <div class="mb-3">
                                <label for="cover_url" class="form-label mb-1">Belongs to</label>
                                <select name="belongs_to" id="belongs_to" class="form-select" aria-label="Select a TV series">
									<option class="small" selected disabled>Choose a TV series</option>
@forelse ($medias->data as $media)
									<option value="{{ $media->id }}">{{ $media->media_title }}</option>
@empty
@endforelse
								</select>
                            </div>

                            <button class="btn btn-primary w-100 mb-3 shadow-0">@lang('miscellaneous.send')</button>
                            <p class="text-center"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--// Pricing Area -->

