<section class="popular_content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="heading mb-md-5">
                    <h3><span class="yellow-headings">Wishlist </span>
                    </h3>
                </div>
            </div>
            <div class="popular_tabs">

                <!-- Tab Content -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="selected">
                        <div class="row g-3">
                            {{-- {{ dd($product) }} --}}
                            @foreach ($products as $pro)

                                <div class=" col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 ">
                                    <a href="{{ route('product.detail', encrypt($pro->id)) }}">
                                        <div class="product-card">
                                            @if ($pro->type == '0')
                                                <img src="{{ asset('uploads/images/low/' . $pro->low_path) }}"
                                                    class="product-img" alt="">
                                            @else
                                                <img src="{{ asset('uploads/videos/thumbnails/' . $pro->thumbnail_path) }}"
                                                    class="product-img" alt="">
                                            @endif
                                            <div class="p-3">
                                                <span
                                                    class="badge badge-custom mb-2">{{ $pro->category->category_name }}</span>
                                                <h6 class="popular-detail-title">{{ $pro->name }}
                                                </h6>

                                                <div class="price-btn">
                                                    <span class="price">${{ $pro->price }}</span>
                                                    <button class="btn  btn-orange">Add</button>

                                                </div>
                                                <a class="btn  btn-orange removeFavorite mt-4"
                                                    data-id="{{ encrypt($pro->favorites[0]->id) }}">Remove</a>


                                            </div>
                                        </div>
                                    </a>

                                </div>
                            @endforeach
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center">
                <a href="#" class="brows-btn">brows all content <svg xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                    </svg></a>
            </div>
        </div>
    </div>
</section>