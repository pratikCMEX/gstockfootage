<section class="py-4">
    <div class="container">

        {{-- Heading --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="heading">
                    <h2>
                        All Media
                        @if ($collection)
                            <span class="yellow-headings"> from {{ $collection->name }} Collection</span>
                        @endif
                    </h2>
                </div>
                <p class="text-muted">{{ $media->count() }} items &nbsp;·&nbsp;
                    {{ $photos->count() }} photos &nbsp;·&nbsp;
                    {{ $videos->count() }} videos
                </p>
            </div>
        </div>

        {{-- Tabs --}}
        <ul class="nav nav-pills all-media-tabs mb-4" id="mediaTabs">
            <li class="nav-item">
                <button class="nav-link active" data-tab="all">
                    All <span class="badge ms-1">{{ $media->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-tab="image">
                    Photos <span class="badge  ms-1">{{ $photos->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-tab="video">
                    Videos <span class="badge ms-1">{{ $videos->count() }}</span>
                </button>
            </li>
        </ul>

        {{-- Grid --}}
        <div class="row row-gap-4" id="mediaGrid">
            @forelse($media as $item)
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 media-item" data-type="{{ $item->type }}">
                    <div class="product-card">

                        {{-- Thumbnail --}}
                        <a href="{{ route('product.detail', encrypt($item->id)) }}">
                            @if ($item->type === 'video')
                                <video class="product-img" width="100%" muted loop playsinline preload="none"
                                    poster="{{ $item->thumbnail_path ? Storage::disk('s3')->url($item->thumbnail_path) : asset('assets/admin/images/demo_thumbnail.png') }}">
                                    <source
                                        src="{{ $item->preview_path ? Storage::disk('s3')->url($item->preview_path) : '' }}"
                                        type="video/mp4">
                                </video>
                            @else
                                <img loading="lazy"
                                    src="{{ $item->mid_path ? Storage::disk('s3')->url($item->mid_path) : asset('assets/admin/images/demo_thumbnail.png') }}"
                                    class="product-img" alt="{{ $item->title }}">
                            @endif
                        </a>

                        {{-- Type badge --}}
                        <span class="position-absolute imageVideo-badge top-0 start-0 m-2 badge"
                            style="background: {{ $item->type === 'video' ? '#ff6b00' : '#ff6b00' }}; font-size:10px;">
                            {{ $item->type === 'video' ? '▶ Video' : '🖼 Photo' }}
                        </span>

                        <div class="p-3">
                            @if ($item->category)
                                <span class="badge badge-custom mb-2">{{ $item->category->category_name }}</span>
                            @endif
                            <a href="{{ route('product.detail', encrypt($item->id)) }}">
                                <h6 class="popular-detail-title">{{ $item->title }}</h6>
                            </a>
                            <div class="price-btn">
                                <span class="price">${{ $item->price }}</span>
                                <button type="button" {{ isInCart($item->id) ? 'disabled' : '' }}
                                    class="btn add_to_cart btn-orange" onclick="addToCart({{ $item->id }}, this)">
                                    {{ isInCart($item->id) ? 'Added to Cart' : 'Add to Cart' }}
                                </button>
                            </div>
                            <div class="product-two-btn">
                                <button class="btn popular-icon-btn addFavorite" data-Product-id="{{ $item->id }}"
                                    data-type="{{ $item->type }}">
                                    <i class="bi {{ $item->is_favorite == 1 ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                    {{ $item->is_favorite == 1 ? 'Saved' : 'Save' }}
                                </button>
                                <div class="share-wrapper position-relative d-inline-block">
                                    <div class="share-wrapper position-relative d-inline-block">
                                        <button type="button"
                                            data-url="{{ route('product.detail', encrypt($item->id)) }}"
                                            class="btn btn-all-dark btn-hover-dark share-trigger-btn">
                                            <i class="bi bi-share"></i> Share
                                        </button>

                                        <div class="share-dropdown" id="shareDropdown">
                                            <div class="share-dropdown-title">Share this page</div>

                                            <!-- WhatsApp -->
                                            <a class="share-option" id="shareWhatsapp" href="#" target="_blank">
                                                <span class="share-icon whatsapp-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="18" viewBox="0 0 24 24" fill="currentColor">
                                                        <path
                                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                                                        <path
                                                            d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.855L.057 23.224a.75.75 0 0 0 .92.92l5.421-1.461A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.907 0-3.694-.5-5.24-1.377l-.374-.214-3.878 1.046 1.067-3.768-.234-.388A9.96 9.96 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                                                    </svg>
                                                </span>
                                                <span>WhatsApp</span>
                                            </a>

                                            <!-- X (Twitter) -->
                                            <a class="share-option" id="shareX" href="#" target="_blank">
                                                <span class="share-icon x-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" viewBox="0 0 24 24" fill="currentColor">
                                                        <path
                                                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.747l7.73-8.835L1.254 2.25H8.08l4.253 5.622L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z" />
                                                    </svg>
                                                </span>
                                                <span>X (Twitter)</span>
                                            </a>

                                            <!-- Instagram -->
                                            <a class="share-option" id="shareInstagram" href="#" target="_blank">
                                                <span class="share-icon instagram-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="18" viewBox="0 0 24 24" fill="currentColor">
                                                        <path
                                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z" />
                                                    </svg>
                                                </span>
                                                <span>Instagram</span>
                                            </a>

                                            <!-- Facebook -->
                                            <a class="share-option" id="shareFacebook" href="#" target="_blank">
                                                <span class="share-icon facebook-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="18" viewBox="0 0 24 24" fill="currentColor">
                                                        <path
                                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                                    </svg>
                                                </span>
                                                <span>Facebook</span>
                                            </a>

                                            <div class="share-divider"></div>

                                            <!-- Copy Link -->
                                            <button class="share-option copy-link-btn" id="copyLinkBtn">
                                                <span class="share-icon copy-icon">
                                                    <i class="bi bi-link-45deg" style="font-size:18px;"></i>
                                                </span>
                                                <span id="copyLinkText">Copy Link</span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="share-dropdown" id="shareDropdown">
                                        <div class="share-dropdown-title">Share this page</div>

                                        <!-- WhatsApp -->
                                        <a class="share-option" id="shareWhatsapp" href="#" target="_blank">
                                            <span class="share-icon whatsapp-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="currentColor">
                                                    <path
                                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                                                    <path
                                                        d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.855L.057 23.224a.75.75 0 0 0 .92.92l5.421-1.461A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.907 0-3.694-.5-5.24-1.377l-.374-.214-3.878 1.046 1.067-3.768-.234-.388A9.96 9.96 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                                                </svg>
                                            </span>
                                            <span>WhatsApp</span>
                                        </a>

                                        <!-- X (Twitter) -->
                                        <a class="share-option" id="shareX" href="#" target="_blank">
                                            <span class="share-icon x-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="currentColor">
                                                    <path
                                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.747l7.73-8.835L1.254 2.25H8.08l4.253 5.622L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z" />
                                                </svg>
                                            </span>
                                            <span>X (Twitter)</span>
                                        </a>

                                        <!-- Instagram -->
                                        <a class="share-option" id="shareInstagram" href="#" target="_blank">
                                            <span class="share-icon instagram-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="currentColor">
                                                    <path
                                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z" />
                                                </svg>
                                            </span>
                                            <span>Instagram</span>
                                        </a>

                                        <!-- Facebook -->
                                        <a class="share-option" id="shareFacebook" href="#" target="_blank">
                                            <span class="share-icon facebook-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="currentColor">
                                                    <path
                                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                                </svg>
                                            </span>
                                            <span>Facebook</span>
                                        </a>

                                        <div class="share-divider"></div>

                                        <!-- Copy Link -->
                                        <button class="share-option copy-link-btn" id="copyLinkBtn">
                                            <span class="share-icon copy-icon">
                                                <i class="bi bi-link-45deg" style="font-size:18px;"></i>
                                            </span>
                                            <span id="copyLinkText">Copy Link</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info">
                        <h4>No Media Available</h4>
                        <p>There are currently no items in this collection.</p>
                    </div>
                </div>
            @endforelse

        </div>
    </div>
</section>

<script>
    // Tab filter
    document.querySelectorAll('#mediaTabs .nav-link').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('#mediaTabs .nav-link').forEach(b => b.classList.remove(
                'active'));
            this.classList.add('active');

            var tab = this.dataset.tab;
            document.querySelectorAll('.media-item').forEach(function(item) {
                if (tab === 'all' || item.dataset.type === tab) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Video hover play
    document.querySelectorAll('.product-card video').forEach(function(video) {
        video.addEventListener('mouseenter', function() {
            this.play();
        });
        video.addEventListener('mouseleave', function() {
            this.pause();
            this.currentTime = 0;
        });
    });
</script>
