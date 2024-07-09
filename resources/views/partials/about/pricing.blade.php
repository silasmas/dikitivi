
        <!-- About Area -->
        <div id="pricing" class="pricing-plan-area section-pt py-5 border-top border-bottom">
            <div class="container-sm container-fluid">
                <div class="row">
                    <div class="col-lg-6 m-auto">
                        <!-- Section Title -->
                        <div class="section-title mb-3 text-center">
                            <h2>TEST: Add/Update a media</h2>
                            <p>A form to test media registering</p>
                        </div><!--// Section Title -->
                    </div>
                </div>

                <hr class="mt-4 mb-5">

                <div class="row">
                    <div class="col-lg-6">
						<div class="card border rounded-5 overflow-hidden shadow-0">
							<div class="card-header py-3">
								<h3 class="mb-0 text-center fw-bold">Add/Update a media</h3>
							</div>

							<div class="card-body">
								<form id="data">
@csrf
@if (!empty($current_media))
									<input type="hidden" name="id" id="id" value="{{ $current_media->id }}">
@endif
									<div class="mb-3">
										<label for="cover_url" class="form-label mb-0">Media type</label>
										<select name="type_id" id="type_id" class="form-select" aria-label="Media type">
											<option class="small" disabled{{ empty($current_media) ? ' selected' : '' }}>Choose a type</option>
@forelse ($types as $type)
											<option value="{{ $type->id }}"{{ !empty($current_media) && $current_media->type->id == $type->id ? ' selected' : '' }}>{{ $type->type_name }}</option>
@empty
@endforelse
										</select>
									</div>

									<div class="mb-3">
										<label for="media_title" class="form-label mb-0">Video Title</label>
										<input type="text" name="media_title" id="media_title" class="form-control" placeholder="Video Title" value="{{ !empty($current_media) ? $current_media->media_title : '' }}">
									</div>

									<div class="mb-3">
										<label for="media_description" class="form-label mb-0">Video description</label>
										<textarea name="media_description" id="media_description" class="form-control" placeholder="Video description">{{ !empty($current_media) ? $current_media->media_description : '' }}</textarea>
									</div>

									<div class="mb-3">
										<label for="source" class="form-label mb-0">Source (E.g. : YouTube, Vimeo, AWS)</label>
										<input type="text" name="source" id="source" class="form-control" placeholder="Source (E.g. : YouTube, Vimeo, AWS)" value="{{ !empty($current_media) ? $current_media->source : '' }}">
									</div>

									<div class="row g-2 mb-3">
										<div class="col-6">
											<label for="belonging_count" class="form-label mb-0">Contains how many medias?</label>
											<input type="number" name="belonging_count" id="belonging_count" class="form-control" placeholder="Contains how many medias?" value="{{ !empty($current_media) ? $current_media->belonging_count : '' }}">
										</div>
										<div class="col-6">
											<label for="time_length" class="form-label mb-0">Time length</label>
											<input type="time" name="time_length" id="time_length" class="form-control" placeholder="Time length" value="{{ !empty($current_media) ? $current_media->time_length : '' }}">
										</div>
									</div>

									<div class="mb-3">
										<label for="media_url" class="form-label mb-0">Video URL (YouTube or other)</label>
										<input type="text" name="media_url" id="media_url" class="form-control" placeholder="Video URL (YouTube or other)" value="{{ !empty($current_media) ? $current_media->media_url : '' }}">
									</div>

									<div class="mb-3">
										<label for="media_file_url" class="form-label mb-0">Upload video <i role="button" class="bi bi-question-circle" title="Upload the video" data-bs-toggle="tooltip"></i></label>
										<input type="file" name="media_file_url" id="media_file_url" class="form-control" />
									</div>

									<div class="mb-3">
										<label for="author_names" class="form-label mb-0">Author names</label>
										<input type="text" name="author_names" id="author_names" class="form-control" placeholder="Author names" value="{{ !empty($current_media) ? $current_media->author_names : '' }}">
									</div>

									<div class="mb-3">
										<label for="writer" class="form-label mb-0">Written by</label>
										<input type="text" name="writer" id="writer" class="form-control" placeholder="Written by" value="{{ !empty($current_media) ? $current_media->writer : '' }}">
									</div>

									<div class="mb-3">
										<label for="director" class="form-label mb-0">Film director</label>
										<input type="text" name="director" id="director" class="form-control" placeholder="Film director" value="{{ !empty($current_media) ? $current_media->director : '' }}">
									</div>

									<div class="mb-3">
										<label for="price" class="form-label mb-0">DVD price (in USD)</label>
										<input type="number" name="price" id="price" class="form-control" placeholder="DVD price (in USD)" value="{{ !empty($current_media) ? $current_media->price : '' }}">
									</div>

									<div class="mb-1 text-center">
										<label class="form-label mb-0 d-block">Is the media for children?</label>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="for_youth" id="for_youth_1" value="1"{{ !empty($current_media) && $current_media->for_youth == 1 ? ' checked' : '' }}>
											<label class="form-check-label" for="for_youth_1">Yes</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="for_youth" id="for_youth_0" value="0"{{ !empty($current_media) && $current_media->for_youth == 0 ? ' checked' : '' }}>
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
										<label for="belongs_to" class="form-label mb-0">Belongs to</label>
										<select name="belongs_to" id="belongs_to" class="form-select" aria-label="Choose a media">
											<option class="small" disabled{{ empty($current_media) || empty($current_media->belongs_to) ? ' selected' : '' }}>Choose a media</option>
@forelse ($belonging_medias as $media)
											<option value="{{ $media->id }}"{{ !empty($current_media) ? (!empty($current_media->belongs_to) && $current_media->belongs_to == $media->id ? ' selected' : '') : '' }}>{{ $media->media_title }}</option>
@empty
@endforelse
										</select>
									</div>

									<div class="mb-4 text-center">
										<label class="form-label mb-0 d-block">Is the media live?</label>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="is_live" id="is_live_1" value="1"{{ !empty($current_media) && $current_media->is_live == 1 ? ' checked' : '' }}>
											<label class="form-check-label" for="is_live_1">Yes</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="is_live" id="is_live_0" value="0"{{ !empty($current_media) && $current_media->is_live == 0 ? ' checked' : '' }}>
											<label class="form-check-label" for="is_live_0">No</label>
										</div>
									</div>

									<div class="mb-4 pt-2 p-3 border rounded-4 text-center">
										<label class="form-label mb-0 d-block">Check media categories</label>
										<hr class="mt-2 mb-3">
@forelse ($categories as $category)
										<div class="form-check form-check-inline">
											<input type="checkbox" name="categories_ids[]" id="category_{{ $category->id }}" class="form-check-input" value="{{ $category->id }}"{{ !empty($current_media) && inArrayR($category->id, $current_media->categories, 'id') ? ' checked' : '' }}>
											<label for="category_{{ $category->id }}" class="form-check-label">{{ $category->category_name }}</label>
										</div>
@empty
@endforelse
									</div>

									<div class="row g-2">
										<div class="col-sm-6">
											<button class="btn btn-primary w-100 mb-3 shadow-0">@lang('miscellaneous.send')</button>
										</div>
										<div class="col-sm-6">
											<button type="reset" class="btn btn-secondary w-100 mb-3 shadow-0">@lang('miscellaneous.reset')</button>
										</div>
									</div>

									<div class="d-flex justify-content-center mt-5 text-center request-message"></div>
								</form>
							</div>
						</div>
                    </div>
					<div class="col-lg-6">
						<div class="card border rounded-5 overflow-hidden shadow-0">
							<div class="card-header border-bottom border-default bg-light py-3">
								<h3 class="mb-0 text-center fw-bold">Medias list</h3>
							</div>

							<div class="list-group list-group-flush">
@forelse ($all_medias as $media)
								<a href="{{ request()->has('page') ? route(\Request::route()->getName(), ['entity' => $entity, 'id' => $media->id, 'page' => request()->get('page')]) : route(\Request::route()->getName(), ['entity' => $entity, 'id' => $media->id]) }}" class="list-group-item list-group-item-action{{ request()->has('id') && request()->get('id') == $media->id ? ' active' : '' }}">
									<h4 class="m-0"><i class="bi bi-play-btn-fill me-3 fs-4 dktv-text-pink" style="vertical-align: -2px;"></i>{{ $media->media_title }}</h4>
	@if (count($media->categories) > 0)
									<h5 class="mt-1 mb-0 text-end">
		@foreach ($media->categories as $category)
										<div class="badge bg-info fw-normal">{{ $category->category_name }}</div>
		@endforeach
									</h5>
	@endif
									
								</a>
@empty
								<span class="list-group-item list-group-item-action">The list is empty</span>
@endforelse
							</div>

							<div class="card-footer border-0 py-3">
@include('partials.pagination')
							</div>
						</div>
					</div>
                </div>
            </div>

