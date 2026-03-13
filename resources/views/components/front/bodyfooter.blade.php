<footer class="site-footer">
    <div class="container">

        <div class="footer-flex">

            <!-- Brand / Social -->
            <div class="footer-box footer-brand">
                <div class="brand">
                    <img src="{{ asset('assets/front/img/header-logo.png') }}" alt="gstockfootage" width="100%"
                        height="100%">
                </div>

                <p class="copyright">
                    © 2026 gstockfootage
                </p>

                <div class="social-links">
                    <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-facebook h-4 w-4 text-muted-foreground">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg></a>
                    <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-twitter h-4 w-4 text-muted-foreground">
                            <path
                                d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z">
                            </path>
                        </svg></a>
                    <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-instagram h-4 w-4 text-muted-foreground">
                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5">
                            </rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                        </svg></a>
                    <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-linkedin h-4 w-4 text-muted-foreground">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z">
                            </path>
                            <rect width="4" height="12" x="2" y="9"></rect>
                            <circle cx="4" cy="4" r="2"></circle>
                        </svg></a>
                    <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-youtube h-4 w-4 text-muted-foreground">
                            <path
                                d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17">
                            </path>
                            <path d="m10 15 5-3-5-3z"></path>
                        </svg></a>
                </div>
            </div>

            <!-- Our Company -->
            <div class="footer-box footer-column">
                <h6>Our company</h6>
                <ul>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                    {{-- <li><a href="{{ route('contact') }}">Contact</a></li> --}}
                    <li><a href="javascript:void(0);">Licenses</a></li>
                </ul>
            </div>

            <!-- Products -->
            <div class="footer-box footer-column">
                <h6>Products and services</h6>
                <ul>
                    <li><a href="javascript:void(0);">All Footage</a></li>
                    <li><a href="javascript:void(0);">Aerial Shots</a></li>
                    <li><a href="javascript:void(0);">Timelapses</a></li>
                    <li><a href="{{ route('collection') }}">Collections</a></li>
                    <li><a href="{{ route('pricing') }}">Pricing</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div class="footer-box footer-column">
                <h6>Legal</h6>
                <ul>
                    <li><a href="{{ route('term') }}">Terms of Service</a></li>
                    <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="footer-box footer-column">
                <h6>Contact us</h6>
                <ul>
                    {{-- <li><a href="{{ route('contact') }}">Contact</a></li> --}}
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>

        </div>
    </div>
</footer>
