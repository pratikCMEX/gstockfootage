@if (isset($allVideos) && $allVideos->count() > 0)
    @foreach ($allVideos as $video)
        <div class="product-card">
            <a href="{{ route('product.detail', encrypt($video->id)) }}">
                <video class="product-img" width="100%" muted loop playsinline preload="auto"
                    poster="{{ !empty($video->thumbnail_path) ? Storage::disk('s3')->url($video->thumbnail_path) : asset('assets/admin/images/demo_thumbnail.png') }}">
                    <source
                        src="{{ $video->preview_path ? Storage::disk('s3')->url($video->preview_path) : ($video->mid_path ? Storage::disk('s3')->url($video->mid_path) : asset('assets/admin/images/demo_thumbnail.png')) }}"
                        type="video/mp4">
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
                    <button type="button" {{ isInCart($video->id) ? 'disabled' : '' }}
                        class="btn add_to_cart btn-orange" onclick="addToCart({{ $video->id }}, this)">
                        {{ isInCart($video->id) ? 'Added to Cart' : 'Add to Cart' }}
                    </button>
                </div>
                <div class="product-two-btn">
                    <button class="btn popular-icon-btn addFavorite" data-Product-id="{{ $video->id }}"
                        data-type="{{ $video->type }}">
                        <i class="bi {{ $video->is_favorite == 1 ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                        {{ $video->is_favorite == 1 ? 'Saved' : 'Save' }}
                    </button>
                    <div class="share-wrapper position-relative d-inline-block">
                        <button type="button" data-url="{{ route('product.detail', encrypt($video->id)) }}"
                            class="btn btn-all-dark btn-hover-dark share-trigger-btn">
                            <i class="bi bi-share"></i> Share
                        </button>
                    </div>
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
