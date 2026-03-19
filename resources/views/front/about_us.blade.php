<main>
    <section class="about_section">
        @if(!empty($about_us))
            <div class="about-header">
                <div class="enterprise-badge">✦{{ $about_us->heading }}</div>
                <h2 class="enterprise-title"> <span class="yellow-headings"> {{ $about_us->title }} </span></h2>
                <p class="enterprise-subtitle">{{  $about_us->sub_title  }}</p>
            </div>

            <!-- Story -->
            <div class="story-wrap">
                <div class="story-box">
                    <div class="story-image">
                        <img src="{{ asset('uploads/images/about_us/' . $about_us->image) }}" alt="About Us Image"
                            style="max-width: 100%; height: auto; border-radius: 8px;">
                        <!-- <div class="story-image-overlay"> -->
                        <!-- <div class="story-image-badge">
                                    <div class="num">10K+</div>
                                    <div class="lbl">Premium Clips</div>
                                </div> -->
                        <!-- </div> -->
                    </div>
                    <div class="story-content">
                        <h2>{{ $about_us->heading }}</h2>
                        <p>{!! $about_us->description !!}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Values -->
        @if($blogs->isNotEmpty())
            <div class="values-wrap">
                <div class="heading text-center">
                    <h2>Our <span class="yellow-headings">Blogs</span></h2>
                </div>
                <div class="values-grid">
                    @foreach ($blogs as $blog)


                        <div class="card">
                            <img class="card-img" src="{{ asset('uploads/images/blogs/' . $blog->image) }}" alt="Quality">
                            <div class="card-body text-start">

                                <div class="d-flex align-items-center gap-3 text-muted small flex-wrap mb-4">

                                    <!-- Publish Date -->
                                    <div class="d-flex align-items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-calendar" viewBox="0 0 16 16">
                                            <path
                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($blog->publish_date)->format('F d, Y') }}</span>
                                    </div>

                                    @isset($blog->author_name)
                                        <!-- Author -->
                                        <div class="d-flex align-items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-3.33 0-10 1.67-10 5v1h20v-1c0-3.33-6.67-5-10-5z" />
                                            </svg>
                                            <span>{{ $blog->author_name }}</span>
                                        </div>
                                    @endisset

                                </div> <!-- <div class="card-icon">
                                            <svg viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                            </svg>
                                        </div> -->
                                <h3>{{ $blog->title }}</h3>
                                <p> {{ \Illuminate\Support\Str::limit(strip_tags($blog->description), 100) }}</p>

                                <a href="{{ route('blog_detail', ['id' => encrypt($blog->id)]) }}" class="brows-btn">
                                    Read Article
                                    <i class="bi bi-arrow-right-short"></i>
                                </a>
                            </div>
                        </div>

                    @endforeach

                    <!-- <div class="card">
                            <img class="card-img" src="https://images.unsplash.com/photo-1485846234645-a62644f84728?w=500&q=80"
                                alt="Passion">
                            <div class="card-body">
                                <div class="card-icon">
                                    <svg viewBox="0 0 24 24">
                                        <path
                                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                    </svg>
                                </div>
                                <h3>Passion Driven</h3>
                                <p>We tell stories with genuine love and care for the craft.</p>
                            </div>
                        </div>

                        <div class="card">
                            <img class="card-img" src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&q=80"
                                alt="Global">
                            <div class="card-body">
                                <div class="card-icon">
                                    <svg viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="2" y1="12" x2="22" y2="12" />
                                        <path
                                            d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                                    </svg>
                                </div>
                                <h3>Global Reach</h3>
                                <p>Serving creators worldwide with footage from across the globe.</p>
                            </div>
                        </div>

                        <div class="card">
                            <img class="card-img" src="https://images.unsplash.com/photo-1485846234645-a62644f84728?w=500&q=80"
                                alt="Passion">
                            <div class="card-body">
                                <div class="card-icon">
                                    <svg viewBox="0 0 24 24">
                                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                                    </svg>
                                </div>
                                <h3>Excellence</h3>
                                <p>Delivering the highest standards in every asset we produce.</p>
                            </div>
                        </div> -->

                </div>
            </div>
        @endif

        <!-- CTA -->
        <div class="cta-wrap">
            <div class="container">
                <div class="cta">
                    <div class="cta-left">
                        <h2>Ready to elevate your projects?</h2>
                        <p>Explore our collection of premium cinematic footage and bring your vision to life.</p>
                    </div>
                    <a href="{{ route('all_photos') }}" class="btn btn-orange">
                        Browse Footage
                        <i class="ms-2 bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>