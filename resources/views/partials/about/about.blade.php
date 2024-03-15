
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
						<div class="card border rounded-5 overflow-hidden shadow-0">
							<div class="card-header py-3">
								<h3 class="mb-0 text-center fw-bold">Add a media</h3>
							</div>

							<div class="card-body">
								<form id="data" method="post" enctype="multipart/form-data">
									<div class="mb-3">
										<label for="cover_url" class="form-label mb-0">Media type</label>
										<select name="type_id" id="type_id" class="form-select" aria-label="Media type">
											<option class="small" selected disabled>Choose a type</option>
@forelse ($types->data as $type)
											<option value="{{ $type->id }}">{{ $type->type_name }}</option>
@empty
@endforelse
										</select>
									</div>

									<div class="mb-3">
										<label for="media_title" class="form-label mb-0 visually-hidden">Video Title</label>
										<input type="text" name="media_title" id="media_title" class="form-control" placeholder="Video Title">
									</div>

									<div class="mb-3">
										<label for="media_url" class="form-label mb-0 visually-hidden">Video URL (YouTube or other)</label>
										<input type="text" name="media_url" id="media_url" class="form-control" placeholder="Video URL (YouTube or other)">
									</div>

									<div class="mb-3">
										<label for="author_names" class="form-label mb-0 visually-hidden">Author names</label>
										<input type="text" name="author_names" id="author_names" class="form-control" placeholder="Author names">
									</div>

									<div class="mb-3">
										<label for="writer" class="form-label mb-0 visually-hidden">Written by</label>
										<input type="text" name="writer" id="writer" class="form-control" placeholder="Written by">
									</div>

									<div class="mb-3">
										<label for="director" class="form-label mb-0 visually-hidden">Film director</label>
										<input type="text" name="director" id="director" class="form-control" placeholder="Film director">
									</div>

									<div class="mb-3">
										<label for="price" class="form-label mb-0 visually-hidden">DVD price (in USD)</label>
										<input type="number" name="price" id="price" class="form-control" placeholder="DVD price (in USD)">
									</div>

									<div class="mb-1 text-center">
										<label for="author_names" class="form-label mb-0 d-block">Is the media for children?</label>
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
										<label for="teaser_url" class="form-label mb-0">Upload teaser <i role="button" class="bi bi-question-circle" title="Upload a short video featuring your post" data-bs-toggle="tooltip"></i></label>
										<input type="file" name="teaser_url" id="teaser_url" class="form-control" />
									</div>

									<!--<div class="mb-3">
										<label for="youtube_video" class="form-label mb-0">Upload video</label>
										<input type="file" name="youtube_video" id="youtube_video" class="form-control" />
									</div>-->

									<div class="mb-3">
										<label for="cover_url" class="form-label mb-0">Upload cover</label>
										<input type="file" name="cover_url" id="cover_url" class="form-control" />
									</div>

									<div class="mb-3">
										<label for="cover_url" class="form-label mb-0">Belongs to</label>
										<select name="belongs_to" id="belongs_to" class="form-select" aria-label="Select a TV series">
											<option class="small" selected disabled>Choose a TV series</option>
@forelse ($medias->data as $media)
											<option value="{{ $media->id }}">{{ $media->media_title }}</option>
@empty
@endforelse
										</select>
									</div>

									<div class="mb-4 text-center">
										<label for="author_names" class="form-label mb-0 d-block">Is the media live?</label>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="is_live" id="is_live_1" value="1">
											<label class="form-check-label" for="is_live_1">Yes</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="is_live" id="is_live_0" value="0">
											<label class="form-check-label" for="is_live_0">No</label>
										</div>
									</div>

									<div class="row g-2">
										<div class="col-sm-6">
											<button class="btn btn-primary w-100 mb-3 shadow-0">@lang('miscellaneous.send')</button>
										</div>
										<div class="col-sm-6">
											<button type="reset" class="btn btn-secondary w-100 mb-3 shadow-0">@lang('miscellaneous.reset')</button>
										</div>
									</div>

									<p class="text-center"></p>
								</form>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
        <!--// Pricing Area -->

