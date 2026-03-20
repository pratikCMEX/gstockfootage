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
                            <div class="modal-body search-image-body">
                                <input type="file" id="search-image" hidden>

                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-upload h-12 w-12  mb-2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" x2="12" y1="3" y2="15"></line>
                                </svg>
                                <label for="search-image">Click to upload an image
                                    or drag and drop</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-hover-dark btn-all-dark cancel-btn"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-orange ">Search</button>
                            </div>
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
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 col-12 text-sm-end text-start">
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
                        <p>Showing {{ count($allPhotos) }} photos</p>
                    </div>
                </div>

            </div>
            <div class="row mt-3 row-gap-3">
                @if (isset($allPhotos) && !empty($allPhotos))
                    @foreach ($allPhotos as $photos)
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-12">
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
                                            data-Product-id="{{ $photos->id }}" data-type="{{ $photos->type }}">
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
                                                <a class="share-option" id="shareX" href="#"
                                                    target="_blank">
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
                                                <a class="share-option" id="shareInstagram" href="#"
                                                    target="_blank">
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
                                                <a class="share-option" id="shareFacebook" href="#"
                                                    target="_blank">
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
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
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
                <!-- <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-12">
                    <div class="product-card">

                        <a href="{{ route('product.detail', encrypt(1)) }}">
                            <img loading="lazy" src="{{ asset('assets/front/img/jivan-garcha-eqxjqXER9NY-unsplash.jpg') }}"
                                class="product-img" alt="">
                        </a>

                        <div class="p-3">

                            <span class="badge badge-custom mb-2">Art</span>

                            <a href="{{ route('product.detail', encrypt(1)) }}">
                                <h6 class="popular-detail-title">Art & Craft</h6>
                            </a>


                            <div class="price-btn">
                                <span class="price">$149</span>
                                {{-- <button class="btn btn-orange">Add</button> --}}
                                <a href="{{ route('product.detail', encrypt(1)) }}" class="btn btn-orange">Add</a>
                            </div>
                            <div class="product-two-btn">
                                <button class="btn  popular-icon-btn"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-heart"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                    </svg>
                                    Save</button>
                                <button class="btn  popular-icon-btn"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-share"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3" />
                                    </svg>
                                    Share</button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-12">
                    <div class="product-card">

                        <a href="{{ route('product.detail', encrypt(1)) }}">
                            <img loading="lazy" src="{{ asset('assets/front/img/land-o-lakes-inc-1w3tO5F8HYY-unsplash.jpg') }}"
                                class="product-img" alt="">
                        </a>

                        <div class="p-3">

                            <span class="badge badge-custom mb-2">Art</span>

                            <a href="{{ route('product.detail', encrypt(1)) }}">
                                <h6 class="popular-detail-title">Art & Craft</h6>
                            </a>


                            <div class="price-btn">
                                <span class="price">$149</span>
                                {{-- <button class="btn  btn-orange">Add</button>
                                 --}}
                                <a href="{{ route('product.detail', encrypt(1)) }}" class="btn btn-orange">Add</a>

                            </div>
                            <div class="product-two-btn">
                                <button class="btn  popular-icon-btn"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-heart"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                    </svg>
                                    Save</button>
                                <button class="btn  popular-icon-btn"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-share"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3" />
                                    </svg>
                                    Share</button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-12">
                    <div class="product-card">

                        <a href="{{ route('product.detail', encrypt(1)) }}">
                            <img loading="lazy" src="{{ asset('assets/front/img/land-o-lakes-inc-BvZYHz9TeCk-unsplash.jpg') }}"
                                class="product-img" alt="">
                        </a>

                        <div class="p-3">

                            <span class="badge badge-custom mb-2">Art</span>

                            <a href="{{ route('product.detail', encrypt(1)) }}">
                                <h6 class="popular-detail-title">Art & Craft</h6>
                            </a>


                            <div class="price-btn">
                                <span class="price">$149</span>
                                {{-- <button class="btn  btn-orange">Add</button> --}}
                                <a href="{{ route('product.detail', encrypt(1)) }}" class="btn btn-orange">Add</a>

                            </div>
                            <div class="product-two-btn">
                                <button class="btn  popular-icon-btn"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-heart"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                    </svg>
                                    Save</button>
                                <button class="btn  popular-icon-btn"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-share"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3" />
                                    </svg>
                                    Share</button>
                            </div>

                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
</main>
