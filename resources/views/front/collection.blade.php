<section class="hero">
    <div class="container">
        <h1>Curated footage collections</h1>
        <p class="hero-text">Handpicked collections of premium stock footage for your next project</p>
        <!-- Search -->
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

<!-- all collection section -->
<section class="all-collection">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="heading">
                    <h2> Browse All <span class="yellow-headings">Collections</span></h2>
                </div>
            </div>
            <div class="col-12 text-center">
                <div class="collection-data">
                    @foreach ($CollectionList as $collection)
                        <a href="{{ route('all.media', ['collection_id' => encrypt($collection->id)]) }}">
                            <div class="collection-grid-card card-1">
                                <img src="{{ asset('uploads/images/collection/' . $collection['image']) }}"
                                    class="w-100" alt="" loading="lazy">
                                <h4>{{ $collection['name'] }}</h4>
                            </div>
                        </a>
                    @endforeach

                    {{-- <a href="#">
                    <div class="collection-grid-card card-2">
                        <img src="{{ asset('assets/front/img/alvan-nee-Dbng7f0lpmo-unsplash.jpg') }}" class="w-100"
                            alt="">
                        <h4>Lorem ipsum dolor sit.</h4>
                    </div>
                </a>
                <a href="#">
                    <div class="collection-grid-card card-3">
                        <img src="{{ asset('assets/front/img/amanda-sala-Xq_cvFHQlfw-unsplash.jpg') }}"
                            class="w-100" alt="">
                        <h4>Lorem ipsum dolor sit.</h4>
                    </div>
                </a>
                <a href="#">
                    <div class="collection-grid-card card-4">
                        <img src="{{ asset('assets/front/img/anita-austvika-7VTKbHqli9c-unsplash.jpg') }}"
                            class="w-100" alt="">
                        <h4>Lorem ipsum dolor sit.</h4>
                    </div>
                </a>
                <a href="#">
                    <div class="collection-grid-card card-5">
                        <img src="{{ asset('assets/front/img/brianna-parks-j6vp8NJPHOI-unsplash.jpg') }}"
                            class="w-100" alt="">
                        <h4>Lorem ipsum dolor sit.</h4>
                    </div>
                </a>
                <a href="#">
                    <div class="collection-grid-card card-1">
                        <img src="{{ asset('assets/front/img/danielle-suijkerbuijk-zeedbMYCbx8-unsplash.jpg') }}"
                            class="w-100" alt="">
                        <h4>Lorem ipsum dolor sit.</h4>
                    </div>
                </a>
                <a href="#">
                    <div class="collection-grid-card card-2">
                        <img src="{{ asset('assets/front/img/francesco-ungaro-97-blyf3IxE-unsplash.jpg') }}"
                            class="w-100" alt="">
                        <h4>Lorem ipsum dolor sit.</h4>
                    </div>
                </a>
                <a href="#">
                    <div class="collection-grid-card card-3">
                        <img src="{{ asset('assets/front/img/de-an-sun-s7avhwAg060-unsplash.jpg') }}" class="w-100"
                            alt="">
                        <h4>Lorem ipsum dolor sit.</h4>
                    </div>
                </a>
                <a href="#">
                    <div class="collection-grid-card card-4">
                        <img src="{{ asset('assets/front/img/willian-justen-de-vasconcellos-yBGCtSnKruE-unsplash.jpg') }} "
                            class="w-100" alt="">
                        <h4>Lorem ipsum dolor sit.</h4>
                    </div>
                </a>
                <a href="#">
                    <div class="collection-grid-card card-5">
                        <img src="{{ asset('assets/front/img/tim-mossholder-FYeciZDMwpY-unsplash.jpg') }}"
                            class="w-100" alt="">
                        <h4>Lorem ipsum dolor sit.</h4>
                    </div>
                </a>
                <a href="#">
                    <div class="collection-grid-card card-1">
                        <img src="{{ asset('assets/front/img/peter-thomas-1V67-2eFamI-unsplash.jpg') }}"
                            class="w-100" alt="">
                        <h4>Lorem ipsum dolor sit.</h4>
                    </div>
                </a>
                <a href="#">
                    <div class="collection-grid-card card-2">
                        <img src="{{ asset('assets/front/img/lawrence-krowdeed-_zVJTz7v75o-unsplash.jpg') }}"
                            class="w-100" alt="">
                        <h4>Lorem ipsum dolor sit.</h4>
                    </div>
                </a>
                <a href="#">
                    <div class="collection-grid-card card-3">
                        <img src="{{ asset('assets/front/img/jivan-garcha-eqxjqXER9NY-unsplash.jpg') }}"
                            class="w-100" alt="">
                        <h4>Lorem ipsum dolor sit.</h4>
                    </div>
                </a>
                <a href="#">
                    <div class="collection-grid-card card-4">
                        <img src="{{ asset('assets/front/img/land-o-lakes-inc-pazs-Hi5mf8-unsplash.jpg') }}"
                            class="w-100" alt="">
                        <h4>Lorem ipsum dolor sit.</h4>
                    </div>
                </a>
                <a href="#">
                    <div class="collection-grid-card card-5">
                        <img src="{{ asset('assets/front/img/danielle-suijkerbuijk-wUc2nzHiI1I-unsplash.jpg') }}"
                            class="w-100" alt="">
                        <h4>Lorem ipsum dolor sit.</h4>
                    </div>
                </a> --}}
                </div>
            </div>
        </div>
    </div>
</section>
