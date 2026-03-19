<!-- hero section -->
<section class="hero">
    <div class="container">
        <h1>Explore videos and royalty-free stock footage</h1>
        <p class="hero-text">License stunning 4K and HD stock videos from the world's best Holy Land video
            collection</p>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-upload h-12 w-12  mb-2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" x2="12" y1="3" y2="15"></line>
                            </svg>
                            <label for="search-image">Click to upload an image or drag and drop</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-hover-dark btn-all-dark cancel-btn"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-orange">Search</button>
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
        <!-- <div class="trending">
            Trending:
            <a href="#">Jerusalem</a>,
            <a href="#">Temple Mount</a>,
            <a href="#">Dead Sea</a>,
            <a href="#">Western Wall</a>,
            <a href="#">Galilee</a>
        </div> -->

    </div>
</section>

<!-- stock video category section -->
@if ($categories->isNotEmpty())
    <section class="brows-category">
        <div class="container">
            <div class="row g-4 d-flex align-items-center mb-4">
                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6 col-12">
                    <div class="heading ">
                        <h2 class="m-0">
                            Explore stock<span class="yellow-headings"> Video Categories</span>
                        </h2>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 col-12 text-sm-end text-start">
                    <div class="heading-btn">
                        <div class="dropdown">
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
                        <a href="{{ route('videos', ['category_id' => encrypt($category->id), 'type' => 'video']) }}">
                            <div class="brand-posibility">
                                <div class="posibility-img">
                                    <img loading="lazy" width="100%" height="100%"
                                        src="{{ asset('uploads/images/category/' . $category->category_image) }}"
                                        alt="{{ $category->category_name ?? '' }}">
                                </div>
                                <div class="posibilty-title">
                                    <h3>{{ $category->category_name ?? '' }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- video -trending section -->
<section class="trending-video mt-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="heading ">
                    <h2>
                        Videos that are<span class="yellow-headings"> trending today</span>
                    </h2>
                </div>
            </div>
        </div>
        <div class="row">

            {{-- ============================================================
                 LEFT: FILTER SIDEBAR (Desktop)
                 CHANGES FROM ORIGINAL:
                   1. Added "Clear All" button next to "Filters" title
                   2. Added class="filter-check" + name="resolution[]" etc. to all checkboxes
                   3. Added class="filter-radio" to all radio buttons
                   4. Added value="..." to all radio buttons
                   5. Added id="priceRangeMax", id="priceMaxLabel", id="price_min_input", id="price_max_input"
                   6. Added id="durationRangeMax", id="durationMaxLabel", id="duration_min_input", id="duration_max_input"
                   7. Changed accordion collapse IDs to be unique (added "D" suffix) to avoid
                      conflict with mobile sidebar which has same Bootstrap targets
            ============================================================ --}}
            <div class="col-xl-3 col-lg-4 col-md-12">
                <div class="filter-sidebar filter-desktop">

                    {{-- CHANGE: added clear all button --}}
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
                                    {{-- <div class="d-flex gap-2 mb-2">
                                        <input type="number" id="price_min_input"
                                            class="form-control form-control-sm" min="0"
                                            max="{{ $allVideos->max('price') }}" value="0" placeholder="$0">
                                        <input type="number" id="price_max_input"
                                            class="form-control form-control-sm" min="0"
                                            max="{{ $allVideos->max('price') }}"
                                            value="{{ $allVideos->max('price') }}"
                                            placeholder="${{ $allVideos->max('price') }}">



                                    </div>
                                    <input type="range" class="range-slider" min="0"
                                        max="{{ $allVideos->max('price') }}" value="{{ $allVideos->max('price') }}"
                                        id="priceRangeMax">
                                    {{-- <div class="range-slider" id="priceRangeMax" data-min="0"
                                        data-max="{{ $allVideos->max('price') }}"
                                        data-value="{{ $allVideos->max('price') }}">
                                    </div> 
                                    <div class="range-values">
                                        <span>$0</span>
                                        <span id="priceMaxLabel">${{ $allVideos->max('price') }}</span>
                                    </div> --}}
                                    {{-- Price Range --}}
                                    <div class="d-flex gap-2 mb-2">
                                        <input type="number" id="price_min_input"
                                            class="form-control form-control-sm" min="0"
                                            max="{{ $allVideos->max('price') }}" value="0" placeholder="$0">
                                        <input type="number" id="price_max_input"
                                            class="form-control form-control-sm" min="0"
                                            max="{{ $allVideos->max('price') }}"
                                            value="{{ $allVideos->max('price') }}"
                                            placeholder="${{ $allVideos->max('price') }}">
                                    </div>
                                    <div class="track-wrap">
                                        <div class="track-bg"></div>
                                        <div class="track-fill"></div>
                                        <input type="range" min="0" max="{{ $allVideos->max('price') }}"
                                            value="{{ $allVideos->max('price') }}" id="priceRangeMax">
                                    </div>
                                    <div class="range-values">
                                        <span>$0</span>
                                        <span id="priceMaxLabel">${{ $allVideos->max('price') }}</span>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Duration -->
                        <div class="accordion-item">
                            <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#durationD">
                                Duration
                                <i class="fa-solid fa-angle-up"></i>
                            </button>
                            <div id="durationD" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="d-flex gap-2 mb-2">
                                        <input type="number" id="duration_min_input"
                                            class="form-control form-control-sm" min="0"
                                            max="{{ $allVideos->max('duration') }}" value="0" placeholder="0s">
                                        <input type="number" id="duration_max_input"
                                            class="form-control form-control-sm" min="0"
                                            max="{{ $allVideos->max('duration') }}"
                                            value="{{ $allVideos->max('duration') }}"
                                            placeholder="{{ $allVideos->max('duration') }}s">
                                    </div>
                                    {{-- <input type="range" class="range-slider" min="0"
                                        max="{{ $allVideos->max('duration') }}" value="120"
                                        id="durationRangeMax"> --}}
                                    <div class="track-wrap">
                                        <div class="track-bg"></div>
                                        <div class="track-fill" style="width:100%"></div>
                                        <input type="range" min="0" max="{{ $allVideos->max('duration') }}"
                                            value="{{ $allVideos->max('duration') }}" id="durationRangeMax">
                                    </div>

                                    {{-- <div class="range-slider" data-min="0"
                                        data-max="{{ $allVideos->max('duration') }}"
                                        data-value="{{ $allVideos->max('duration') }}">
                                    </div> --}}
                                    <div class="range-values">
                                        <span>0s</span>
                                        <span id="durationMaxLabel">{{ $allVideos->max('duration') }}s+</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Resolution -->
                        {{-- <div class="accordion-item">
                            <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#resolutionD">
                                Resolution
                                <i class="fa-solid fa-angle-up"></i>
                            </button>
                            <div id="resolutionD" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox" id="hd_d"
                                            name="resolution[]" value="HD">
                                        <label class="form-check-label" for="hd_d">HD</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox" id="fullhd_d"
                                            name="resolution[]" value="Full HD">
                                        <label class="form-check-label" for="fullhd_d">Full HD</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox" id="4k_d"
                                            name="resolution[]" value="4K">
                                        <label class="form-check-label" for="4k_d">4K</label>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <!-- Frame Rate -->
                        <div class="accordion-item">
                            <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#fpsD">
                                Frame Rate
                                <i class="fa-solid fa-angle-up"></i>
                            </button>
                            <div id="fpsD" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox" id="24fps_d"
                                            name="frame_rate[]" value="24">
                                        <label class="form-check-label" for="24fps_d">24 fps</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox" id="30fps_d"
                                            name="frame_rate[]" value="30">
                                        <label class="form-check-label" for="30fps_d">30 fps</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox" id="60fps_d"
                                            name="frame_rate[]" value="60">
                                        <label class="form-check-label" for="60fps_d">60 fps</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox" id="120fps_d"
                                            name="frame_rate[]" value="120">
                                        <label class="form-check-label" for="120fps_d">120 fps</label>
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
                                        <input class="form-check-input filter-check" type="checkbox" id="landscape_d"
                                            name="orientation[]" value="landscape">
                                        <label class="form-check-label" for="landscape_d">Landscape</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox" id="portrait_d"
                                            name="orientation[]" value="portrait">
                                        <label class="form-check-label" for="portrait_d">Portrait</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox" id="square_d"
                                            name="orientation[]" value="square">
                                        <label class="form-check-label" for="square_d">Square</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox" id="vertical_d"
                                            name="orientation[]" value="vertical">
                                        <label class="form-check-label" for="vertical_d">Vertical</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- License -->
                        {{-- <div class="accordion-item">
                            <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#licenseD">
                                License Type
                                <i class="fa-solid fa-angle-up"></i>
                            </button>
                            <div id="licenseD" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-radio" type="radio"
                                            id="lic_standard_d" name="license" value="Standard">
                                        <label class="form-check-label" for="lic_standard_d">Standard</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-radio" type="radio"
                                            id="lic_premium_d" name="license" value="Premium">
                                        <label class="form-check-label" for="lic_premium_d">Premium</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-radio" type="radio"
                                            id="lic_editorial_d" name="license" value="Editorial">
                                        <label class="form-check-label" for="lic_editorial_d">Editorial</label>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <!-- Camera Movement -->
                        <div class="accordion-item">
                            <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#cameraD">
                                Camera Movement
                                <i class="fa-solid fa-angle-up"></i>
                            </button>
                            <div id="cameraD" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox"
                                            id="cam_static_d" name="camera_movement[]" value="Static">
                                        <label class="form-check-label" for="cam_static_d">Static</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox" id="cam_pan_d"
                                            name="camera_movement[]" value="Pan">
                                        <label class="form-check-label" for="cam_pan_d">Pan</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox" id="cam_tilt_d"
                                            name="camera_movement[]" value="Tilt">
                                        <label class="form-check-label" for="cam_tilt_d">Tilt</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox"
                                            id="cam_tracking_d" name="camera_movement[]" value="Tracking">
                                        <label class="form-check-label" for="cam_tracking_d">Tracking</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox"
                                            id="cam_aerial_d" name="camera_movement[]" value="Aerial">
                                        <label class="form-check-label" for="cam_aerial_d">Aerial</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox" id="cam_zoom_d"
                                            name="camera_movement[]" value="Zoom">
                                        <label class="form-check-label" for="cam_zoom_d">Zoom</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        {{-- CHANGE: name changed from "with_people" to "content_filters[]", added 5 more options --}}
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
                                        <label class="form-check-label" for="with_people_d">With People</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox"
                                            id="without_people_d" name="content_filters[]" value="without_people">
                                        <label class="form-check-label" for="without_people_d">Without People</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox"
                                            id="with_animals_d" name="content_filters[]" value="with_animals">
                                        <label class="form-check-label" for="with_animals_d">Animals</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox"
                                            id="outdoors_nature_d" name="content_filters[]" value="outdoors_nature">
                                        <label class="form-check-label" for="outdoors_nature_d">Outdoors /
                                            Nature</label>
                                    </div>
                                    <div class="filter-option form-check">
                                        <input class="form-check-input filter-check" type="checkbox" id="indoors_d"
                                            name="content_filters[]" value="indoors">
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

                    </div>
                </div>
            </div>


            {{-- ============================================================
                 RIGHT: TRENDING TAGS + SORT BAR + GRID
            ============================================================ --}}
            <div class="col-xl-9 col-lg-8 col-md-12">
                <div class="trending-video-data">
                    <div class="trending-data-tabs">
                        <div class="trending-video-title">
                            <p><i class="fa-solid fa-arrow-trend-up"></i> Trending :</p>
                        </div>
                        {{-- CHANGE: added class="trending-tag-btn" + data-tag="..." to every pill button
                                     added class="tag-close d-none" to xmark icon --}}
                        <ul class="nav nav-pills">
                            @foreach ($tags as $tag)
                                <li class="nav-item">
                                    <button type="button" class="nav-link trending-tag-btn"
                                        data-tag="{{ $tag }}">
                                        {{ $tag }}
                                        <i class="fa-solid fa-xmark tag-close d-none ms-1"></i>
                                    </button>
                                </li>
                            @endforeach

                        </ul>
                    </div>

                    <div class="trending-video-sort-items">
                        {{-- CHANGE: added id="mobileFilterToggle" to the funnel button --}}
                        <button class="filter-btn" id="mobileFilterToggle">
                            <i class="bi bi-funnel"></i>
                        </button>

                        {{-- MOBILE FILTER SIDEBAR
                             CHANGE: added id="mobileFilterSidebar" to the wrapper div
                                     added id="closeMobileFilter" to the close button
                                     added class="filter-check" / "filter-radio" + name/value to all inputs
                                     changed accordion collapse IDs to "M" suffix to avoid BS5 conflict --}}
                        <div class="filter-mobile filter-sidebar" id="mobileFilterSidebar">
                            <div class="filter-heading">
                                <div class="filter-title">Filters</div>
                                <button class="closebtn closefilter" id="closeMobileFilter">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <div class="accordion" id="filterAccordionMobile">

                                <!-- Price -->
                                <div class="accordion-item">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#priceM">
                                        Price Range
                                        <i class="fa-solid fa-angle-up"></i>
                                    </button>
                                    <div id="priceM" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <div class="d-flex gap-2 mb-2">
                                                <input type="number"
                                                    class="form-control form-control-sm price_min_mobile"
                                                    min="0" max="{{ $allVideos->max('price') }}"
                                                    value="0" placeholder="$0">
                                                <input type="number"
                                                    class="form-control form-control-sm price_max_mobile"
                                                    min="0" max="{{ $allVideos->max('price') }}"
                                                    value="{{ $allVideos->max('price') }}"
                                                    placeholder="${{ $allVideos->max('price') }}">
                                            </div>
                                            <input type="range" class="form-range priceRangeMax_mobile"
                                                min="0" max="{{ $allVideos->max('price') }}"
                                                value="{{ $allVideos->max('price') }}">
                                            <div class="range-values">
                                                <span>$0</span>
                                                <span
                                                    class="priceMaxLabel_mobile">${{ $allVideos->max('price') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Duration -->
                                <div class="accordion-item">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#durationM">
                                        Duration
                                        <i class="fa-solid fa-angle-up"></i>
                                    </button>
                                    <div id="durationM" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <div class="d-flex gap-2 mb-2">
                                                <input type="number"
                                                    class="form-control form-control-sm duration_min_mobile"
                                                    min="0" max="120" value="0" placeholder="0s">
                                                <input type="number"
                                                    class="form-control form-control-sm duration_max_mobile"
                                                    min="0" max="120" value="120" placeholder="120s">
                                            </div>
                                            <input type="range" class="form-range durationRangeMax_mobile"
                                                min="0" max="120" value="120">
                                            <div class="range-values">
                                                <span>0s</span>
                                                <span class="durationMaxLabel_mobile">120s+</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Resolution -->
                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#resolutionM">
                                        Resolution <i class="fa-solid fa-angle-up"></i>
                                    </button>
                                    <div id="resolutionM" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="hd_m" name="resolution[]" value="HD">
                                                <label class="form-check-label" for="hd_m">HD</label>
                                            </div>
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="fullhd_m" name="resolution[]" value="Full HD">
                                                <label class="form-check-label" for="fullhd_m">Full HD</label>
                                            </div>
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="4k_m" name="resolution[]" value="4K">
                                                <label class="form-check-label" for="4k_m">4K</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Frame Rate -->
                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#fpsM">
                                        Frame Rate <i class="fa-solid fa-angle-up"></i>
                                    </button>
                                    <div id="fpsM" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="24fps_m" name="frame_rate[]" value="24">
                                                <label class="form-check-label" for="24fps_m">24 fps</label>
                                            </div>
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="30fps_m" name="frame_rate[]" value="30">
                                                <label class="form-check-label" for="30fps_m">30 fps</label>
                                            </div>
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="60fps_m" name="frame_rate[]" value="60">
                                                <label class="form-check-label" for="60fps_m">60 fps</label>
                                            </div>
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="120fps_m" name="frame_rate[]" value="120">
                                                <label class="form-check-label" for="120fps_m">120 fps</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Orientation -->
                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#orientationM">
                                        Orientation <i class="fa-solid fa-angle-up"></i>
                                    </button>
                                    <div id="orientationM" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="landscape_m" name="orientation[]" value="landscape">
                                                <label class="form-check-label" for="landscape_m">Landscape</label>
                                            </div>
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="portrait_m" name="orientation[]" value="portrait">
                                                <label class="form-check-label" for="portrait_m">Portrait</label>
                                            </div>
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="square_m" name="orientation[]" value="square">
                                                <label class="form-check-label" for="square_m">Square</label>
                                            </div>
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="vertical_m" name="orientation[]" value="vertical">
                                                <label class="form-check-label" for="vertical_m">Vertical</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- License -->
                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#licenseM">
                                        License Type <i class="fa-solid fa-angle-up"></i>
                                    </button>
                                    <div id="licenseM" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-radio" type="radio"
                                                    id="lic_standard_m" name="license" value="Standard">
                                                <label class="form-check-label" for="lic_standard_m">Standard</label>
                                            </div>
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-radio" type="radio"
                                                    id="lic_premium_m" name="license" value="Premium">
                                                <label class="form-check-label" for="lic_premium_m">Premium</label>
                                            </div>
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-radio" type="radio"
                                                    id="lic_editorial_m" name="license" value="Editorial">
                                                <label class="form-check-label"
                                                    for="lic_editorial_m">Editorial</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Camera Movement -->
                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#cameraM">
                                        Camera Movement <i class="fa-solid fa-angle-up"></i>
                                    </button>
                                    <div id="cameraM" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="cam_static_m" name="camera_movement[]" value="Static">
                                                <label class="form-check-label" for="cam_static_m">Static</label>
                                            </div>
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="cam_pan_m" name="camera_movement[]" value="Pan">
                                                <label class="form-check-label" for="cam_pan_m">Pan</label>
                                            </div>
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="cam_tilt_m" name="camera_movement[]" value="Tilt">
                                                <label class="form-check-label" for="cam_tilt_m">Tilt</label>
                                            </div>
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="cam_tracking_m" name="camera_movement[]" value="Tracking">
                                                <label class="form-check-label" for="cam_tracking_m">Tracking</label>
                                            </div>
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="cam_aerial_m" name="camera_movement[]" value="Aerial">
                                                <label class="form-check-label" for="cam_aerial_m">Aerial</label>
                                            </div>
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="cam_zoom_m" name="camera_movement[]" value="Zoom">
                                                <label class="form-check-label" for="cam_zoom_m">Zoom</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#contentM">
                                        Content <i class="fa-solid fa-angle-up"></i>
                                    </button>
                                    <div id="contentM" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <div class="filter-option form-check">
                                                <input class="form-check-input filter-check" type="checkbox"
                                                    id="with_people_m" name="with_people" value="1">
                                                <label class="form-check-label" for="with_people_m">With
                                                    People</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{-- END MOBILE SIDEBAR --}}

                        {{-- Sort Dropdown
                             CHANGE: changed data-value to short keys: "relevant","newest","popular" etc.
                                     added class="sort-btn" to each dropdown-item button --}}
                        <div class="dropdown sort-dropdown">
                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <span id="selectedOption">Most Relevant</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <button class="dropdown-item sort-btn active" data-value="relevant">
                                        <i class="bi bi-check2 check-icon"></i> Most Relevant
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item sort-btn" data-value="newest">
                                        <i class="bi bi-check2 check-icon"></i> Newest First
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item sort-btn" data-value="popular">
                                        <i class="bi bi-check2 check-icon"></i> Most Popular
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item sort-btn" data-value="price_asc">
                                        <i class="bi bi-check2 check-icon"></i> Price: Low to High
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item sort-btn" data-value="price_desc">
                                        <i class="bi bi-check2 check-icon"></i> Price: High to Low
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item sort-btn" data-value="duration_asc">
                                        <i class="bi bi-check2 check-icon"></i> Duration: Shortest
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item sort-btn" data-value="duration_desc">
                                        <i class="bi bi-check2 check-icon"></i> Duration: Longest
                                    </button>
                                </li>
                            </ul>
                        </div>

                        {{-- CHANGE: added id="videoResultCount" result counter --}}
                        <span id="videoResultCount" class="text-muted ms-2"
                            style="font-size:13px;white-space:nowrap;">
                            {{ isset($allVideos) ? $allVideos->count() : 0 }} result(s)
                        </span>

                        {{-- View mode
                             CHANGE: added class="view-btn" + data-cols="3/2/1" to each button --}}
                        <div class="sort-product">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group sort-item-btn me-2" role="group" aria-label="First group">
                                    <button type="button" class="btn view-btn active" data-cols="3">
                                        <i class="bi bi-grid"></i>
                                    </button>
                                    <button type="button" class="btn view-btn" data-cols="2">
                                        <i class="bi bi-columns-gap"></i>
                                    </button>
                                    <button type="button" class="btn view-btn" data-cols="1">
                                        <i class="bi bi-list"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CHANGE: added active filter chips container --}}
                    <div id="activeFilterChips" class="d-flex flex-wrap gap-2 mt-2 mb-2"></div>

                    {{-- CHANGE: added AJAX loader --}}
                    <div id="videoLoader" class="text-center py-4 d-none">
                        <div class="spinner-border text-warning" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted mt-2" style="font-size:13px;">Loading videos…</p>
                    </div>

                    <div class="brows-main-section">
                        {{-- CHANGE: added id="videoGrid" to this div so JS can swap its contents --}}
                        <div class="product-listi-section" id="videoGrid">
                            @if (isset($allVideos) && $allVideos->count() > 0)
                                @foreach ($allVideos as $video)
                                    <div class="product-card">
                                        <a href="{{ route('product.detail', encrypt($video->id)) }}">
                                            <video class="product-img" width="100%" muted loop playsinline
                                                preload="auto"
                                                poster="{{ !empty($video->thumbnail_path) ? Storage::disk('s3')->url($video->thumbnail_path) : asset('assets/admin/images/demo_thumbnail.png') }}">
                                                <source
                                                    src="{{ $video->preview_path ? Storage::disk('s3')->url($video->preview_path) : ($video->mid_path ? Storage::disk('s3')->url($video->mid_path) : asset('assets/admin/images/demo_thumbnail.png')) }}"
                                                    type="video/mp4">
                                            </video>
                                        </a>
                                        <div class="p-3">
                                            <span
                                                class="badge badge-custom mb-2">{{ $video->category->category_name }}</span>
                                            <a href="{{ route('product.detail', encrypt($video->id)) }}">
                                                <h6 class="popular-detail-title">{{ $video->title }}</h6>
                                            </a>
                                            <div class="price-btn">
                                                <span class="price">${{ $video->price }}</span>
                                                {{-- <a href="{{ route('product.detail', encrypt($video->id)) }}"
                                                    class="btn btn-orange">Add</a> --}}
                                                <button type="button" {{ isInCart($video->id) ? 'disabled' : '' }}
                                                    class="btn add_to_cart btn-orange"
                                                    onclick="addToCart({{ $video->id }}, this)">
                                                    {{ isInCart($video->id) ? 'Added to Cart' : 'Add to Cart' }}</button>
                                            </div>
                                            <div class="product-two-btn">
                                                <button class="btn popular-icon-btn addFavorite"
                                                    data-Product-id="{{ $video->id }}"
                                                    data-type="{{ $video->type }}">
                                                    <i
                                                        class="bi {{ $video->is_favorite == 1 ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                                    {{ $video->is_favorite == 1 ? 'Saved' : 'Save' }}
                                                </button>
                                                <button class="btn popular-icon-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-share"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3" />
                                                    </svg>
                                                    Share
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12 text-center py-5" style="grid-column:1/-1;">
                                    <div class="alert alert-info">
                                        <h4 class="alert-heading">No Videos Available</h4>
                                        <p>There are currently no videos to display. Please check back later.</p>
                                        <hr>
                                        <p class="mb-0">You can browse our photo collection in the meantime.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

{{-- JS Config — inject BEFORE video-filter.js loads --}}
<script>
    window.VIDEO_FILTER_CONFIG = {
        ajaxUrl: '{{ route('videos') }}',
        csrfToken: '{{ csrf_token() }}'
    };
</script>

{{-- Styles --}}
<style>
    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #fff3e0;
        color: #e65c00;
        border: 1px solid #ffcc80;
        border-radius: 20px;
        padding: 3px 10px;
        font-size: 12px;
        cursor: pointer;
        transition: background .15s;
        user-select: none;
    }

    .filter-chip:hover {
        background: #ffe0b2;
    }

    .filter-chip i {
        font-size: 10px;
        pointer-events: none;
    }

    .trending-tag-btn.active {
        background-color: #ff6b00 !important;
        color: #fff !important;
        border-color: #ff6b00 !important;
    }

    .sort-btn .check-icon {
        visibility: hidden;
    }

    .sort-btn.active .check-icon {
        visibility: visible;
    }

    #videoGrid {
        transition: opacity .2s ease;
    }

    #videoGrid.loading {
        opacity: 0.35;
        pointer-events: none;
    }

    #videoGrid.cols-2 {
        grid-template-columns: repeat(2, 1fr) !important;
    }

    #videoGrid.cols-1 {
        display: flex !important;
        flex-direction: column !important;
    }

    #videoGrid.cols-1 .product-card {
        display: flex;
        flex-direction: row;
        flex-direction: column;
        gap: 16px;
    }

    #videoGrid.cols-1 .product-card .product-img {
        width: 100%;
        height: auto;
        aspect-ratio: 16 / 9;
        flex-shrink: 0;
        object-fit: cover;
        border-radius: 8px;
    }
</style>
