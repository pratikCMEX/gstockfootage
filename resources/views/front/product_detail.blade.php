<section class="product-detail">
    <div class="container">
        <div class="row g-4">
            <!-- <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item"><a href="index.html">Product</a></li>
                            <li class="breadcrumb-item active" aria-current="page"></li>
                        </ol>
                    </nav>
                </div> -->
            <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                <div class="product-detail-img">
                    {{-- <div class="small-product-img">
                        <div thumbsSlider="" class="swiper sideproduct">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="small-slide-img">
                                        <img src="imgs/posibility_3.webp" class="h-100 w-100" alt="">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="small-slide-img">
                                        <img src="imgs/posibility_3.webp" class="h-100 w-100" alt="">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="small-slide-img">
                                        <img src="imgs/posibility_3.webp" class="h-100 w-100" alt="">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="small-slide-img">
                                        <img src="imgs/posibility_3.webp" class="h-100 w-100" alt="">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="small-slide-img">
                                        <video class="h-100 w-100" autoplay controls="true">
                                            <source src="./imgs/6666669-uhd_2160_3744_30fps.mp4">
                                        </video>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="swiper-arrows">
                            <div class="custom-product-detail-next product-detail-left product-detail-arrow "><i
                                    class="bi bi-arrow-up-short"></i>
                            </div>
                            <div class="custom-product-detail-prev product-detail-right product-detail-arrow"><i
                                    class="bi bi-arrow-down-short"></i>
                            </div>
                        </div>
                    </div> --}}
                    <div class="big-product-img">
                        <a class="addFavorite" data-Product-id="{{ $data['id'] }}" data-type="{{ $data['type'] }}"> <i
                                class="bi bi-heart"></i></a>
                        <div class="swiper frontproduct">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="big-slide-img">
                                        @if ($data['type'] == 'video')
                                            <video class="h-100 w-100" autoplay controls="true">
                                                <source src="   {{ $data['low_path'] }}">
                                            </video>
                                        @else
                                            <img src=" {{ $data['low_path'] }}" class="h-100 w-100" alt="">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                <div class="product-detail-content">
                    <div class="product-detail-title">
                        <h4>{{ $data['title'] }}</h4>
                    </div>
                    <div class="product-detail-two-price">
                        <div class="standard product-detail-price">
                            <div class="price-flex">
                                <div class="two-price-title">
                                    <h5>
                                        Standard Licenses
                                    </h5>
                                    <p class="two-price-subtitle">For web, social media, and digital use (up to
                                        500k
                                        impressions)</p>
                                </div>
                                <p>${{ $data['price'] }}</p>
                            </div>
                            <button type="button" class="btn-orange btn add_to_cart"
                                onclick="addToCart({{ $data['id'] }}, this)"> <i class="bi bi-cart2"></i> Add
                                to
                                Cart</button>
                        </div>
                        <div class="extended product-detail-price">
                            <div class="price-flex">
                                <div class="two-price-title">
                                    <h5>Extended Licenses</h5>
                                    <p class="two-price-subtitle">For print, merchandise, and unlimited digital use
                                    </p>
                                </div>
                                <p>${{ $data['price'] }}</p>
                            </div>
                            <button type="button" class="btn-orange btn add_to_cart"
                                onclick="addToCart({{ $data['id'] }}, this)"> <i class="bi bi-cart2"></i> Add
                                to
                                Cart</button>
                        </div>
                    </div>
                    <div class="product-detail-btn">

                        <button type="button" class="btn btn-all-dark btn-hover-dark"><i class="bi bi-share"></i>
                            Share</button>
                        <p>2 Downloads</p>
                    </div>
                    <p class="product-description">
                        {{ $data['description'] }}
                    </p>
                    <div class="product-detail-tags">
                        <div class="location-tag product-tag">
                            <div class="tag-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="tag-title">
                                <p>Location</p>
                                <h5>Uncategorized</h5>
                            </div>
                        </div>
                        <div class="resolution-tag product-tag">
                            <div class="tag-icon">
                                <i class="bi bi-camera"></i>
                            </div>
                            <div class="tag-title">
                                <p>Resolution</p>
                                <h5>{{ $data['resolution'] }}</h5>
                            </div>
                        </div>
                        <div class="file-size-tag product-tag">
                            <div class="tag-icon">
                                <i class="bi bi-image-fill"></i>
                            </div>
                            <div class="tag-title">
                                <p>File Size</p>
                                <h5>{{ $data['file_size'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="related-product">
    <div class="container">
        <div class="row g-3 mb-2 align-items-center">
            <div class="col-lg-8 col-md-6">
                <div class="heading">
                    <h2>Related <span class="yellow-headings">Pictures</span></h2>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="product-swiper-btns ">
                    <div class="arrow-product-left product-arrow"><i class="bi bi-chevron-left"></i></div>
                    <div class="arrow-product-right product-arrow"><i class="bi bi-chevron-right"></i></div>
                </div>
            </div>
        </div>
        <div class="swiper mySwiper product-swiper">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <a href="{{ route('product.detail', encrypt(1)) }}">
                        <div class="product-card">

                            <img src="{{ asset('assets/front/img/danielle-suijkerbuijk-wUc2nzHiI1I-unsplash.jpg') }}"
                                class="product-img" alt="">

                            <div class="p-3">

                                <span class="badge badge-custom mb-2">Art</span>

                                <h6 class="popular-detail-title">Art & Craft</h6>


                                <div class="price-btn">
                                    <span class="price">$149</span>
                                    {{-- <button class="btn  btn-orange">Add</button> --}}
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
                    </a>
                </div>

                <div class="swiper-slide">
                    <a href="{{ route('product.detail', encrypt(1)) }}">
                        <div class="product-card">

                            <img src="{{ asset('assets/front/img/danielle-suijkerbuijk-wUc2nzHiI1I-unsplash.jpg') }}"
                                class="product-img" alt="Punjabi Dum Aloo">

                            <div class="p-3">

                                <span class="badge badge-custom mb-2">Food</span>

                                <h6 class="popular-detail-title">Rivers</h6>


                                <div class="price-btn">
                                    <span class="price">$149</span>
                                    {{-- <button class="btn  btn-orange">Add</button> --}}
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
                    </a>
                </div>

                <div class="swiper-slide">
                    <a href="{{ route('product.detail', encrypt(1)) }}">
                        <div class="product-card">

                            <img src="{{ asset('assets/front/img/danielle-suijkerbuijk-wUc2nzHiI1I-unsplash.jpg') }}"
                                class="product-img" alt="">
                            <div class="p-3">

                                <span class="badge badge-custom mb-2">Food</span>

                                <h6 class="popular-detail-title">Mountains</h6>


                                <div class="price-btn">
                                    <span class="price">$149</span>
                                    {{-- <button class="btn  btn-orange">Add</button> --}}
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
                    </a>

                </div>

                <div class="swiper-slide">
                    <a href="{{ route('product.detail', encrypt(1)) }}">
                        <div class="product-card">

                            <img src="{{ asset('assets/front/img/danielle-suijkerbuijk-wUc2nzHiI1I-unsplash.jpg') }}"
                                class="product-img" alt="">

                            <div class="p-3">

                                <span class="badge badge-custom mb-2">Diamond</span>

                                <h6 class="popular-detail-title">Golden Diamond</h6>


                                <div class="price-btn">
                                    <span class="price">$149</span>
                                    {{-- <button class="btn  btn-orange">Add</button> --}}
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
                    </a>

                </div>
                <div class="swiper-slide">
                    <a href="{{ route('product.detail', encrypt(1)) }}">
                        <div class="product-card">

                            <img src="{{ asset('assets/front/img/danielle-suijkerbuijk-wUc2nzHiI1I-unsplash.jpg') }}"
                                class="product-img" alt="">

                            <div class="p-3">

                                <span class="badge badge-custom mb-2">Art</span>

                                <h6 class="popular-detail-title">Art & Craft</h6>


                                <div class="price-btn">
                                    <span class="price">$149</span>
                                    {{-- <button class="btn  btn-orange">Add</button> --}}
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
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="{{ route('product.detail', encrypt(1)) }}">
                        <div class="product-card">

                            <img src="{{ asset('assets/front/img/danielle-suijkerbuijk-wUc2nzHiI1I-unsplash.jpg') }}"
                                class="product-img" alt="Punjabi Dum Aloo">

                            <div class="p-3">

                                <span class="badge badge-custom mb-2">Food</span>

                                <h6 class="popular-detail-title">Rivers</h6>


                                <div class="price-btn">
                                    <span class="price">$149</span>
                                    {{-- <button class="btn  btn-orange">Add</button> --}}
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
                    </a>
                </div>



            </div>



        </div>
    </div>
</section>
