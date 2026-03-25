<style>

</style>
<section class="hero">
    <div class="container">
        <h1>Visuals with purpose.</h1>
        <!-- Tabs -->
        <div class="hero-tabs">
            <a href="{{ route('videos') }}" class="active"><i class="bi bi-camera-video"></i> Videos</a>
            <a href="{{ route('all_photos') }}"><i class="bi bi-image"></i> Photos</a>
            {{-- <button><i class="bi bi-palette"></i> Artwork</button> --}}
        </div>
        <!-- Search -->
        <div class="search-wrapper">
            <div class="search-box shadow-lg">

                <!-- Dropdown -->
                <div class="dropdown">
                    <button class="btn dropdown-toggle custom-dropdown" data-bs-toggle="dropdown" id="dropdownBtn">
                        <i class="bi bi-grid btn-icon"></i>
                        <span class="btn-text">All content</span>
                    </button>

                    <ul class="dropdown-menu custom-menu content-list-menu">
                        <li>
                            <a class="dropdown-item" href="#" data-type="all" data-icon="bi bi-grid"
                                data-label="All content">
                                <i class="bi bi-grid"></i> <span>All content</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-type="video" data-icon="bi bi-camera-video"
                                data-label="Videos">
                                <i class="bi bi-camera-video"></i> <span>Videos</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-type="image" data-icon="bi bi-image"
                                data-label="Photos">
                                <i class="bi bi-image"></i> <span>Photos</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="inp-search">
                    <!-- Input -->
                    <input type="text" class="home_search" placeholder="Search for photos, videos and more..." />

                    <!-- Search Button -->
                    <button class="search-btn">
                        <i class="bi bi-search"></i>
                    </button>
                    <div class="suggetion-search">
                        <ul>

                        </ul>
                    </div>
                </div>

            </div>

            <!-- Image Search -->

            <button type="button" class="btn image-search-btn shadow" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                <i class="bi bi-camera"></i>
                Search by image
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title fs-5" id="exampleModalLabel">Search by Image</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <form action="{{ route('photos.searchByImage') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body search-image-body" id="imageDropZone">

                                {{-- Error --}}
                                @error('image')
                                    <div class="alert alert-danger w-100 mb-3">{{ $message }}</div>
                                @enderror

                                {{-- Hidden file input --}}
                                <input type="file" name="image" id="search-image" accept="image/*" hidden>

                                {{-- Preview --}}
                                <img id="imagePreview" src="" alt="Preview"
                                    style="display:none; max-height:180px; border-radius:8px; margin-bottom:12px; object-fit:cover;">

                                {{-- Upload icon --}}
                                <svg id="uploadIcon" xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" x2="12" y1="3" y2="15"></line>
                                </svg>

                                <label for="search-image" id="uploadLabel" style="cursor:pointer; margin-top:10px;">
                                    Click to upload an image or drag and drop
                                </label>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-hover-dark btn-all-dark cancel-btn"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="btn" class="btn btn-orange" id="searchByImageBtn" disabled>
                                    Search
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>



        <!-- Trending -->
        @if (!empty($trendingTags))
            <div class="trending">
                Trending:
                @foreach ($trendingTags as $tags)
                    <a
                        href="{{ $tags['type'] === 'image' ? route('all_photos', ['q' => $tags['tag'], 'type' => $tags['type']]) : route('videos', ['q' => $tags['tag'], 'type' => $tags['type']]) }}">{{ $tags['tag'] }}</a>
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
            </div>
        @endif

    </div>
</section>
<section class="endless-posibilities">
    <div class="container">
        <div class="row g-3">
            <div class="col-12">
                <div class="posibility-heading heading">
                    <h2>One Brand <span class="yellow-headings">Endless Possibilities.</span></h2>
                </div>
            </div>
            @foreach ($CollectionList as $item)
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('all_photos', ['collection_id' => encrypt($item->id)]) }}"
                        class="text-decoration-none">
                        <div class="brand-posibility">
                            <div class="posibility-img">
                                <img loading="lazy" width="100%" height="100%"
                                    src="{{ asset('uploads/images/collection/' . $item->image) }}" alt="">
                            </div>
                            <div class="posibilty-title">
                                <h3>{{ $item->name }}</h3>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
<section class="create-fingertips">
    <div class="container">
        <div class="row g-4 d-flex align-items-center mb-4">
            <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-xs-6 col-12">
                <div class="fingertips-heading heading ">
                    <h2 class="m-0">
                        Content at <span class="yellow-headings"> Your Fingertips</span>
                    </h2>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-6 col-12 text-sm-end text-start">
                <div class="heading-btn">
                    <a href="{{ route('pricing') }}" class="btn btn-orange">
                        See Pricing
                    </a>
                </div>
            </div>
        </div>
        <div class="row g-3">
            @if ($categoryList->isNotEmpty())
                @foreach ($categoryList as $category)
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                        <a href="{{ route('all_photos', ['category_id' => encrypt($category->id)]) }}"
                            class="text-decoration-none">
                            <div class="fingertips-content">
                                <div class="fingertips-img">
                                    <img loading="lazy" height="100%" width="100%"
                                        src="{{ asset('uploads/images/category/' . $category->category_image) }}"
                                        alt="">
                                </div>
                                <h4>{{ $category->category_name }} <i class="bi bi-arrow-right"></i></h4>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
<section class="popular_content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="heading mb-md-5">
                    <h2>Explore Popular and Curated <span class="yellow-headings"> Visual Content </span>
                    </h2>
                </div>
            </div>
            <div class="popular_tabs">
                <ul class="nav custom-tabs mb-3">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#selected">
                            Latest content
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#popular">
                            The most popular
                        </button>
                    </li>
                </ul>

                <!-- Filter Buttons -->
                @if (!empty($trendingTags))
                    <div class="popular-filter-pills filter-pills d-flex flex-wrap gap-2 mb-4">
                        @foreach ($trendingTags as $tags)
                            <a href="{{ $tags['type'] === 'image'
                                ? route('all_photos', ['q' => $tags['tag'], 'type' => $tags['type']])
                                : route('videos', ['q' => $tags['tag'], 'type' => $tags['type']]) }}"
                                class="btn btn-sm"><i class="bi bi-search"></i> {{ $tags['tag'] }}</a>
                        @endforeach
                        <!-- <a href="{{ route('all_photos', ['q' => 'Aerial footage', 'type' => 'image']) }}"
                                                class="btn btn-sm"><i class="bi bi-search"></i> Aerial footage</a>
                                            <a href="{{ route('all_photos', ['q' => 'Golden hour', 'type' => 'image']) }}" class="btn btn-sm"><i
                                                    class="bi bi-search"></i> Golden hour</a>
                                            <a href="{{ route('all_photos', ['q' => 'Ancient sites', 'type' => 'image']) }}"
                                                class="btn btn-sm"><i class="bi bi-search"></i> Ancient sites</a>
                                            <a href="{{ route('all_photos', ['q' => 'Holy Land nature', 'type' => 'image']) }}"
                                                class="btn btn-sm"><i class="bi bi-search"></i> Holy Land nature</a>
                                            <a href="{{ route('all_photos', ['q' => 'Biblical locations', 'type' => 'image']) }}"
                                                class="btn btn-sm"><i class="bi bi-search"></i> Biblical locations</a>
                                            <a href="{{ route('all_photos', ['q' => 'Desert landscapes', 'type' => 'image']) }}"
                                                class="btn btn-sm"><i class="bi bi-search"></i> Desert landscapes</a> -->
                    </div>
                @endif

                <!-- Tab Content -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="selected">
                        @if ($latestProducts->isNotEmpty())
                            <div class="row g-3">

                                @foreach ($latestProducts as $pro)
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="product-card">
                                            <a href="{{ route('product.detail', encrypt($pro->id)) }}">

                                                @if ($pro->type == 'image')
                                                    <img loading="lazy"
                                                        src="{{ $pro->mid_path ? Storage::disk('s3')->url($pro->mid_path) : Storage::disk('s3')->url($pro->file_path) }}"
                                                        class="product-img" alt="">
                                                @else
                                                    @if ($pro->thumbnail_path == null)
                                                        <img loading="lazy"
                                                            src="{{ asset('assets/admin/images/demo_thumbnail.png') }}"
                                                            class="product-img" alt="">
                                                    @else
                                                        <img loading="lazy"
                                                            src="{{ Storage::disk('s3')->url($pro->thumbnail_path) }}"
                                                            class="product-img" alt="">
                                                    @endif
                                                @endif
                                            </a>
                                            <div class="p-3">

                                                <span
                                                    class="badge badge-custom mb-2">{{ $pro->category->category_name ?? '' }}</span>

                                                <h6 class="popular-detail-title">{{ $pro->title }}
                                                </h6>


                                                <div class="price-btn">
                                                    <span class="price">${{ $pro->price }}</span>
                                                    <button class="btn add_to_cart btn-orange"
                                                        {{ isInCart($pro->id) ? 'disabled' : '' }}
                                                        onclick="addToCart({{ $pro->id }}, this)">
                                                        {{ isInCart($pro->id) ? 'Added to Cart' : 'Add to Cart' }}</button>
                                                </div>
                                                <div class="product-two-btn">
                                                    <button type="button" data-Product-id="{{ $pro->id }}"
                                                        data-type="{{ $pro->type }}"
                                                        class="btn  popular-icon-btn addFavorite">
                                                        <i
                                                            class="bi {{ $pro->is_favorite == 1 ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                                        {{ $pro->is_favorite == 1 ? 'Saved' : 'Save' }} </button>


                                                    <div class="share-wrapper position-relative d-inline-block">
                                                        <button type="button"
                                                            data-url="{{ route('product.detail', encrypt($pro->id)) }}"
                                                            class="btn btn-all-dark btn-hover-dark share-trigger-btn">
                                                            <i class="bi bi-share"></i> Share
                                                        </button>

                                                        <div class="share-dropdown" id="shareDropdown">
                                                            <div class="share-dropdown-title">Share this page</div>

                                                            <!-- WhatsApp -->
                                                            <a class="share-option" id="shareWhatsapp" href="#"
                                                                target="_blank">
                                                                <span class="share-icon whatsapp-icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="18" height="18"
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
                                                            <a class="share-option" id="shareX" href="#"
                                                                target="_blank">
                                                                <span class="share-icon x-icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        viewBox="0 0 24 24" fill="currentColor">
                                                                        <path
                                                                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.747l7.73-8.835L1.254 2.25H8.08l4.253 5.622L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z" />
                                                                    </svg>
                                                                </span>
                                                                <span>X (Twitter)</span>
                                                            </a>

                                                            <!-- Instagram -->
                                                            <a class="share-option" id="shareInstagram"
                                                                href="#" target="_blank">
                                                                <span class="share-icon instagram-icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="18" height="18"
                                                                        viewBox="0 0 24 24" fill="currentColor">
                                                                        <path
                                                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z" />
                                                                    </svg>
                                                                </span>
                                                                <span>Instagram</span>
                                                            </a>

                                                            <!-- Facebook -->
                                                            <a class="share-option" id="shareFacebook" href="#"
                                                                target="_blank">
                                                                <span class="share-icon facebook-icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="18" height="18"
                                                                        viewBox="0 0 24 24" fill="currentColor">
                                                                        <path
                                                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                                                    </svg>
                                                                </span>
                                                                <span>Facebook</span>
                                                            </a>

                                                            <div class="share-divider"></div>

                                                            <!-- Copy Link -->
                                                            <button class="share-option copy-link-btn"
                                                                data-copy-url="{{ route('product.detail', encrypt($pro->id)) }}"
                                                                id="copyLinkBtn">
                                                                <span class="share-icon copy-icon">
                                                                    <i class="bi bi-link-45deg"
                                                                        style="font-size:18px;"></i>
                                                                </span>
                                                                <span id="copyLinkText">Copy Link</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                @endforeach

                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="popular">
                    <div class="row g-3">
                        @if ($popularProducts->isNotEmpty())
                            @foreach ($popularProducts as $pro)
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <a href="{{ route('product.detail', encrypt($pro->id)) }}">
                                        <div class="product-card">
                                            @if ($pro->type == 'image')
                                                <img loading="lazy"
                                                    src="{{ $pro->mid_path ? Storage::disk('s3')->url($pro->mid_path) : Storage::disk('s3')->url($pro->file_path) }}"
                                                    class="product-img" alt="">
                                            @else
                                                @if ($pro->thumbnail_path == null)
                                                    <img loading="lazy"
                                                        src="{{ asset('assets/admin/images/demo_thumbnail.png') }}"
                                                        class="product-img" alt="">
                                                @else
                                                    <img loading="lazy"
                                                        src="{{ Storage::disk('s3')->url($pro->thumbnail_path) }}"
                                                        class="product-img" alt="">
                                                @endif
                                            @endif
                                    </a>
                                    <div class="p-3">

                                        <span
                                            class="badge badge-custom mb-2">{{ $pro->category->category_name ?? '' }}</span>

                                        <h6 class="popular-detail-title">{{ $pro->title }}
                                        </h6>


                                        <div class="price-btn">
                                            <span class="price">${{ $pro->price }}</span>
                                            {{-- <button class="btn  btn-orange">Add</button> --}}
                                            <button class="btn add_to_cart btn-orange"
                                                {{ isInCart($pro->id) ? 'disabled' : '' }}
                                                onclick="addToCart({{ $pro->id }}, this)">
                                                {{ isInCart($pro->id) ? 'Added to Cart' : 'Add to Cart' }}</button>

                                        </div>
                                        <div class="product-two-btn">
                                            <button type="button" data-Product-id="{{ $pro->id }}"
                                                data-type="{{ $pro->type }}"
                                                class="btn  popular-icon-btn addFavorite">
                                                <i
                                                    class="bi {{ $pro->is_favorite == 1 ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                                {{ $pro->is_favorite == 1 ? 'Saved' : 'Save' }} </button>


                                            <div class="share-wrapper position-relative d-inline-block">
                                                <button type="button"
                                                    data-url="{{ route('product.detail', encrypt($pro->id)) }}"
                                                    class="btn btn-all-dark btn-hover-dark share-trigger-btn">
                                                    <i class="bi bi-share"></i> Share
                                                </button>

                                                <div class="share-dropdown" id="shareDropdown">
                                                    <div class="share-dropdown-title">Share this page</div>

                                                    <!-- WhatsApp -->
                                                    <a class="share-option" id="shareWhatsapp" href="#"
                                                        target="_blank">
                                                        <span class="share-icon whatsapp-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 24 24"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                                                                <path
                                                                    d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.855L.057 23.224a.75.75 0 0 0 .92.92l5.421-1.461A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.907 0-3.694-.5-5.24-1.377l-.374-.214-3.878 1.046 1.067-3.768-.234-.388A9.96 9.96 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                                                            </svg>
                                                        </span>
                                                        <span>WhatsApp</span>
                                                    </a>

                                                    <!-- X (Twitter) -->
                                                    <a class="share-option" id="shareX" href="#"
                                                        target="_blank">
                                                        <span class="share-icon x-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" viewBox="0 0 24 24"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.747l7.73-8.835L1.254 2.25H8.08l4.253 5.622L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z" />
                                                            </svg>
                                                        </span>
                                                        <span>X (Twitter)</span>
                                                    </a>

                                                    <!-- Instagram -->
                                                    <a class="share-option" id="shareInstagram" href="#"
                                                        target="_blank">
                                                        <span class="share-icon instagram-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 24 24"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z" />
                                                            </svg>
                                                        </span>
                                                        <span>Instagram</span>
                                                    </a>

                                                    <!-- Facebook -->
                                                    <a class="share-option" id="shareFacebook" href="#"
                                                        target="_blank">
                                                        <span class="share-icon facebook-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 24 24"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                                            </svg>
                                                        </span>
                                                        <span>Facebook</span>
                                                    </a>

                                                    <div class="share-divider"></div>

                                                    <!-- Copy Link -->
                                                    <button class="share-option copy-link-btn"
                                                        data-copy-url="{{ route('product.detail', encrypt($pro->id)) }}"
                                                        id="copyLinkBtn">
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
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 text-center">
        <a href="{{ route('all_photos') }}" class="brows-btn">Browse all content <svg
                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-chevron-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
            </svg></a>
    </div>
    </div>
    </div>
</section>
<section class="help_section hero-wrapper d-flex align-items-center justify-content-center">
    <div class="container text-center">
        <div class="brand-area mb-4">
            <img loading="lazy" src="{{ asset('assets/front/img/helper-chicken-D5n0gnPB.png') }}" alt="Mascot"
                class="floating-icon">
            <h2 class="help-heading">How can we help you <span class="text-gradient">get what you want?</span></h2>
        </div>

        <div class="help-filter-btn filter-pills d-flex justify-content-center flex-wrap gap-2 mb-4">
            <button class="btn btn-filter search-btn-filter active" data-type="all"><i class="bi bi-grid-fill"></i>
                All</button>
            <button class="btn btn-filter search-btn-filter" data-type="video"><i class="bi bi-camera-video"></i>
                Videos</button>
            <button class="btn btn-filter search-btn-filter" data-type="image"><i class="bi bi-camera"></i>
                Photos</button>
            {{-- <button class="btn btn-filter search-btn-filter" data-type="artwork"><i class="bi bi-palette"></i>
                Artwork</button> --}}
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="search-container shadow-lg">
                    <input type="text" class="form-control main-input help-search"
                        placeholder="Search for videos, photos,see more...">
                    <button class="btn btn-search help-search-btn">
                        <i class="bi bi-search"></i> <span>Search</span>
                    </button>
                    <div class="suggetion-search">
                        <ul></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="store_slider-section">
    <div class="container">
        <div class="store-section">

            <div class="store-header">
                <div class="store-title heading">
                    <i class="bi bi-book"></i>
                    <h2 class="mb-0"> Visit Our Vision of The <span class="yellow-headings">Bible Store
                        </span>
                    </h2>
                </div>

                <div class="store-actions">
                    <a href="https://visionofthebiblestore.com/collections/all" target="_blank">Shop the Collection <i
                            class="bi bi-box-arrow-up-right"></i></a>
                </div>
            </div>

            <div class="swiper mySwiper store-swiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <a href="https://visionofthebiblestore.com/products/kids-bible-stories%E2%84%A2-digital-tablet"
                            target="_blank">
                            <div class="store-product-card">
                                <div class="store-product-image">
                                    <img loading="lazy"
                                        src="https://visionofthebiblestore.com/cdn/shop/files/P1-copy-2.jpg?v=1765506820&width=1400">
                                </div>
                                <h4 class="store-product-title">Kids Bible Stories™ Digital Tablet</h4>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="https://visionofthebiblestore.com/products/tanakh-digital-visual-bible"
                            target="_blank">
                            <div class="store-product-card">
                                <div class="store-product-image">
                                    <img loading="lazy"
                                        src="https://visionofthebiblestore.com/cdn/shop/files/tanakh.png?v=1732480951&width=1400">
                                </div>
                                <h4 class="store-product-title">Tanakh - Digital Visual Bible</h4>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="https://visionofthebiblestore.com/products/travel-to-the-holy-land" target="_blank">
                            <div class="store-product-card">
                                <div class="store-product-image">
                                    <img loading="lazy"
                                        src="https://visionofthebiblestore.com/cdn/shop/files/travel.png?v=1732481053&width=1400">
                                </div>
                                <h4 class="store-product-title">The Holy Land Digital Tablet</h4>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="https://visionofthebiblestore.com/products/vision-of-israel-coffee-table-book-1"
                            target="_blank">
                            <div class="store-product-card">
                                <div class="store-product-image">
                                    <img loading="lazy"
                                        src="https://visionofthebiblestore.com/cdn/shop/files/book_1.png?v=1733282144&width=1400">
                                </div>
                                <h4 class="store-product-title">Visions of Israel - Coffee Table Book</h4>
                            </div>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://visionofthebiblestore.com/products/digital-bible-the-four-gospels"
                            target="_blank">
                            <div class="store-product-card">
                                <div class="store-product-image">
                                    <img loading="lazy"
                                        src="https://visionofthebiblestore.com/cdn/shop/files/digital-bible-2-_2.png?v=1757971890&width=1400">
                                </div>
                                <h4 class="store-product-title">The Four Gospels (10 Inch)</h4>
                            </div>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://visionofthebiblestore.com/products/digital-bible-the-four-gospels"
                            target="_blank">
                            <div class="store-product-card">
                                <div class="store-product-image">
                                    <img loading="lazy"
                                        src="https://visionofthebiblestore.com/cdn/shop/files/digital-bible-2-_2.png?v=1757971890&width=1400">
                                </div>
                                <h4 class="store-product-title">The Four Gospels (10 Inch)</h4>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="https://visionofthebiblestore.com/collections/all" target="_blank">
                            <div class="view-all-card">
                                <i class="bi bi-box-arrow-up-right"></i>
                                <div>View All Products</div>
                            </div>
                        </a>

                    </div>


                </div>

                <div class="arrow-left arrow"><i class="bi bi-chevron-left"></i></div>
                <div class="arrow-right arrow"><i class="bi bi-chevron-right"></i></div>

            </div>

        </div>
    </div>
</section>

<section class="enterprise-section">
    <div class="container">

        <div class="enterprise-badge">
            Enterprise Solutions
        </div>

        <h2 class="enterprise-title">
            Built for Studios & Production Companies
        </h2>

        <p class="enterprise-subtitle">
            Access our complete media library with custom licensing, bulk downloads, and dedicated support for
            your production needs
        </p>

        <div class="enterprise-card">
            <div class="row g-3 align-items-center">

                <div class="col-xl-6 col-lg-12 text-start">
                    <h5>Trusted by Major Studios & Networks</h5>
                    <p>
                        Join leading production teams who rely on our curated footage.
                        Receive a full catalog export within 24 hours for fast decision-making.
                    </p>
                </div>

                <div class="col-xl-6 col-lg-12   enterprise-actions">
                    <div class="enterprise-btns">
                        <a href="{{ route('enterprise') }}" class="btn  btn-orange ">
                            Request Enterprise Quote <i class="bi bi-arrow-right"></i>
                        </a>
                        {{-- <a href="#" class="btn btn-outline-custom-enterprise btn-all-dark">
                            Learn More
                        </a> --}}
                    </div>
                </div>

            </div>
        </div>

        <div class="enterprise-footnote">
            Perfect for documentaries, TV productions, commercials, and cinematic projects.
        </div>

    </div>
</section>
<section class="trusted-section">

    <div class="container ">
        <div class="row g-4 align-items-center">

            @if (!empty($content_master))
                <div class="col-lg-5">
                    <div class="heading">
                        <h2 class="section-title ">
                            <span class="yellow-headings">{{ $content_master->title }}</span>
                        </h2>
                    </div>

                    <p class="trusted-subtitle">
                        {{ $content_master->sub_title }}
                    </p>

                    @foreach ($content_master->content as $section)
                        <div class="feature-item">
                            <div class="feature-icon">
                                @if ($section['image'])
                                    <img src="{{ asset('uploads/images/content_master/' . $section['image']) }}"
                                        height="24" width="24">
                                @else
                                    <svg style="fill:white" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                                        <path
                                            d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-105.4 105.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h6>{{ $section['title'] }}</h6>
                                <p>{{ $section['sub_title'] }}</p>
                            </div>
                        </div>
                    @endforeach


                    <!-- <div class="feature-item">
                                                        <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="lucide lucide-shield h-5 w-5 text-primary">
                                                                <path
                                                                    d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                                                </path>
                                                            </svg></div>
                                                        <div>
                                                            <h6>Royalty-Free Licensing</h6>
                                                            <p>Clear & flexible licensing for any project</p>
                                                        </div>
                                                    </div>

                                                    <div class="feature-item">
                                                        <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="lucide lucide-download h-5 w-5 text-primary">
                                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                                <line x1="12" x2="12" y1="15" y2="3"></line>
                                                            </svg></div>
                                                        <div>
                                                            <h6>Instant Downloads</h6>
                                                            <p>Get your files immediately after purchase</p>
                                                        </div>
                                                    </div>

                                                    <div class="feature-item">
                                                        <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="lucide lucide-clock h-5 w-5 text-primary">
                                                                <circle cx="12" cy="12" r="10"></circle>
                                                                <polyline points="12 6 12 12 16 14"></polyline>
                                                            </svg></div>
                                                        <div>
                                                            <h6>Authentic Locations</h6>
                                                            <p>Real footage from iconic destinations</p>
                                                        </div>
                                                    </div> -->

                    <div class="mt-4 trusted-btn">
                        <a href="{{ route('pricing') }}" class="btn btn-orange me-lg-2">
                            View Licensing Options
                        </a>
                        <a href="{{ route('contact') }}" class="btn trusted-contact-btn btn-hover-dark btn-all-dark">
                            Contact Us
                        </a>
                    </div>
            @endif
        </div>

        <div class="col-lg-7">
            @if ($testimonials->isNotEmpty())
                @foreach ($testimonials as $testimonial)
                    <div class="testimonial-card">
                        <div class="quote-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-quote h-8 w-8 text-primary/30 ">
                                <path
                                    d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                                </path>
                                <path
                                    d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                                </path>
                            </svg></div>
                        <div class="testimonial-text">
                            {{ $testimonial->message }}
                        </div>
                        @php
                            $name = trim($testimonial->name);
                            $words = explode(' ', $name);

                            $initials = '';

                            if (count($words) >= 2) {
                                $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                            } else {
                                $initials = strtoupper(substr($name, 0, 1));
                            }

                        @endphp
                        <div class="testimonial-user">
                            <div class="avatar">
                                @if (
                                    !empty($testimonial->profile_image) &&
                                        file_exists(public_path('uploads/images/testimonials/' . $testimonial->profile_image)))
                                    <img class='avatar'
                                        src="{{ asset('uploads/images/testimonials/' . $testimonial->profile_image) }}"
                                        alt="{{ $testimonial->name }}">
                                @else
                                    {{ $initials }}
                                @endif
                            </div>
                            <div class="user-info">
                                <strong>{{ $testimonial->name }}</strong>
                                <small>{{ $testimonial->designation }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- <div class="testimonial-card">
                    <div class="quote-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-quote h-8 w-8 text-primary/30 ">
                            <path
                                d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                            </path>
                            <path
                                d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                            </path>
                        </svg></div>
                    <div class="testimonial-text">
                        Incredible selection of Holy Land footage. Exactly what we needed for our production.
                    </div>

                    <div class="testimonial-user">
                        <div class="avatar">D</div>
                        <div class="user-info">
                            <strong>David K.</strong>
                            <small>Creative Director</small>
                        </div>
                    </div>
                </div> -->

    </div>
    </div>

    </div>
    </div>
</section>

<section class="blog">
    <div class="container">
        @if ($blogs->isNotEmpty())
            <div class="row g-3">
                <div class="col-12">
                    <div class="blog-header">
                        <div class="heading ">
                            <h2 class="m-0">Latest stories</h2>
                        </div>
                        <a href="{{ route('blog') }}" class="btn btn-orange">View all</a>
                    </div>
                </div>
                @foreach ($blogs as $blog)
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="blog-card">
                            <div class="blog-img">
                                <img src="{{ asset('uploads/images/blogs/' . $blog->image) }}" height="100%"
                                    width="100%" alt="">
                                @isset($blog->author_tag)
                                    <span class="popular-badge listing-badge blog-badge">{{ $blog->author_tag }}</span>
                                @endisset
                                <!-- <span class="popular-badge blog-badge">Photographer</span> -->
                            </div>
                            <div class="p-3">
                                <div class="blog-time">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
                                        <path
                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($blog->publish_date)->format('F d, Y') }}</span>
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                                                                fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                                                                                                <path
                                                                                                                    d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                                                                                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                                                                                                            </svg> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-3.33 0-10 1.67-10 5v1h20v-1c0-3.33-6.67-5-10-5z" />
                                    </svg>

                                    <span> {{ $blog->author_name }}</span>
                                </div>
                                <h6 class="blog-title">{{ $blog->title }}</h6>
                                <p class="blog-text">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($blog->description), 100) }}
                                </p>
                                <a href="{{ route('blog_detail', ['id' => encrypt($blog->id)]) }}" class="brows-btn">
                                    Read Article
                                    <i class="bi bi-arrow-right-short"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif
    </div>
</section>
