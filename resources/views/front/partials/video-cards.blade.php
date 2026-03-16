{{--
    FILE: resources/views/front/partials/video-cards.blade.php
    Used by:
      1. @include('front.partials.video-cards', ['allVideos' => $allVideos])  — initial page load
      2. Controller AJAX response:  view('front.partials.video-cards', compact('allVideos'))->render()
--}}

@if (isset($allVideos) && $allVideos->count() > 0)

    @foreach ($allVideos as $video)
        <div class="product-card">

            <a href="{{ route('product.detail', encrypt($video->id)) }}">
                <video class="product-img" width="100%" preload="none"
                    poster="{{ !empty($video->thumbnail_path) ? Storage::disk('s3')->url($video->thumbnail_path) : asset('assets/admin/images/demo_thumbnail.png') }}"
                    onmouseenter="this.play()" onmouseleave="this.pause(); this.currentTime=0;">
                    <source src="{{ Storage::disk('s3')->url($video->file_path) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </a>

            <div class="p-3">

                <span class="badge badge-custom mb-2">
                    {{ optional($video->category)->category_name ?? 'Uncategorized' }}
                </span>

                <a href="{{ route('product.detail', encrypt($video->id)) }}">
                    <h6 class="popular-detail-title">{{ $video->title }}</h6>
                </a>

                <div class="price-btn">
                    <span class="price">${{ $video->price }}</span>
                    <a href="{{ route('product.detail', encrypt($video->id)) }}" class="btn btn-orange">Add</a>
                </div>

                <div class="product-two-btn">
                    <button class="btn popular-icon-btn addFavorite" data-Product-id="{{ $video->id }}"
                        data-type="{{ $video->type }}">
                        <i class="bi {{ $video->is_favorite == 1 ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                        {{ $video->is_favorite == 1 ? 'Saved' : 'Save' }}
                    </button>
                    <button class="btn popular-icon-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-share" viewBox="0 0 16 16">
                            <path
                                d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3" />
                        </svg>
                        Share
                    </button>
                </div>

            </div>
        </div>
    @endforeach
@else
    <div style="grid-column: 1 / -1; width: 100%;">
        <div class="col-12 text-center py-5">
            <div class="alert alert-info">
                <h4 class="alert-heading">No Videos Available</h4>
                <p>No videos match your current filters. Try adjusting or clearing your filters.</p>
                <hr>
                <button class="btn btn-outline-warning btn-sm" id="noResultsClearBtn">
                    <i class="fa-solid fa-xmark me-1"></i> Clear All Filters
                </button>
            </div>
        </div>
    </div>

@endif
