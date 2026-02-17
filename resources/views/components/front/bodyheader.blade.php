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
                                <li><a class="dropdown-item" href="brows.html">All VIdeos</a></li>
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

                        <li class="nav-item"><a class="nav-link" href="collections.html">Collections</a></li>
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
                    <a href="cart.html"><i class="bi bi-cart icon-btn cart"></i></a>

                    <a href="{{ route('login') }}">
                        <button class="btn header-btns btn-sm">Log in</button>
                    </a>

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

            <a class="side-link" href="#">Collections</a>
            <a class="side-link" href="#">Enterprise</a>
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

</header>
