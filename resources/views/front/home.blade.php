<section class="hero">
    <div class="container">
        <h1>Visuals with purpose.</h1>
        <!-- Tabs -->
        <div class="hero-tabs">
            <a href="" class="active"><i class="bi bi-camera-video"></i> Videos</a>
            <a href=""><i class="bi bi-image"></i> Photos</a>
            {{-- <button><i class="bi bi-palette"></i> Artwork</button> --}}
        </div>
        <!-- Search -->
        <div class="search-wrapper">
            <div class="search-box shadow-lg">

                <!-- Dropdown -->
                <div class="dropdown">
                    <button class="btn dropdown-toggle custom-dropdown" data-bs-toggle="dropdown">
                        <i class="bi bi-grid"></i>
                        All content
                    </button>

                    <ul class="dropdown-menu custom-menu">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-grid"></i> All
                                content</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-camera-video"></i>
                                Videos</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-image"></i> Photos</a>
                        </li>
                        {{-- <li><a class="dropdown-item" href="#"><i class="bi bi-palette"></i> Artwork</a>
                        </li> --}}
                    </ul>
                </div>

                <div class="inp-search">
                    <!-- Input -->
                    <input type="text" class="home_search" placeholder="Start your next project" />

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

        <!-- Trending -->
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
<section class="endless-posibilities">
    <div class="container">
        <div class="row g-3">
            <div class="col-12">
                <div class="posibility-heading heading">
                    <h2>One Brand <span class="yellow-headings">Endless Possibilities.</span></h2>
                </div>
            </div>
            @foreach ($CollectionList as $item)
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="brand-posibility">
                        <div class="posibility-img">
                            <img width="100%" height="100%"
                                src="{{ asset('uploads/images/collection/' . $item->image) }}" alt="">
                        </div>
                        <div class="posibilty-title">
                            <h3>{{ $item->name }}</h3>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<section class="create-fingertips">
    <div class="container">
        <div class="row g-4 d-flex align-items-center mb-4">
            <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-xs-6 col-12">
                <div class="fingertips-heading heading ">
                    <h2 class="m-0">
                        Content at <span class="yellow-headings"> Your Fingertips</span>
                    </h2>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-6 col-12 text-sm-end text-start">
                <div class="heading-btn">
                    <a href="javascript:void(0);" class="btn btn-orange">
                        See Pricing
                    </a>
                </div>
            </div>
        </div>
        <div class="row g-3">
            @foreach ($categoryList as $category)
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="javascript::void(0);">
                        <div class="fingertips-content">
                            <div class="fingertips-img">
                                <img height="100%" width="100%"
                                    src="{{ asset('uploads/images/category/' . $category->category_image) }}"
                                    alt="">
                            </div>
                            <h4>{{ $category->category_name }} <i class="bi bi-arrow-right"></i></h4>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
<section class="popular_content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="heading mb-md-5">
                    <h2>Explore Popular and Curated <span class="yellow-headings"> Visual Content </span>
                    </h2>
                </div>
            </div>
            <div class="popular_tabs">
                <ul class="nav custom-tabs mb-3">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#selected">
                            Selected content
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#popular">
                            The most popular
                        </button>
                    </li>
                </ul>

                <!-- Filter Buttons -->
                <div class="popular-filter-pills filter-pills d-flex flex-wrap gap-2 mb-4">
                    <a href="#" class="btn btn-sm"><i class="bi bi-search"></i> Jerusalem views</a>
                    <a href="#" class="btn btn-sm"><i class="bi bi-search"></i> Aerial footage</a>
                    <a href="#" class="btn btn-sm"><i class="bi bi-search"></i> Golden hour</a>
                    <a href="#" class="btn btn-sm"><i class="bi bi-search"></i> Ancient sites</a>
                    <a href="#" class="btn btn-sm"><i class="bi bi-search"></i> Holy Land nature</a>
                    <a href="#" class="btn btn-sm"><i class="bi bi-search"></i> Biblical locations</a>
                    <a href="#" class="btn btn-sm"><i class="bi bi-search"></i> Desert landscapes</a>
                </div>

                <!-- Tab Content -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="selected">
                        <div class="row g-3">
                            {{-- {{ dd($product) }} --}}
                            @foreach ($product as $pro)
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <a href="{{ route('product.detail', encrypt($pro->id)) }}">
                                        <div class="product-card">
                                            @if ($pro->type == 'image')
                                                <img src="{{ Storage::disk('s3')->url($pro->low_path) }}"
                                                    class="product-img" alt="">
                                            @else
                                                @if ($pro->thumbnail_path == null)
                                                    <img src="{{ asset('assets/admin/images/demo_thumbnail.png') }}"
                                                        class="product-img" alt="">
                                                @else
                                                    <img src="{{ Storage::disk('s3')->url($pro->thumbnail_path) }}"
                                                        class="product-img" alt="">
                                                @endif
                                            @endif
                                            <div class="p-3">

                                                <span
                                                    class="badge badge-custom mb-2">{{ $pro->category->category_name ?? '' }}</span>

                                                <h6 class="popular-detail-title">{{ $pro->name }}
                                                </h6>


                                                <div class="price-btn">
                                                    <span class="price">${{ $pro->price }}</span>
                                                    <button class="btn  btn-orange">Add</button>
                                                </div>
                                                <div class="product-two-btn">
                                                    <button type="button" data-Product-id="{{ $pro->id }}"
                                                        data-type="{{ $pro->type }}"
                                                        class="btn  popular-icon-btn addFavorite">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-heart"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                                        </svg>
                                                        Save</button>


                                                    <button class="btn  popular-icon-btn"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-share"
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
                            @endforeach

                            {{-- <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                <a href="product-detail.html">
                                    <div class="product-card">

                                        <img src="{{ asset('assets/front/img/posibility_3.webp') }}" class="product-img"
                            alt="Punjabi Dum Aloo">

                            <div class="p-3">

                                <span class="badge badge-custom mb-2">Food</span>

                                <h6 class="popular-detail-title">Punjabi-Dum-Aloo</h6>


                                <div class="price-btn">
                                    <span class="price">$149</span>
                                    <button class="btn  btn-orange">Add</button>
                                </div>
                                <div class="product-two-btn">
                                    <button class="btn  popular-icon-btn"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                            <path
                                                d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                        </svg>
                                        Save</button>
                                    <button class="btn  popular-icon-btn"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                            <path
                                                d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3" />
                                        </svg>
                                        Share</button>
                                </div>

                            </div>
                        </div>
                        </a>

                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                        <a href="product-detail.html">
                            <div class="product-card">

                                <img src="{{ asset('assets/front/img/1770123205271-Malai-Chicken.jpg') }}"
                                    class="product-img" alt="">
                                <div class="p-3">

                                    <span class="badge badge-custom mb-2">Food</span>

                                    <h6 class="popular-detail-title">Malai Chicken</h6>


                                    <div class="price-btn">
                                        <span class="price">$149</span>
                                        <button class="btn  btn-orange">Add</button>
                                    </div>
                                    <div class="product-two-btn">
                                        <button class="btn  popular-icon-btn"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                                <path
                                                    d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                            </svg>
                                            Save</button>
                                        <button class="btn  popular-icon-btn"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                                <path
                                                    d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3" />
                                            </svg>
                                            Share</button>
                                    </div>

                                </div>
                            </div>
                        </a>

                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                        <a href="product-detail.html">
                            <div class="product-card">

                                <img src="{{ asset('assets/front/img/1770122985007-diamond_logo.png') }}"
                                    class="product-img" alt="">

                                <div class="p-3">

                                    <span class="badge badge-custom mb-2">Diamond</span>

                                    <h6 class="popular-detail-title">Golden Diamond</h6>


                                    <div class="price-btn">
                                        <span class="price">$149</span>
                                        <button class="btn  btn-orange">Add</button>
                                    </div>
                                    <div class="product-two-btn">
                                        <button class="btn  popular-icon-btn"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                                <path
                                                    d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                            </svg>
                                            Save</button>
                                        <button class="btn  popular-icon-btn"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                                <path
                                                    d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3" />
                                            </svg>
                                            Share</button>
                                    </div>

                                </div>
                            </div>
                        </a>

                    </div> --}}
                        </div>
                    </div>

                    <div class="tab-pane fade" id="popular">
                        <div class="row g-3">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                <a href="javascript:void(0);">
                                    <div class="product-card">

                                        <img src="{{ asset('assets/front/img/artist-at-work-stockcake.webp') }}"
                                            class="product-img" alt="">

                                        <div class="p-3">

                                            <span class="badge badge-custom mb-2">Art</span>

                                            <h6 class="popular-detail-title">Art & Craft</h6>


                                            <div class="price-btn">
                                                <span class="price">$149</span>
                                                <button class="btn  btn-orange">Add</button>
                                            </div>
                                            <div class="product-two-btn">
                                                <button class="btn  popular-icon-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-heart"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                                    </svg>
                                                    Save</button>
                                                <button class="btn  popular-icon-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-share"
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
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                <a href="javascript:void(0);">
                                    <div class="product-card">

                                        <img src="{{ asset('assets/front/img/the-future-of-artificial-intelligence.jpg') }}"
                                            class="product-img" alt="ai future">

                                        <div class="p-3">

                                            <span class="badge badge-custom mb-2">AI</span>

                                            <h6 class="popular-detail-title">AI Future</h6>


                                            <div class="price-btn">
                                                <span class="price">$149</span>
                                                <button class="btn  btn-orange">Add</button>
                                            </div>
                                            <div class="product-two-btn">
                                                <button class="btn  popular-icon-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-heart"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                                    </svg>
                                                    Save</button>
                                                <button class="btn  popular-icon-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-share"
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
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                <a href="javascript:void(0);">
                                    <div class="product-card">

                                        <img src="{{ asset('assets/front/img/riverss.jpg') }}" class="product-img"
                                            alt="">
                                        <div class="p-3">

                                            <span class="badge badge-custom mb-2">River</span>

                                            <h6 class="popular-detail-title">Rivers</h6>


                                            <div class="price-btn">
                                                <span class="price">$149</span>
                                                <button class="btn  btn-orange">Add</button>
                                            </div>
                                            <div class="product-two-btn">
                                                <button class="btn  popular-icon-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-heart"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                                    </svg>
                                                    Save</button>
                                                <button class="btn  popular-icon-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-share"
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
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                <a href="javascript:void(0);">
                                    <div class="product-card">

                                        <img src="{{ asset('assets/front/img/foods.jpeg') }}" class="product-img"
                                            alt="">

                                        <div class="p-3">

                                            <span class="badge badge-custom mb-2">Food</span>

                                            <h6 class="popular-detail-title">Foods</h6>


                                            <div class="price-btn">
                                                <span class="price">$149</span>
                                                <button class="btn  btn-orange">Add</button>
                                            </div>
                                            <div class="product-two-btn">
                                                <button class="btn  popular-icon-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-heart"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                                    </svg>
                                                    Save</button>
                                                <button class="btn  popular-icon-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-share"
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
            </div>
            <div class="col-12 text-center">
                <a href="#" class="brows-btn">brows all content <svg xmlns="http://www.w3.org/2000/svg"
                        width="16" height="16" fill="currentColor" class="bi bi-chevron-right"
                        viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                    </svg></a>
            </div>
        </div>
    </div>
</section>
<section class="help_section hero-wrapper d-flex align-items-center justify-content-center">
    <div class="container text-center">
        <div class="brand-area mb-4">
            <img src="{{ asset('assets/front/img/helper-chicken-D5n0gnPB.png') }}" alt="Mascot"
                class="floating-icon">
            <h2 class="help-heading">How can we help you <span class="text-gradient">get what you
                    want?</span></h2>
        </div>

        <div class="help-filter-btn filter-pills d-flex justify-content-center flex-wrap gap-2 mb-4">
            <button class="btn btn-filter active"><i class="bi bi-grid-fill"></i> All</button>
            <button class="btn btn-filter"><i class="bi bi-camera-video"></i> Videos</button>
            <button class="btn btn-filter"><i class="bi bi-camera"></i> Photos</button>
            <button class="btn btn-filter"><i class="bi bi-palette"></i> Artwork</button>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="search-container shadow-lg">
                    <input type="text" class="form-control main-input"
                        placeholder="Search for footage, photos, or artwork...">
                    <button class="btn btn-search">
                        <i class="bi bi-search "></i> <span>Search</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</section>
<section class="store_slider-section">
    <div class="container">
        <div class="store-section">

            <div class="store-header">
                <div class="store-title heading">
                    <i class="bi bi-book"></i>
                    <h2 class="mb-0"> Visit Our Vision of The <span class="yellow-headings">Bible Store
                        </span>
                    </h2>
                </div>

                <div class="store-actions">
                    <a href="#">Shop the Collection <i class="bi bi-box-arrow-up-right"></i></a>
                </div>
            </div>

            <div class="swiper mySwiper store-swiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <a href="">
                            <div class="store-product-card">
                                <div class="store-product-image">
                                    <img src="{{ asset('assets/front/img/P1-copy-2.webp') }}">
                                </div>
                                <h4 class="store-product-title">The Four Gospels (10 Inch)</h4>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="">
                            <div class="store-product-card">
                                <div class="store-product-image">
                                    <img src="{{ asset('assets/front/img/tanakh.webp') }}">
                                </div>
                                <h4 class="store-product-title">The Four Gospels (7 Inch)</h4>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="">
                            <div class="store-product-card">
                                <div class="store-product-image">
                                    <img src="{{ asset('assets/front/img/digital-bible-2-_2.webp') }}">
                                </div>
                                <h4 class="store-product-title">The Holy Land Digital Tablet</h4>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="">
                            <div class="store-product-card">
                                <div class="store-product-image">
                                    <img src="{{ asset('assets/front/img/7-Inch---Product-Photos-2.webp') }}">
                                </div>
                                <h4 class="store-product-title">Visions of Israel - Coffee Table Book</h4>
                            </div>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="">
                            <div class="store-product-card">
                                <div class="store-product-image">
                                    <img src="{{ asset('assets/front/img/travel.webp') }}">
                                </div>
                                <h4 class="store-product-title">The Four Gospels (10 Inch)</h4>
                            </div>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="">
                            <div class="store-product-card">
                                <div class="store-product-image">
                                    <img src="{{ asset('assets/front/img/book_1.webp') }}">
                                </div>
                                <h4 class="store-product-title">The Four Gospels (10 Inch)</h4>
                            </div>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <div class="view-all-card">
                            <i class="bi bi-box-arrow-up-right"></i>
                            <div>View All Products</div>
                        </div>
                    </div>


                </div>

                <div class="arrow-left arrow"><i class="bi bi-chevron-left"></i></div>
                <div class="arrow-right arrow"><i class="bi bi-chevron-right"></i></div>

            </div>

        </div>
    </div>
</section>
<section class="enterprise-section">
    <div class="container">

        <div class="enterprise-badge">
            Enterprise Solutions
        </div>

        <h2 class="enterprise-title">
            Built for Studios & Production Companies
        </h2>

        <p class="enterprise-subtitle">
            Access our complete media library with custom licensing, bulk downloads, and dedicated support for
            your production needs
        </p>

        <div class="enterprise-card">
            <div class="row g-3 align-items-center">

                <div class="col-xl-6 col-lg-12 text-start">
                    <h5>Trusted by Major Studios & Networks</h5>
                    <p>
                        Join leading production teams who rely on our curated footage.
                        Receive a full catalog export within 24 hours for fast decision-making.
                    </p>
                </div>

                <div class="col-xl-6 col-lg-12   enterprise-actions">
                    <div class="enterprise-btns">
                        <a href="#" class="btn  btn-orange ">
                            Request Enterprise Quote <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="#" class="btn btn-outline-custom-enterprise btn-all-dark">
                            Learn More
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div class="enterprise-footnote">
            Perfect for documentaries, TV productions, commercials, and cinematic projects.
        </div>

    </div>
</section>
<section class="trusted-section">

    <div class="container ">
        <div class="row g-4 align-items-center">

            <div class="col-lg-5">
                <div class="heading">
                    <h2 class="section-title ">
                        Trusted by <span class="yellow-headings">Creators Worldwide</span>
                    </h2>
                </div>

                <p class="trusted-subtitle">
                    Premium stock footage designed for studios, filmmakers, and creative professionals.
                </p>

                <div class="feature-item">
                    <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-award h-5 w-5 text-primary">
                            <path
                                d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
                            </path>
                            <circle cx="12" cy="8" r="6"></circle>
                        </svg></div>
                    <div>
                        <h6>Professional 4K & 8K Quality</h6>
                        <p>Cinematic-grade footage captured by experts</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-shield h-5 w-5 text-primary">
                            <path
                                d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                            </path>
                        </svg></div>
                    <div>
                        <h6>Royalty-Free Licensing</h6>
                        <p>Clear & flexible licensing for any project</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-download h-5 w-5 text-primary">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" x2="12" y1="15" y2="3"></line>
                        </svg></div>
                    <div>
                        <h6>Instant Downloads</h6>
                        <p>Get your files immediately after purchase</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-clock h-5 w-5 text-primary">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg></div>
                    <div>
                        <h6>Authentic Locations</h6>
                        <p>Real footage from iconic destinations</p>
                    </div>
                </div>

                <div class="mt-4 trusted-btn">
                    <button class="btn btn-orange me-lg-2">
                        View Licensing Options
                    </button>
                    <button class="btn trusted-contact-btn btn-hover-dark btn-all-dark">
                        Contact Us
                    </button>
                </div>
            </div>

            <div class="col-lg-7">
                @if ($testimonials->isNotEmpty())
                    @foreach ($testimonials as $testimonial)
                        <div class="testimonial-card">
                            <div class="quote-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-quote h-8 w-8 text-primary/30 ">
                                    <path
                                        d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                                    </path>
                                    <path
                                        d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                                    </path>
                                </svg></div>
                            <div class="testimonial-text">
                                {{ $testimonial->message }}
                            </div>
                            @php
                                $name = trim($testimonial->name);
                                $words = explode(' ', $name);
                            @endphp
                            <div class="testimonial-card">
                                <div class="quote-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-quote h-8 w-8 text-primary/30 ">
                                        <path
                                            d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                                        </path>
                                        <path
                                            d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                                        </path>
                                    </svg></div>
                                <div class="testimonial-text">
                                    {{ $testimonial->message }}
                                </div>
                                @php
                                    $name = trim($testimonial->name);
                                    $words = explode(' ', $name);

                                    $initials = '';

                                    if (count($words) >= 2) {
                                        $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                                    } else {
                                        $initials = strtoupper(substr($name, 0, 1));
                                    }
                                @endphp
                                <div class="testimonial-user">
                                    <div class="avatar">{{ $initials }}</div>
                                    <div class="user-info">
                                        <strong>{{ $testimonial->name }}</strong>
                                        <small>{{ $testimonial->designation }}</small>
                                    </div>
                    @endforeach
                @endif
            </div>

            <!-- <div class="testimonial-card">
                    <div class="quote-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-quote h-8 w-8 text-primary/30 ">
                            <path
                                d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                            </path>
                            <path
                                d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z">
                            </path>
                        </svg></div>
                    <div class="testimonial-text">
                        Incredible selection of Holy Land footage. Exactly what we needed for our production.
                    </div>

                    <div class="testimonial-user">
                        <div class="avatar">D</div>
                        <div class="user-info">
                            <strong>David K.</strong>
                            <small>Creative Director</small>
                        </div>
                    </div>
                </div> -->

        </div>
    </div>

    </div>
    </div>
</section>
