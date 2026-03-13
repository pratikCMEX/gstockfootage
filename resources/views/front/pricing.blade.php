<main>
    <section class="pricing-section">
        @if ($priceList->isNotEmpty())
            <div class="container">
                <span class="section-badge">Pricing</span>
                <div class="heading">
                    <h2 class="mt-3">Simple, Transparent <span class="yellow-headings">Pricing</span> </h2>
                    <p>Choose a plan that fits your workflow and business scale.</p>
                    <h3>Per Clip License</h3>
                </div>
                <div class="row g-4 justify-content-md-center">

                    @foreach ($priceList as $pricing)
                        <div class="col-lg-4 col-md-6 {{ $pricing->most_popular == '1' ? 'popular' : '' }}">

                            <div class="pricing-card">
                                @if ($pricing->most_popular == '1')
                                    <div class="popular-badge">Popular</div>
                                @endif
                                <h5>{{ $pricing->name }}</h5>
                                <p class="text-secondary">{{ $pricing->title }}</p>
                                <div class="price">${{ $pricing->price }} <span>/ clip</span></div>
                                <p class="text-secondary price-text">Up to {{ $pricing->quality }}</p>

                                <!-- <button class="btn btn-orange w-100">Get Started</button> -->
                                <form action="{{ route('license.checkout') }}" method="POST">
                                    @csrf

                                    <input type="hidden" name="license_id" value="{{ $pricing->id }}">
                                    <input type="hidden" name="price" value="{{ $pricing->plan_price }}">

                                    @if ($pricing->is_purchased == '1')
                                        <label class="btn btn-orange w-100">
                                            Purchased
                                        </label>
                                    @else
                                        <button type="submit" class="btn btn-orange w-100">
                                            Get Started
                                        </button>
                                    @endif

                                </form>
                                @php
                                    // $descriptions=explode(',',$pricing->description);
                                    $descriptions = array_filter(
                                        array_map('trim', explode(',', $pricing->description)),
                                    );
                                @endphp
                                <ul class="features">
                                    @foreach ($descriptions as $detail)
                                        <li>{{ $detail }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- <div class="col-lg-4 col-md-6">
                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="pricing-card popular">
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="popular-badge">Popular</div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <h5>HD License</h5>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <p class="text-secondary">Ideal for professional projects</p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="price">$49 <span>/ clip</span></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <p class="text-secondary price-text">Up to 1080p</p>

                                                                                                                                                                                                                                                                                                                                                                                                                                                        <button class="btn btn-orange w-100">Get Started</button>

                                                                                                                                                                                                                                                                                                                                                                                                                                                        <ul class="features">
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>High Definition (1080p)</li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>All SD License Features</li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>TV & Broadcasting Rights</li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>Client Projects</li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>Priority Support</li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        </ul>

                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="col-lg-4 col-md-6">
                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="pricing-card">
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <h5>4K License</h5>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <p class="text-secondary">Ultimate quality for cinema</p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="price">$99 <span>/ clip</span></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <p class="text-secondary price-text">Up to 4K</p>


                                                                                                                                                                                                                                                                                                                                                                                                                                                        <button class="btn btn-orange w-100">Get Started</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <ul class="features">
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>Ultra HD 4K (2160p)</li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>All HD License Features</li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>Cinema & Film Production</li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>Unlimited Projects</li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>Premium Support</li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <li>RAW Files Available</li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        </ul>

                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                </div> -->
                    @endforeach
                </div>
            </div>
        @else
            <div class="heading">
                <h3> <span class="yellow-headings">No License plans available at the moment.</span></h3>

            </div>
        @endif
    </section>

    <section class="subscription_plan">
        @if ($subscriptionPlanList->isNotEmpty())
            <div class="container">

                <div class="heading text-center">
                    <h2>Subscription<span class="yellow-headings"> Plans</span> </h2>
                    <p>Get more clips for less with our subscription options.</p>
                </div>
                <div class="subscription-content">
                    <div class="row g-4 justify-content-md-center">

                        @foreach ($subscriptionPlanList as $subscription)
                            <div class="col-lg-4 col-md-6">
                                <div class="subscription-card">
                                    <div class="subscription-title">
                                        <div class="subscription-left">
                                            <h5>{{ $subscription->name }}</h5>
                                            <p class="text-secondary">{{ $subscription->total_clips }} HD clips per
                                                {{ $subscription->duration_type }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="subscribe-price">${{ $subscription->price }}<span>/
                                            {{ $subscription->duration_type }}</span></div>
                                    <p class="text-secondary subscribe-price-text">${{ $subscription->price_per_clip }}
                                        per clip
                                    </p>
                                    <form action="{{ route('subscription.stripe') }}" method="POST">
                                        @csrf

                                        <input type="hidden" name="plan_id" value="{{ $subscription->id }}">


                                        @if ($subscription->is_purchased == '1')
                                            <label class="btn btn-all-dark w-100">
                                                Current Plan
                                            </label>
                                        @else
                                            <button class="btn btn-all-dark w-100">
                                                Subscribe Now
                                            </button>
                                        @endif


                                    </form>

                                    <!-- <button class="btn btn-all-dark  w-100">Subscribe Now</button> -->


                                </div>
                            </div>
                        @endforeach
                        <!-- <div class="col-lg-4 col-md-6">
                                                                                                                                                                                                                                <div class="subscription-card">
                                                                                                                                                                                                                                    <div class="subscription-title">
                                                                                                                                                                                                                                        <div class="subscription-left">

                                                                                                                                                                                                                                            <h5>Quarterly</h5>
                                                                                                                                                                                                                                            <p class="text-secondary">30 HD clips per quarter</p>
                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                        <div class="subscription-right">
                                                                                                                                                                                                                                            <div class="off-badge">15% off</div>

                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                    <div class="subscribe-price">$499 <span>/ quarter</span></div>
                                                                                                                                                                                                                                    <p class="text-secondary subscribe-price-text">$16.63 per clip</p>
                                                                                                                                                                                                                                    <button class="btn btn-all-dark  w-100">Subscribe Now</button>

                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                            <div class="col-lg-4 col-md-6">
                                                                                                                                                                                                                                <div class="subscription-card">
                                                                                                                                                                                                                                    <div class="subscription-title">
                                                                                                                                                                                                                                        <div class="subscription-left">
                                                                                                                                                                                                                                            <h5>Annual</h5>
                                                                                                                                                                                                                                            <p class="text-secondary">120 HD clips per year</p>
                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                        <div class="subscription-right">
                                                                                                                                                                                                                                            <div class="off-badge">33% off</div>
                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                    <div class="subscribe-price">$1599 <span>/ year</span></div>
                                                                                                                                                                                                                                    <p class="text-secondary subscribe-price-text">$13.32 per clip</p>
                                                                                                                                                                                                                                    <button class="btn btn-all-dark w-100">Subscribe Now</button>

                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                            </div> -->
                    </div>
                </div>

            </div>
        @else
            <div class="heading text-center">
                <h3> <span class="yellow-headings">No Subscription plans available at the moment.</span></h3>

            </div>

        @endif
    </section>
    <section class="license_type">
        <div class="container">
            <div class="row justify-content-center row-gap-4">
                <div class="col-12 text-center">
                    <div class="heading">
                        <h2>License <span class="yellow-headings">Types</span></h2>
                        <p>All purchases include perpetual, worldwide licenses. Choose the license that fits your
                            project's distribution needs.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="license-content">
                        <h3>Standard License</h3>
                        <h4>Included with purchase</h4>
                        <ul class="license-subtitle">
                            <li><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check-big h-5 w-5 text-primary mt-0.5 flex-shrink-0">
                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>
                                Use in digital products and websites
                            </li>
                            <li><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check-big h-5 w-5 text-primary mt-0.5 flex-shrink-0">
                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>
                                Social media content
                            </li>
                            <li><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check-big h-5 w-5 text-primary mt-0.5 flex-shrink-0">
                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>
                                Online advertising (up to 500,000 impressions)
                            </li>
                            <li><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check-big h-5 w-5 text-primary mt-0.5 flex-shrink-0">
                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>
                                YouTube and streaming platforms
                            </li>
                            <li><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check-big h-5 w-5 text-primary mt-0.5 flex-shrink-0">
                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>
                                Corporate presentations
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="license-content extended-license">
                        <div class="extended-badge">for Broadcast</div>
                        <h3>Extended License</h3>
                        <h4>+$150 upgrade</h4>
                        <ul class="license-subtitle">
                            <li><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check-big h-5 w-5 text-primary mt-0.5 flex-shrink-0">
                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>
                                All Standard License benefits
                            </li>
                            <li><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check-big h-5 w-5 text-primary mt-0.5 flex-shrink-0">
                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>
                                Broadcast TV (national)
                            </li>
                            <li><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check-big h-5 w-5 text-primary mt-0.5 flex-shrink-0">
                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>
                                Theatrical releases
                            </li>
                            <li><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check-big h-5 w-5 text-primary mt-0.5 flex-shrink-0">
                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>
                                Unlimited impressions
                            </li>
                            <li><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check-big h-5 w-5 text-primary mt-0.5 flex-shrink-0">
                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>
                                Products for resale (templates, apps)
                            </li>
                            <li><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-check-big h-5 w-5 text-primary mt-0.5 flex-shrink-0">
                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>
                                Priority support
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-9 ">
                    <div class="license-text">
                        <div>
                            <h5 class="license-heading">Permitted Uses</h5>
                            <p class="license-subtext">Licensed footage may be used for commercial and non-commercial
                                purposes including websites, mobile apps, advertisements, films, TV shows,
                                presentations, and social media content.</p>
                        </div>
                        <div>
                            <h5 class="license-heading">Restrictions</h5>
                            <ul class="license-subtextul">
                                <li>Footage cannot be resold, redistributed, or sublicensed as-is</li>
                                <li>No use in pornographic, defamatory, or illegal content</li>
                                <li>Attribution is appreciated but not required</li>
                                <li>License is non-transferable and non-exclusive</li>
                                <li>Raw footage files cannot be shared with third parties</li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="license-heading">License Duration</h5>
                            <p class="license-subtext">All licenses are perpetual and worldwide. Once purchased, you
                                may
                                use the footage indefinitely in accordance with the license terms.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pricing_faq">
        <div class="container">
            <div class="heading">
                <h2>Friquantly Asked <span class="yellow-headings"> Questions</span></h2>
            </div>
            <div class="faq_content">
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                aria-controls="panelsStayOpen-collapseOne">
                                <h4>Can I use clips commercially?</h4>
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <p>Yes! All licenses include full commercial rights for unlimited projects.</p>

                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                aria-controls="panelsStayOpen-collapseTwo">
                                <h4>What's your refund policy?</h4>
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <p>We offer a 30-day money-back guarantee on all purchases. No questions asked.</p>

                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                                aria-controls="panelsStayOpen-collapseThree">
                                <h4>Can I download clips multiple times?</h4>
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <p>Absolutely! Once purchased, you have lifetime access to download your clips.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false"
                                aria-controls="panelsStayOpen-collapseFour">
                                <h4>Do you offer custom licensing?</h4>
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <p>Yes, we provide custom licensing for enterprise and broadcast clients. Contact us for
                                    details.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
