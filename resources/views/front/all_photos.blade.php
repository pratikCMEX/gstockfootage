<main>
    <!-- hero section -->
    <section class="hero">
        <div class="container">
            <h1>Explore photos and royalty-free stock images</h1>
            <p class="hero-text">High-quality images from Israel and the Holy Land, ready for print or digital use
            </p>
            <div class="search-wrapper">
                <div class="search-box shadow-lg">

                    <div class="dropdown">
                        <button class="btn dropdown-toggle custom-dropdown" data-bs-toggle="dropdown">
                            <i class="bi bi-image"></i>
                            Photos
                        </button>

                        <ul class="dropdown-menu custom-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-grid"></i> All content</a></li>
                            <li><a class="dropdown-item" href="#">
                                    <i class="bi bi-camera-video"></i>
                                    Videos</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-palette"></i> Artwork</a></li>
                        </ul>
                    </div>

                    <div class="inp-search">
                        <input type="text" placeholder="Start your next project" />

                        <button class="search-btn">
                            <i class="bi bi-search"></i>
                        </button>
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
                                <button class="btn btn-orange dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    More <i class="bi bi-three-dots"></i>
                                </button>
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
                        </div>
                    @endforeach
                    <!-- <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="brand-posibility">
                        <div class="posibility-img">
                            <img width="100%" height="100%"
                                src="{{ asset('assets/front/img/brianna-parks-j6vp8NJPHOI-unsplash.jpg') }}" alt="">
                        </div>
                        <div class="posibilty-title">
                            <h3>Worldwide Footage</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="brand-posibility">
                        <div class="posibility-img">
                            <img width="100%" height="100%"
                                src="{{ asset('assets/front/img/christopher-stites-M6b7Pm2u-ms-unsplash.jpg') }}"
                                alt="">
                        </div>
                        <div class="posibilty-title">
                            <h3>Photography</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="brand-posibility">
                        <div class="posibility-img">
                            <img width="100%" height="100%"
                                src="{{ asset('assets/front/img/daniel-miksha-9U645Y6gxEc-unsplash.jpg') }}" alt="">
                        </div>
                        <div class="posibilty-title">
                            <h3>Fine Art Prints</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="brand-posibility">
                        <div class="posibility-img">
                            <img width="100%" height="100%"
                                src="{{ asset('assets/front/img/anita-austvika-7VTKbHqli9c-unsplash.jpg') }}" alt="">
                        </div>
                        <div class="posibilty-title">
                            <h3>Holy Land Collection</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="brand-posibility">
                        <div class="posibility-img">
                            <img width="100%" height="100%"
                                src="{{ asset('assets/front/img/brianna-parks-j6vp8NJPHOI-unsplash.jpg') }}" alt="">
                        </div>
                        <div class="posibilty-title">
                            <h3>Worldwide Footage</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="brand-posibility">
                        <div class="posibility-img">
                            <img width="100%" height="100%"
                                src="{{ asset('assets/front/img/christopher-stites-M6b7Pm2u-ms-unsplash.jpg') }}"
                                alt="">
                        </div>
                        <div class="posibilty-title">
                            <h3>Photography</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="brand-posibility">
                        <div class="posibility-img">
                            <img width="100%" height="100%"
                                src="{{ asset('assets/front/img/daniel-miksha-9U645Y6gxEc-unsplash.jpg') }}" alt="">
                        </div>
                        <div class="posibilty-title">
                            <h3>Fine Art Prints</h3>
                        </div>
                    </div>
                </div> -->
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

                                    <span
                                        class="badge badge-custom mb-2">{{ $photos->category->category_name }}</span>
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
