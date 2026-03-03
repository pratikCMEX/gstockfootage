<section class="hero">
    <div class="container">
        <h1>Curated footage collections</h1>
        <p class="hero-text">Handpicked collections of premium stock footage for your next project</p>
        <!-- Search -->
        <div class="search-wrapper">
            <div class="search-box shadow-lg">

                <!-- Dropdown -->
                <div class="collection">
                    <p> <i class="fa-regular fa-folder"></i> Collections</p>
                </div>

                <div class="inp-search">
                    <!-- Input -->
                    <input type="text" placeholder="Start your next project" />

                    <!-- Search Button -->
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
                        <a href="#">
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
