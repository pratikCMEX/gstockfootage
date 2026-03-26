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
            <button type="button" class="btn image-search-btn shadow d-none" data-bs-toggle="modal"
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

                        <form action="{{ route('photos.searchByImage') }}" method="POST" enctype="multipart/form-data">
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
                                <svg id="uploadIcon" xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
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
            {{-- {{ dd($trendingTags) }} --}}
            <div class="trending">
                Trending:
                @foreach ($trendingTags as $tags)
                    <a href="{{ $tags['type'] === 'image' ? route('all_photos', ['q' => $tags['tag'], 'type' => $tags['type']]) : route('videos', ['q' => $tags['tag'], 'type' => $tags['type']]) }}"
                        class="me-2">{{ $tags['tag'] }} ,</a>
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
                        Videos that are<span class="yellow-headings">
                            @if (!empty($selectedCollection))
                                from {{ $selectedCollection->name }} Collection
                            @elseif(!empty($selectedCategory))
                                from {{ $selectedCategory->category_name }} Category
                            @else
                                trending today
                            @endif
                        </span>
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
                            @foreach ($trendingTags as $tag)
                                <li class="nav-item">
                                    <button type="button" class="nav-link trending-tag-btn"
                                        data-tag="{{ $tag['tag'] }}">
                                        {{ $tag['tag'] }}
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
                            {{-- <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <span id="selectedOption">Most Relevant</span>
                            </button> --}}
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
                                                <div class="share-wrapper position-relative d-inline-block">
                                                    <button type="button"
                                                        data-url="{{ route('product.detail', encrypt($video->id)) }}"
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
                                                            data-copy-url="{{ route('product.detail', encrypt($video->id)) }}"
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
