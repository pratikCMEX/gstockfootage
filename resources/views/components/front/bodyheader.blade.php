@php
    $cart = getCartItems();

@endphp

<header class="site-header">
    <div class="container">
        <div class="header-content">

            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/front/img/header-logo.png') }}" alt="Logo">
            </a>

            <div class="menu_content">

                <nav class="navbar navbar-expand-lg">
                    <ul class="navbar-nav main-menu">

                        {{-- <li class="nav-item dropdown hover-dropdown">
                            <a class="nav-link dropdown-toggle" href="#">Videos</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('videos') }}">All Videos</a></li>
                                <!-- <li><a class="dropdown-item" href="javascript:void(0);">Holy Land</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Around the World</a></li> -->
                            </ul>
                        </li>

                        <li class="nav-item dropdown hover-dropdown">
                            <a class="nav-link dropdown-toggle" href="#">Photos</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('all_photos') }}">All Photos</a></li>
                            </ul>
                        </li> --}}

                        <!-- <li class="nav-item dropdown hover-dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0);">Artwork</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:void(0);">All Art Work</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Fine Art Prints</a></li>
                            </ul>
                        </li> -->

                        <li class="nav-item"><a class="nav-link {{ request()->segment(1) == 'home' ? 'active' : '' }}"
                                href="{{ route('home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->segment(1) == 'videos' ? 'active' : '' }}"
                                href="{{ route('videos') }}">Videos</a></li>
                        <li class="nav-item"><a
                                class="nav-link  {{ request()->segment(1) == 'allPhotos' ? 'active' : '' }}"
                                href="{{ route('all_photos') }}">Images</a></li>
                        <li class="nav-item"><a
                                class="nav-link   {{ request()->segment(1) == 'collection' ? 'active' : '' }}"
                                href="{{ route('collection') }}">Collections</a></li>
                        {{-- <li class="nav-item"><a class="nav-link" href="{{ route('enterprise') }}">Enterprise</a>
                        </li> --}}
                        <li class="nav-item"><a
                                class="nav-link    {{ request()->segment(1) == 'enterprise' ? 'active' : '' }}"
                                href="{{ route('enterprise') }}">Enterprise</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->segment(1) == 'print' ? 'active' : '' }}"
                                href="{{ route('print_store') }}">Store</a></li>

                    </ul>
                </nav>

                <div class="header-actions">

                    <div class="dropdown d-none d-lg-block">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Pricing</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('pricing') }}">View Pricing</a></li>
                            <li><a class="dropdown-item" href="{{ route('enterprise') }}">Enterprise Plan</a></li>
                        </ul>
                    </div>

                    <!-- <a href="javascript:void(0);"><i class="bi bi-globe icon-btn"></i></a> -->
                    <!-- @if (auth()->check())
<a href="{{ route('favorites') }}"><i class="bi bi-heart icon-btn"></i></a>
                        <a href="{{ route('view_profile') }}"><i class="fa-regular fa-2x fa-circle-user"></i></a>
@endif -->
                    <div class="cart-main"> <button class="cart-open"><i class="bi bi-cart icon-btn cart"></i></button>

                        @php

                            if (count($cart['items']) > 0) {
                                $cart_class = '';
                            } else {
                                $cart_class = 'd-none';
                            }
                        @endphp
                        <span class="cart-count {{ $cart_class }}">{{ count($cart['items']) }}</span>
                    </div>
                    <div class="profile dropdown hover-dropdown">
                        <!-- <a href="javascript:void(0);" class="dropdown-toggle"><i class="bi bi-person-circle icon-btn profile-btn"></i>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="bi bi-person"></i> Profile</a></li> -->
                        @if (auth()->check())
                            <a href="javascript:void(0);" class="dropdown-toggle"><i
                                    class="bi bi-person-circle icon-btn profile-btn"></i>
                                <ul class="dropdown-menu">

                                    <li><a class="dropdown-item" href="{{ route('user.profile', ['tab' => 'profile']) }}"><i
                                                class="bi bi-person"></i>
                                            Profile</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('user.profile', ['tab' => 'downloads']) }}"><i
                                                class="bi bi-bag"></i> Downloads</a></li>
                                    <li class="wishlist">
                                        <a class="dropdown-item" href="{{ route('user.profile', ['tab' => 'wishlist']) }}">
                                            <i class="bi bi-heart"></i>
                                            Wishlist
                                            @php $wishlistCount = auth()->user()->favorites()->whereHas('batchFile')->count(); @endphp
                                            <p class="wishlist-count" @if($wishlistCount == 0) style="display:none;" @endif>
                                                {{ $wishlistCount ?? ' ' }}
                                            </p>
                                            <!-- <p class="wishlist-count">{{ auth()->user()->favorites()->whereHas('batchFile')->count() }}</p> -->
                                        </a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}"><i
                                                class="bi bi-box-arrow-right"></i>
                                            Logout</a></li>
                                </ul>
                            </a>
                        @endif
                    </div>

                    @guest
                        <a href="{{ route('login') }}">
                            <button class="btn header-btns btn-sm">Log in</button>
                        </a>
                    @endguest


                    <!-- @auth
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <a href="{{ route('logout') }}">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <button class="btn header-btns btn-sm">Log Out</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </a>
                    @endauth -->

                    <a href="{{ route('pricing') }}" class="d-none d-xl-block">
                        <button class="btn header-btns btn-sm cta-btn">
                            Get Unlimited Downloads
                        </button>
                    </a>

                    <button class="custom-toggler d-lg-none" id="menuToggle">
                        <span></span><span></span><span></span>
                    </button>

                </div>
            </div>
        </div>
    </div>
    <!-- mobile menu -->
    <div class="menu-overlay" id="overlay"></div>

    <div class="side-menu" id="sideMenu">
        <span class="side-close" id="closeMenu"><i class="bi bi-x"></i></span>

        <div class="accordion side-accordion">

            <div class="accordion-item">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#mVideos">
                    Videos
                </button>
                <div id="mVideos" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <a class="dropdown-item" href="javascript:void(0);">All VIdeos</a>
                        <a class="dropdown-item" href="javascript:void(0);">Holy Land</a>
                        <a class="dropdown-item" href="javascript:void(0);">Around the World</a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#mPhotos">
                    Photos
                </button>
                <div id="mPhotos" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <a class="dropdown-item" href="javascript:void(0);">All Photos</a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#mArtwork">
                    Artwork
                </button>
                <div id="mArtwork" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <a class="dropdown-item" href="javascript:void(0);">All Art Work</a>
                        <a class="dropdown-item" href="javascript:void(0);">Fine Art Prints</a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#mPricing">
                    Pricing
                </button>
                <div id="mPricing" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <a class="dropdown-item" href="javascript:void(0);">View Pricing</a>
                        <a class="dropdown-item" href="javascript:void(0);">Enterprise Plan</a>
                    </div>
                </div>
            </div>

            <a class="side-link" href="{{ route('collection') }}">Collections</a>
            <a class="side-link" href="{{ route('enterprise') }}-">Enterprise</a>
            {{-- <a class="side-link" href="{{ route('enterprise') }}">Enterprise</a> --}}
            <a class="side-link" href="javascript:void(0);">Our Store</a>

        </div>

        <div class="mobile-cta">
            <a href="{{ route('pricing') }}">
                <button class="cta-mobile-btn ">
                    Get Unlimited Downloads
                </button>
            </a>
        </div>

        <div class="side-footer">
            <a href="javascript:void(0);">
                <button class="signin-btn">Sign In</button>
            </a>
        </div>
    </div>

    <!-- side cart menu -->
    <div class="cart-overlay" id="cartoverlay"></div>
    <div class="cart-section">
        <div class="cart-heading">
            <h3><i class="bi bi-cart"></i> Shopping Cart</h3>
            <button class="close-cart-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="cart-items">

            @if (count($cart['items']) == 0)
                <div class="cart-empty"
                    style="display: flex; flex-direction: column; gap: 20px; align-items: center; justify-content: center;height: 100%;">
                    <p>
                        Cart is empty
                    </p>
                    {{-- <button type="button" class="btn btn-orange">Return to shop</button> --}}
                </div>
            @else
                @foreach ($cart['items'] as $item)
                    <div class="cart-content" id="cart-item-{{ $item['id'] }}" data-id="{{ $item['id'] }}"
                        data-price="{{ $item['price'] }}">
                        <div class="cart-img">
                            @if ($item['type'] == 'image')
                                <img src="{{ $item['mid_path'] ? Storage::disk('s3')->url($item['mid_path']) : asset('assets/admin/images/demo_thumbnail.png') }}"
                                    class="h-100 w-100" alt="">
                            @else
                                <img src="{{ $item['thumbnail_path'] ? Storage::disk('s3')->url($item['thumbnail_path']) : asset('assets/admin/images/demo_thumbnail.png') }}"
                                    class="h-100 w-100" alt="">
                            @endif
                        </div>
                        <div class="cart-detail">
                            <h6>{{ $item['title'] }}</h6>
                            @if ($item['type'] == 'image')
                                <p>{{ $item['size'] }}</p>
                            @else
                                <p>{{ $item['size'] ?? '' }}</p>
                            @endif
                            <div class="cart-price-btn">
                                <h5>${{ $item['price'] }}</h5>
                                <button type="button" class="delete_add_to_cart" data-id="{{ $item['id'] }}"
                                    data-price="{{ $item['price'] }}"> <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                        height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 h-4 w-4">
                                        <path d="M3 6h18"></path>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                        <line x1="10" x2="10" y1="11" y2="17"></line>
                                        <line x1="14" x2="14" y1="11" y2="17"></line>
                                    </svg></button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
        <div class="cart-total cart-btns {{ count($cart['items']) > 0 ? '' : 'd-none' }}">
            <div class="total-count">
                <p>Total</p>
                <h5 class="total_cart_amt">${{ number_format($cart['total'], 2) }}</h5>
            </div>
            <div class="checkout-btn cart-btns {{ count($cart['items']) > 0 ? '' : 'd-none' }}">
                <a class="btn-orange btn w-100"
                    href="{{ auth()->check() ? route('checkout') : route('login') }}">Proccess to Checkout</a>
            </div>
            <div class="view-cart-btn cart-btns {{ count($cart['items']) > 0 ? '' : 'd-none' }}">
                <a href="{{ auth()->check() ? route('cart.list') : route('login') }}"
                    class="w-100 btn btn-all-dark btn-hover-dark">View
                    Cart</a>
            </div>
        </div>
    </div>

</header>