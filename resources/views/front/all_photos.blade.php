<main>
    <!-- hero section -->
    <section class="hero">
        <div class="container">
            <h1>Explore photos and royalty-free stock images</h1>
            <p class="hero-text">High-quality images from Israel and the Holy Land, ready for print or digital use
            </p>
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

                            <form action="{{ route('photos.searchByImage') }}" method="POST"
                                enctype="multipart/form-data">
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
                                    <svg id="uploadIcon" xmlns="http://www.w3.org/2000/svg" width="35"
                                        height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
    <!-- stock photo category section -->
    @if ($categories->isNotEmpty())
        <section class="brows-category">
            <div class="container">
                <div class="row g-4 d-flex align-items-center mb-4">
                    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6 col-12">
                        <div class="heading ">
                            <h2 class="m-0">
                                Explore stock<span class="yellow-headings"> Photos Categories</span>
                            </h2>
                        </div>
                    </div>

                </div>
                <div class="row row-gap-4">

                    @foreach ($categories as $category)
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                            <a
                                href="{{ route('all_photos', ['category_id' => encrypt($category->id), 'type' => 'image']) }}">

                                <div class="brand-posibility">
                                    <div class="posibility-img">
                                        <img loading="lazy" width="100%" height="100%"
                                            src="{{ asset('uploads/images/category/' . $category->category_image) }}"
                                            alt="">
                                    </div>
                                    <div class="posibilty-title">
                                        <h3>{{ $category->category_name }}</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- trending today -->
    <section class="photo-trending-today mt-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="heading ">
                        <h2>
                            Photos that are <span class="yellow-headings">
                                @if (!empty($selectedCollection))
                                    from {{ $selectedCollection->name }} Collection
                                @elseif(!empty($selectedCategory))
                                    from {{ $selectedCategory->category_name }} Category
                                @else
                                    trending today
                                @endif
                            </span>
                        </h2>
                        <p id="photo-count">Showing {{ count($allPhotos) }} photo(s)</p>
                    </div>
                </div>

            </div>
            <div class="row mt-3 row-gap-3">
                <div class="col-xl-3 col-lg-4 col-md-12">

                    <div class="filter-sidebar filter-desktop">

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="filter-title">Filters</div>
                            <button class="btn btn-link btn-sm p-0 text-danger text-decoration-none"
                                id="clearAllFiltersBtn" style="font-size:13px;">Clear All</button>
                        </div>

                        <div class="accordion" id="filterAccordionDesktop">

                            <!-- Price -->
                            <div class="accordion-item">
                                <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#priceD">
                                    Price Range
                                    <i class="fa-solid fa-angle-up"></i>
                                </button>
                                <div id="priceD" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <div class="d-flex gap-2 mb-2">
                                            <input type="number" id="price_min_input"
                                                class="form-control form-control-sm" min="0"
                                                max="{{ $allPhotos->max('price') }}" value="0" placeholder="$0"
                                                readonly>
                                            <input type="number" id="price_max_input"
                                                class="form-control form-control-sm" min="0"
                                                max="{{ $allPhotos->max('price') }}"
                                                value="{{ $allPhotos->max('price') }}"
                                                placeholder="${{ $allPhotos->max('price') }}">
                                        </div>
                                        <div class="track-wrap">
                                            <div class="track-bg"></div>
                                            <div class="track-fill"></div>
                                            <input type="range" min="0"
                                                max="{{ $allPhotos->max('price') }}"
                                                value="{{ $allPhotos->max('price') }}" id="priceRangeMax">
                                        </div>
                                        <div class="range-values">
                                            <span>$0</span>
                                            <span id="priceMaxLabel">${{ $allPhotos->max('price') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Orientation -->
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#orientationD">
                                    Orientation
                                    <i class="fa-solid fa-angle-up"></i>
                                </button>
                                <div id="orientationD" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="filter-option form-check">
                                            <input class="form-check-input filter-check" type="checkbox"
                                                id="landscape_d" name="orientation[]" value="landscape">
                                            <label class="form-check-label" for="landscape_d">Landscape</label>
                                        </div>
                                        <div class="filter-option form-check">
                                            <input class="form-check-input filter-check" type="checkbox"
                                                id="portrait_d" name="orientation[]" value="portrait">
                                            <label class="form-check-label" for="portrait_d">Portrait</label>
                                        </div>
                                        <div class="filter-option form-check">
                                            <input class="form-check-input filter-check" type="checkbox"
                                                id="square_d" name="orientation[]" value="square">
                                            <label class="form-check-label" for="square_d">Square</label>
                                        </div>
                                        <div class="filter-option form-check">
                                            <input class="form-check-input filter-check" type="checkbox"
                                                id="vertical_d" name="orientation[]" value="vertical">
                                            <label class="form-check-label" for="vertical_d">Vertical</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#contentD">
                                    Content
                                    <i class="fa-solid fa-angle-up"></i>
                                </button>
                                <div id="contentD" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="filter-option form-check">
                                            <input class="form-check-input filter-check" type="checkbox"
                                                id="with_people_d" name="content_filters[]" value="with_people">
                                            <label class="form-check-label" for="with_people_d">With
                                                People</label>
                                        </div>
                                        <div class="filter-option form-check">
                                            <input class="form-check-input filter-check" type="checkbox"
                                                id="without_people_d" name="content_filters[]"
                                                value="without_people">
                                            <label class="form-check-label" for="without_people_d">Without
                                                People</label>
                                        </div>
                                        <div class="filter-option form-check">
                                            <input class="form-check-input filter-check" type="checkbox"
                                                id="with_animals_d" name="content_filters[]" value="with_animals">
                                            <label class="form-check-label" for="with_animals_d">Animals</label>
                                        </div>
                                        <div class="filter-option form-check">
                                            <input class="form-check-input filter-check" type="checkbox"
                                                id="outdoors_nature_d" name="content_filters[]"
                                                value="outdoors_nature">
                                            <label class="form-check-label" for="outdoors_nature_d">Outdoors /
                                                Nature</label>
                                        </div>
                                        <div class="filter-option form-check">
                                            <input class="form-check-input filter-check" type="checkbox"
                                                id="indoors_d" name="content_filters[]" value="indoors">
                                            <label class="form-check-label" for="indoors_d">Indoors</label>
                                        </div>
                                        <div class="filter-option form-check">
                                            <input class="form-check-input filter-check" type="checkbox"
                                                id="copy_space_d" name="content_filters[]" value="copy_space">
                                            <label class="form-check-label" for="copy_space_d">Copy Space</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Category & Subcategory -->
                            <!-- Category & Subcategory -->
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#categoryD">
                                    Category
                                    <i class="fa-solid fa-angle-up"></i>
                                </button>
                                <div id="categoryD" class="accordion-collapse collapse">
                                    <div class="accordion-body p-0">
                                        @foreach ($categories as $category)
                                            <div class="category-filter-item">
                                                <!-- Parent Category Checkbox -->
                                                <div class="filter-option form-check">
                                                    <input class="form-check-input filter-check parent-category-check"
                                                        type="checkbox" id="cat_{{ $category->id }}"
                                                        name="category_id[]" value="{{ encrypt($category->id) }}"
                                                        data-category-id="{{ $category->id }}">
                                                    <label class="form-check-label fw-500 ms-2"
                                                        for="cat_{{ $category->id }}">
                                                        {{ $category->category_name }}
                                                    </label>
                                                </div>

                                                <!-- Subcategories (hidden by default) -->
                                                @if ($category->subcategories && $category->subcategories->count() > 0)
                                                    <div class="subcategory-list ps-4" id="sub_{{ $category->id }}"
                                                        style="display:none; background:#f5f5f5;">
                                                        @foreach ($category->subcategories as $sub)
                                                            <div class="filter-option form-check ">
                                                                <input
                                                                    class="form-check-input filter-check sub-category-check"
                                                                    type="checkbox" id="sub_{{ $sub->id }}"
                                                                    name="subcategory_id[]"
                                                                    value="{{ encrypt($sub->id) }}"
                                                                    data-parent-id="{{ $category->id }}">
                                                                <label class="form-check-label ms-2"
                                                                    for="sub_{{ $sub->id }}">
                                                                    {{ $sub->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="heading-btn">
                        <div class="dropdown">
                            {{-- <button class="btn btn-orange dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                More <i class="bi bi-three-dots"></i>
                            </button> --}}
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">All Clips</a></li>
                                <li><a class="dropdown-item" href="#">Featured</a></li>
                                <li><a class="dropdown-item" href="#">Needs Review</a></li>
                                <li><a class="dropdown-item" href="#">Processing Queue</a></li>
                                <li><a class="dropdown-item" href="#">Failed Uploads</a></li>
                                <li><a class="dropdown-item" href="#">Ready to Publish</a></li>
                                <li><a class="dropdown-item" href="#">This Week</a></li>
                                <li><a class="dropdown-item" href="#">Missing Thumbnails</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
                @if (isset($allPhotos) && $allPhotos->count() > 0)
                    <div class="col-xl-9 col-lg-8 col-md-12">
                        <div class="row" id="photo-grid-wrapper">

                            @foreach ($allPhotos as $photos)
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 col-12 mb-4">
                                    <div class="product-card">

                                        <a href="{{ route('product.detail', encrypt($photos->id)) }}">
                                            <img loading="lazy"
                                                src="{{ $photos->mid_path ? Storage::disk('s3')->url($photos->mid_path) : '' }}"
                                                class="product-img" alt="">
                                        </a>

                                        <div class="p-3">

                                            <span
                                                class="badge badge-custom mb-2">{{ $photos->category->category_name }}</span>
                                            <a href="{{ route('product.detail', encrypt($photos->id)) }}">
                                                <h6 class="popular-detail-title">{{ $photos->title }}</h6>
                                            </a>

                                            <div class="price-btn">
                                                <span class="price">${{ $photos->price }}</span>
                                                {{-- <button class="btn  btn-orange">Add</button> --}}
                                                <button type="button" {{ isInCart($photos->id) ? 'disabled' : '' }}
                                                    class="btn add_to_cart btn-orange"
                                                    onclick="addToCart({{ $photos->id }}, this)">
                                                    {{ isInCart($photos->id) ? 'Added to Cart' : 'Add to Cart' }}</button>
                                            </div>
                                            <div class="product-two-btn ">
                                                <button class="btn  popular-icon-btn addFavorite "
                                                    data-Product-id="{{ $photos->id }}"
                                                    data-type="{{ $photos->type }}">
                                                    <i
                                                        class="bi {{ $photos->is_favorite == 1 ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                                    {{ $photos->is_favorite == 1 ? 'Saved' : 'Save' }}</button>
                                                <div class="share-wrapper position-relative d-inline-block">
                                                    <button type="button"
                                                        data-url="{{ route('product.detail', encrypt($photos->id)) }}"
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
                                                            data-copy-url="{{ route('product.detail', encrypt($photos->id)) }}"
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
                        </div>
                        <div class="text-center mt-4" id="load-more-wrapper"
                            style="{{ $allPhotos->hasMorePages() ? '' : 'display:none;' }}">
                            <button class="btn btn-orange px-4" id="loadMoreBtn">
                                <span id="loadMoreText">Load More</span>
                                <span id="loadMoreSpinner"
                                    class="spinner-border spinner-border-sm ms-2 d-none"></span>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-info">
                            <h4 class="alert-heading">No Photos Available</h4>
                            <p>There are currently no photos to display. Please check back later.</p>
                            <hr>
                            <p class="mb-0">You can browse our video collection in the meantime.</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>
</main>



<script>
    // ── Range slider (defined OUTSIDE iife so it's available globally) ──
    function initRangeSlider(maxRangeId, maxNumId, maxLabelId) {
        var maxRange = document.getElementById(maxRangeId);
        var maxNum = document.getElementById(maxNumId);
        var maxLabel = document.getElementById(maxLabelId);
        if (!maxRange) return;

        var wrap = maxRange.closest(".track-wrap");
        var fill = wrap ? wrap.querySelector(".track-fill") : null;
        var MAX = parseFloat(maxRange.max) || 100;
        var MIN = parseFloat(maxRange.min) || 0;

        function updateAll(val) {
            val = isNaN(parseFloat(val)) ? MAX : parseFloat(val);

            if (fill) {
                fill.style.left = "0%";
                fill.style.width = ((val - MIN) / (MAX - MIN)) * 100 + "%";
            }
            if (maxNum) maxNum.value = val;
            if (maxLabel) maxLabel.textContent = "$" + parseFloat(val).toFixed(2);
        }

        maxRange.addEventListener("input", function() {
            updateAll(this.value);
        });

        if (maxNum) {
            maxNum.addEventListener("input", function() {
                var val = Math.min(Math.max(parseFloat(this.value) || MIN, MIN), MAX);
                this.value = val;
                maxRange.value = val;
                updateAll(val);
            });
        }

        updateAll(maxRange.value);
    }

    (function() {
        const gridWrapper = document.getElementById("photo-grid-wrapper");
        const countEl = document.getElementById("photo-count");
        const clearBtn = document.getElementById("clearAllFiltersBtn");
        const loadMoreBtn = document.getElementById("loadMoreBtn");
        const loadMoreWrapper = document.getElementById("load-more-wrapper");
        const loadMoreText = document.getElementById("loadMoreText");
        const loadMoreSpinner = document.getElementById("loadMoreSpinner");
        const baseUrl = "{{ route('all_photos') }}";

        if (!gridWrapper) return;

        let currentPage = 1;

        function getFilterParams(page) {
            const params = new URLSearchParams();

            // Preserve search query from URL
            const q = new URLSearchParams(window.location.search).get("q");
            if (q) params.set("q", q);

            // Price — only send if NOT at max (to avoid unnecessary filtering)
            const priceMaxEl = document.getElementById("price_max_input");
            const priceMaxVal = parseFloat(priceMaxEl?.value);
            const priceMaxMax = parseFloat(priceMaxEl?.max);
            if (priceMaxEl && priceMaxVal < priceMaxMax) {
                params.set("price_max", priceMaxVal);
            }

            // Category checkboxes
            document.querySelectorAll('.parent-category-check:checked').forEach(cb => {
                params.append('category_id[]', cb.value);
            });

            // Subcategory checkboxes
            document.querySelectorAll('.sub-category-check:checked').forEach(cb => {
                params.append('subcategory_id[]', cb.value);
            });

            // Orientation + Content filters
            document.querySelectorAll(
                ".filter-check:not(.parent-category-check):not(.sub-category-check):checked"
            ).forEach(cb => {
                params.append(cb.name, cb.value);
            });

            params.set("page", page || 1);
            return params;
        }

        function applyFilters() {
            currentPage = 1;
            gridWrapper.style.opacity = "0.4";
            gridWrapper.style.pointerEvents = "none";

            fetch(`${baseUrl}?${getFilterParams(1).toString()}`, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    },
                })
                .then(res => res.json())
                .then(data => {
                    gridWrapper.innerHTML = data.html;
                    gridWrapper.style.opacity = "1";
                    gridWrapper.style.pointerEvents = "auto";
                    const visibleItems = gridWrapper.children.length;
                    countEl.textContent = `Showing ${visibleItems} photo(s)`;
                    if (loadMoreWrapper) {
                        loadMoreWrapper.style.display = data.hasMore ? "block" : "none";
                    }
                })
                .catch(() => {
                    gridWrapper.style.opacity = "1";
                    gridWrapper.style.pointerEvents = "auto";
                });
        }

        function loadMore() {
            currentPage++;
            if (loadMoreText) loadMoreText.textContent = "Loading...";
            if (loadMoreSpinner) loadMoreSpinner.classList.remove("d-none");
            if (loadMoreBtn) loadMoreBtn.disabled = true;

            fetch(`${baseUrl}?${getFilterParams(currentPage).toString()}`, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    },
                })
                .then(res => res.json())
                .then(data => {
                    gridWrapper.insertAdjacentHTML("beforeend", data.html);
                    if (countEl) countEl.textContent = `Showing ${data.count} photo(s)`;
                    if (loadMoreText) loadMoreText.textContent = "Load More";
                    if (loadMoreSpinner) loadMoreSpinner.classList.add("d-none");
                    if (loadMoreBtn) loadMoreBtn.disabled = false;
                    if (!data.hasMore && loadMoreWrapper) {
                        loadMoreWrapper.style.display = "none";
                    }
                })
                .catch(() => {
                    if (loadMoreText) loadMoreText.textContent = "Load More";
                    if (loadMoreSpinner) loadMoreSpinner.classList.add("d-none");
                    if (loadMoreBtn) loadMoreBtn.disabled = false;
                });
        }

        function debounce(fn, delay = 500) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => fn(...args), delay);
            };
        }

        const debouncedApply = debounce(applyFilters);

        // Price range + checkboxes
        document.querySelectorAll("#price_max_input, #priceRangeMax, .filter-check").forEach(el => {
            el.addEventListener("change", debouncedApply);
            if (el.type === "number" || el.type === "range") {
                el.addEventListener("input", debouncedApply);
            }
        });

        // Parent category toggle
        document.addEventListener("change", function(e) {
            if (!e.target.classList.contains("parent-category-check")) return;
            const subList = document.getElementById(`sub_${e.target.dataset.categoryId}`);
            if (subList) {
                subList.style.display = e.target.checked ? "block" : "none";
                if (!e.target.checked) {
                    subList.querySelectorAll(".sub-category-check").forEach(cb => cb.checked = false);
                }
            }
            debouncedApply();
        });

        // Subcategory change
        document.addEventListener("change", function(e) {
            if (!e.target.classList.contains("sub-category-check")) return;
            debouncedApply();
        });

        // Load more button
        loadMoreBtn?.addEventListener("click", loadMore);

        // Clear all
        clearBtn?.addEventListener("click", function() {
            document.querySelectorAll(".filter-check").forEach(cb => cb.checked = false);
            document.querySelectorAll(".subcategory-list").forEach(el => el.style.display = "none");

            const maxEl = document.getElementById("price_max_input");
            const rangeEl = document.getElementById("priceRangeMax");
            const label = document.getElementById("priceMaxLabel");

            if (maxEl) maxEl.value = maxEl.max;
            if (rangeEl) rangeEl.value = rangeEl.max;
            if (label && maxEl) label.textContent = "$" + parseFloat(maxEl.max).toFixed(2);

            // Re-sync fill
            if (rangeEl) rangeEl.dispatchEvent(new Event("input"));

            applyFilters();
        });

        // No results clear button (dynamically rendered)
        document.addEventListener("click", function(e) {
            if (e.target.closest("#noResultsClearBtn")) clearBtn?.click();
        });

        // Init range slider
        initRangeSlider("priceRangeMax", "price_max_input", "priceMaxLabel");

    })();
</script>
