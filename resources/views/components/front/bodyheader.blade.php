<header class="site-header">
    <div class="container">
        <div class="header-content">

            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/front/img/header-logo.png') }}" alt="Logo">
            </a>

            <div class="menu_content">

                <nav class="navbar navbar-expand-lg">
                    <ul class="navbar-nav main-menu">

                        <li class="nav-item dropdown hover-dropdown">
                            <a class="nav-link dropdown-toggle" href="#">Videos</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('videos') }}">All VIdeos</a></li>
                                <li><a class="dropdown-item" href="brows.html">Holy Land</a></li>
                                <li><a class="dropdown-item" href="brows.html">Around the World</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown hover-dropdown">
                            <a class="nav-link dropdown-toggle" href="#">Photos</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">All Photos</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown hover-dropdown">
                            <a class="nav-link dropdown-toggle" href="#">Artwork</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">All Art Work</a></li>
                                <li><a class="dropdown-item" href="#">Fine Art Prints</a></li>
                            </ul>
                        </li>

                        <li class="nav-item"><a class="nav-link" href="{{ route('collection') }}">Collections</a></li>
                        <li class="nav-item"><a class="nav-link" href="enterprise.html">Enterprise</a></li>
                        <li class="nav-item"><a class="nav-link" href="store.html">Store</a></li>

                    </ul>
                </nav>

                <div class="header-actions">

                    <div class="dropdown d-none d-lg-block">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Pricing</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">View Pricing</a></li>
                            <li><a class="dropdown-item" href="#">Enterprise Plan</a></li>
                        </ul>
                    </div>

                    <a href="#"><i class="bi bi-globe icon-btn"></i></a>
                    <a href="wishlist.html"><i class="bi bi-heart icon-btn"></i></a>
                    <button class="cart-open"><i class="bi bi-cart icon-btn cart"></i></button>

                    @guest
                        <a href="{{ route('login') }}">
                            <button class="btn header-btns btn-sm">Log in</button>
                        </a>
                    @endguest


                    @auth
                        <a href="{{ route('logout') }}">
                            <button class="btn header-btns btn-sm">Log Out</button>
                        </a>
                    @endauth

                    <a href="pricing.html" class="d-none d-xl-block">
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
                        <a class="dropdown-item" href="brows.html">All VIdeos</a>
                        <a class="dropdown-item" href="brows.html">Holy Land</a>
                        <a class="dropdown-item" href="brows.html">Around the World</a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#mPhotos">
                    Photos
                </button>
                <div id="mPhotos" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <a class="dropdown-item" href="#">All Photos</a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#mArtwork">
                    Artwork
                </button>
                <div id="mArtwork" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <a class="dropdown-item" href="#">All Art Work</a>
                        <a class="dropdown-item" href="#">Fine Art Prints</a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#mPricing">
                    Pricing
                </button>
                <div id="mPricing" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <a class="dropdown-item" href="#">View Pricing</a>
                        <a class="dropdown-item" href="#">Enterprise Plan</a>
                    </div>
                </div>
            </div>

            <a class="side-link" href="collection.html">Collections</a>
            <a class="side-link" href="enterprise.html">Enterprise</a>
            <a class="side-link" href="#">Our Store</a>

        </div>

        <div class="mobile-cta">
            <a href="pricing.html">
                <button class="cta-mobile-btn ">
                    Get Unlimited Downloads
                </button>
            </a>
        </div>

        <div class="side-footer">
            <a href="log_in.html">
                <button class="signin-btn">Sign In</button>
            </a>
        </div>
    </div>

    <!-- side cart menu -->
    <div class="cart-section">
        <div class="cart-heading">
            <h3><i class="bi bi-cart"></i> Shopping Cart</h3>
            <button class="close-cart-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="cart-items">
            <div class="cart-content">
                <div class="cart-img">
                    <img src="imgs/alex-harwood-k1xCZT0x48c-unsplash.jpg" width="100%" height="100%"
                        alt="">
                </div>
                <div class="cart-detail">
                    <h6>diamond_logo (Standard License)</h6>
                    <p>518 x 352</p>
                    <div class="cart-price-btn">
                        <h5>$149</h5>
                        <button type="button"> <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-trash2 h-4 w-4">
                                <path d="M3 6h18"></path>
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                <line x1="10" x2="10" y1="11" y2="17"></line>
                                <line x1="14" x2="14" y1="11" y2="17"></line>
                            </svg></button>
                    </div>
                </div>
            </div>
            <div class="cart-content">
                <div class="cart-img">
                    <img src="imgs/alvan-nee-Dbng7f0lpmo-unsplash.jpg" width="100%" height="100%" alt="">
                </div>
                <div class="cart-detail">
                    <h6>diamond_logo (Standard License)</h6>
                    <p>518 x 352</p>
                    <div class="cart-price-btn">
                        <h5>$149</h5>
                        <button type="button"> <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-trash2 h-4 w-4">
                                <path d="M3 6h18"></path>
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                <line x1="10" x2="10" y1="11" y2="17"></line>
                                <line x1="14" x2="14" y1="11" y2="17"></line>
                            </svg></button>
                    </div>
                </div>
            </div>
            <div class="cart-content">
                <div class="cart-img">
                    <img src="imgs/amanda-sala-Xq_cvFHQlfw-unsplash.jpg" width="100%" height="100%"
                        alt="">
                </div>
                <div class="cart-detail">
                    <h6>diamond_logo (Standard License)</h6>
                    <p>518 x 352</p>
                    <div class="cart-price-btn">
                        <h5>$149</h5>
                        <button type="button"> <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-trash2 h-4 w-4">
                                <path d="M3 6h18"></path>
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                <line x1="10" x2="10" y1="11" y2="17"></line>
                                <line x1="14" x2="14" y1="11" y2="17"></line>
                            </svg></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="cart-total">
            <div class="total-count">
                <p>Total</p>
                <h5>$500.00</h5>
            </div>
            <div class="checkout-btn">
                <a class="btn-orange btn w-100" href="{{ route('checkout') }}">Proccess to Ckeckout</a>
            </div>
            <div class="view-cart-btn">
                <a href="cart.html" class="w-100 btn btn-all-dark btn-hover-dark">View Cart</a>
            </div>
        </div>
    </div>

</header>
