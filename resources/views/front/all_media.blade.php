<section class="py-4">
    <div class="container">

        {{-- Heading --}}
        <div class="row mb-4">
            <div class="col-12">
                <h2>
                    All Media
                    @if ($collection)
                        <span class="yellow-headings"> from {{ $collection->name }} Collection</span>
                    @endif
                </h2>
                <p class="text-muted">{{ $media->count() }} items &nbsp;·&nbsp;
                    {{ $photos->count() }} photos &nbsp;·&nbsp;
                    {{ $videos->count() }} videos
                </p>
            </div>
        </div>

        {{-- Tabs --}}
        <ul class="nav nav-pills mb-4" id="mediaTabs">
            <li class="nav-item">
                <button class="nav-link active" data-tab="all">
                    All <span class="badge bg-secondary ms-1">{{ $media->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-tab="image">
                    Photos <span class="badge bg-secondary ms-1">{{ $photos->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-tab="video">
                    Videos <span class="badge bg-secondary ms-1">{{ $videos->count() }}</span>
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
                        <span class="position-absolute top-0 start-0 m-2 badge"
                            style="background: {{ $item->type === 'video' ? '#ff6b00' : '#0d6efd' }}; font-size:10px;">
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
                                <button class="btn popular-icon-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                        <path
                                            d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3" />
                                    </svg>
                                    Share
                                </button>
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
