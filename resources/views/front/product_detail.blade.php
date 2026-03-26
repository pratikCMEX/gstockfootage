@php
    $perImage = getHighProductQualityPrice();
    // dd($perImage);
@endphp
<section class="product-detail">
    <div class="container-fluid">
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
            <div class="col-xl-8 col-lg-12 col-md-12 col-12">
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
                        <a class=" addFavorite" data-Product-id="{{ $data['id'] }}" data-type="{{ $data['type'] }}">
                            <i
                                class="detailFavorite bi {{ $data['is_favorite'] == 1 ? 'bi-heart-fill' : 'bi-heart' }}"></i></a>
                        <div class="swiper frontproduct">
                            {{-- <div class="swiper-wrapper">
                                <div class="swiper-slide"> --}}
                            <div class="big-slide-img">
                                {{-- @if ($data['type'] == 'video')
                                    <video class="h-100 w-100" autoplay controls="true">
                                        <source
                                            src="{{ $data['mid_path'] != '' ? $data['mid_path'] : $data['file_url'] }}">

                                    </video>
                                    <div class="big-slide-img-overlay"
                                        style="background-image: url({{ $data['thumbnail'] }})">
                                    </div>
                                @else
                                    <img src="{{ $data['mid_path'] != '' ? $data['mid_path'] : $data['file_url'] }}"
                                        class="h-100 w-100" alt="">
                                    <div class="big-slide-img-overlay"
                                        style="background-image: url({{ $data['mid_path'] }})">
                                    </div>
                                @endif --}}
                                @if ($data['type'] == 'video')
                                    {{-- ✅ Unique ID per video using file code or id --}}
                                    <video id="hls-video-{{ $data['id'] }}" class="h-100 w-100" autoplay muted
                                        playsinline controls poster="{{ $data['thumbnail'] ?? '' }}"
                                        data-hls="{{ $data['hls_path'] ?? '' }}"
                                        data-fallback="{{ $data['mid_path'] != '' ? $data['mid_path'] : $data['file_url'] }}">
                                    </video>

                                    <div class="big-slide-img-overlay"
                                        style="background-image: url({{ $data['thumbnail'] }})">
                                    </div>
                                @else
                                    <img src="{{ $data['mid_path'] != '' ? $data['mid_path'] : $data['file_url'] }}"
                                        class="h-100 w-100" alt="">
                                    <div class="big-slide-img-overlay"
                                        style="background-image: url({{ $data['mid_path'] }})">
                                    </div>
                                @endif
                                {{-- {{ dd($data['thumbnail']) }} --}}



                            </div>
                            {{-- </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-8 col-md-12 col-12">
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
                            {{-- <button type="button" class="btn-orange btn add_to_cart"
                                onclick="addToCart({{ $data['id'] }}, this)"> <i class="bi bi-cart2"></i> Add
                                to
                                Cart</button> --}}

                            <button type="button" class="btn add_to_cart btn-orange"
                                {{ isInCart($data['id']) ? 'disabled' : '' }}
                                onclick="addToCart({{ $data['id'] }}, this)">
                                <i class="bi bi-cart{{ isInCart($data['id']) ? '-check' : '2' }}"></i>
                                {{ isInCart($data['id']) ? 'Added to Cart' : 'Add to Cart' }}
                            </button>
                        </div>
                        {{-- <div class="extended product-detail-price">
                            <div class="price-flex">
                                <div class="two-price-title">
                                    <h5>Extended Licenses</h5>
                                    <p class="two-price-subtitle">For print, merchandise, and unlimited digital use
                                    </p>
                                </div>
                                <p>$ {{ isset($perImage) ? $perImage : $data['price'] }}</p>
                            </div>

                            <button type="button"
                                class="btn add_to_cart {{ isInCart($data['id']) ? 'btn-success already-added' : 'btn-orange' }}"
                                {{ isInCart($data['id']) ? 'disabled' : '' }}
                                onclick="addToCart({{ $data['id'] }}, this)">
                                <i class="bi bi-cart{{ isInCart($data['id']) ? '-check' : '2' }}"></i>
                                {{ isInCart($data['id']) ? 'Added to Cart' : 'Add to Cart' }}
                            </button>
                        </div> --}}
                    </div>
                    <div class="product-detail-btn">

                        <div class="share-wrapper position-relative d-inline-block">
                            <button type="button" data-url="{{ route('product.detail', encrypt($data['id'])) }}"
                                class="btn btn-all-dark btn-hover-dark share-trigger-btn">
                                <i class="bi bi-share"></i> Share
                            </button>

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
                                <button class="share-option copy-link-btn"
                                    data-copy-url="{{ route('product.detail', encrypt($data['id'])) }}"
                                    id="copyLinkBtn">
                                    <span class="share-icon copy-icon">
                                        <i class="bi bi-link-45deg" style="font-size:18px;"></i>
                                    </span>
                                    <span id="copyLinkText">Copy Link</span>
                                </button>
                            </div>
                        </div>
                        <p>{{ $data['downloads'] }} Downloads</p>
                    </div>

                    <p class="product-description">
                        {!! $data['description'] !!}
                    </p>
                    <div class="product-detail-tags">
                        <div class="location-tag product-tag">
                            <div class="tag-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="tag-title">
                                <p>Location</p>
                                <h5>{{ $data['location'] }}</h5>
                            </div>
                        </div>
                        <div class="resolution-tag product-tag">
                            <div class="tag-icon">
                                <i class="bi bi-camera"></i>
                            </div>
                            <div class="tag-title">
                                <p>Resolution (H x W)</p>
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
        @if ($productDatas->isNotEmpty())
            <div class="row g-3 mb-2 align-items-center">
                <div class="col-lg-8 col-md-6">
                    <div class="heading">
                        <h2>Related <span
                                class="yellow-headings">{{ $data['type'] === 'image' ? 'Images' : 'Videos' }}</span>
                        </h2>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="product-swiper-btns ">
                        <div class="arrow-product-left product-arrow"><i class="bi bi-chevron-left"></i></div>
                        <div class="arrow-product-right product-arrow"><i class="bi bi-chevron-right"></i></div>
                    </div>
                </div>
            </div>
        @endif

        <div class="swiper mySwiper product-swiper">
            <div class="swiper-wrapper">

                @foreach ($productDatas as $data)
                    <div class="swiper-slide">
                        <div class="product-card">

                            <a href="{{ route('product.detail', encrypt($data->id)) }}">
                                @if ($data->type === 'video')
                                    <video class="product-img" width="100%" muted loop playsinline preload="auto"
                                        poster="{{ !empty($data->thumbnail_path) ? Storage::disk('s3')->url($data->thumbnail_path) : asset('assets/admin/images/demo_thumbnail.png') }}">
                                        <source
                                            src="{{ $data->preview_path ? Storage::disk('s3')->url($data->preview_path) : ($data->mid_path ? Storage::disk('s3')->url($data->mid_path) : asset('assets/admin/images/demo_thumbnail.png')) }}"
                                            type="video/mp4">
                                    </video>
                                @else
                                    <img loading="lazy"
                                        src="{{ $data->mid_path ? Storage::disk('s3')->url($data->mid_path) : asset('assets/admin/images/demo_thumbnail.png') }}"
                                        class="product-img" alt="{{ $data->title }}">
                                @endif
                            </a>
                            {{-- <img
                                    src="{{ asset('assets/front/img/danielle-suijkerbuijk-wUc2nzHiI1I-unsplash.jpg') }}"
                                    class="product-img" alt=""> --}}

                            <div class="p-3">

                                <span class="badge badge-custom mb-2">{{ $data->category->category_name }}</span>

                                <h6 class="popular-detail-title">{{ $data->title }}</h6>


                                <div class="price-btn">
                                    <span class="price">${{ $data->price }}</span>
                                    {{-- <button class="btn  btn-orange">Add</button> --}}
                                </div>
                                <div class="product-two-btn">
                                    <button class="btn  popular-icon-btn addFavorite "
                                        data-Product-id="{{ $data->id }}" data-type="{{ $data->type }}">
                                        <i
                                            class="bi {{ $data->is_favorite == 1 ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                        {{ $data->is_favorite == 1 ? 'Saved' : 'Save' }}</button>
                                    <div class="share-wrapper position-relative d-inline-block">
                                        <button type="button"
                                            data-url="{{ route('product.detail', encrypt($data->id)) }}"
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
                                            <button class="share-option copy-link-btn"
                                                data-copy-url="{{ route('product.detail', encrypt($data->id)) }}"
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
                        {{-- </a> --}}
                    </div>
                @endforeach






            </div>



        </div>
    </div>
</section>

<script>
    const video = document.getElementById('hls-video-{{ $data['id'] }}');

    video.muted = true;

    video.play().catch(err => {
        console.log('Autoplay blocked:', err);
    });
</script>
