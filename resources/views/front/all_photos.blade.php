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
                                <a class="dropdown-item" href="{{ route('all_photos') }}" data-type="all"
                                    data-icon="bi bi-grid" data-label="All content">
                                    <i class="bi bi-grid"></i> <span>All content</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('videos') }}" data-type="video"
                                    data-icon="bi bi-camera-video" data-label="Videos">
                                    <i class="bi bi-camera-video"></i> <span>Videos</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('all_photos') }}" data-type="image"
                                    data-icon="bi bi-image" data-label="Photos">
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

            <div class="trending">
                Trending:
                <a href="#">Jerusalem</a>,
                <a href="#">Temple Mount</a>,
                <a href="#">Dead Sea</a>,
                <a href="#">Western Wall</a>,
                <a href="#">Galilee</a>
            </div>

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
                                Explore stock<span class="yellow-headings"> Photos categories</span>
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
                                        <img width="100%" height="100%"
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
                            Photos that are <span class="yellow-headings"> trending today</span>
                        </h2>
                        <p>Showing 4 photos</p>
                    </div>
                </div>

            </div>
            <div class="row mt-3 row-gap-3">
                @if (isset($allPhotos) && !empty($allPhotos))
                    @foreach ($allPhotos as $photos)
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-12">
                            <div class="product-card">

                                <a href="{{ route('product.detail', encrypt($photos->id)) }}">
                                    <img src="{{ Storage::disk('s3')->url($photos->low_path) }}" class="product-img"
                                        alt="">
                                </a>

                                <div class="p-3">

                                    <span class="badge badge-custom mb-2">{{ $photos->category->category_name }}</span>
                                    <a href="{{ route('product.detail', encrypt($photos->id)) }}">
                                        <h6 class="popular-detail-title">{{ $photos->title }}</h6>
                                    </a>

                                    <div class="price-btn">
                                        <span class="price">${{ $photos->price }}</span>
                                        {{-- <button class="btn  btn-orange">Add</button> --}}
                                        <a href="{{ route('product.detail', encrypt($photos->id)) }}"
                                            class="btn btn-orange">Add</a>
                                    </div>
                                    <div class="product-two-btn ">
                                        <button class="btn  popular-icon-btn addFavorite "
                                            data-Product-id="{{ $photos->id }}"
                                            data-type="{{ $photos->type }}"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="16" fill="currentColor"
                                                class="bi bi-heart" viewBox="0 0 16 16">
                                                <path
                                                    d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                            </svg>
                                            Save</button>
                                        <button class="btn  popular-icon-btn"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="16" fill="currentColor"
                                                class="bi bi-share" viewBox="0 0 16 16">
                                                <path
                                                    d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3" />
                                            </svg>
                                            Share</button>
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
                            <img src="{{ asset('assets/front/img/jivan-garcha-eqxjqXER9NY-unsplash.jpg') }}"
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
                            <img src="{{ asset('assets/front/img/land-o-lakes-inc-1w3tO5F8HYY-unsplash.jpg') }}"
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
                            <img src="{{ asset('assets/front/img/land-o-lakes-inc-BvZYHz9TeCk-unsplash.jpg') }}"
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
