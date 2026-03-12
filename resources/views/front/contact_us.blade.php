<main class="main-contact">
    <section class="contact-hero">
        <div class="hero-inner">
            <div class="hero-badge">Contact Us</div>
            <h1>Get in <span>Touch</span></h1>
            <p>
                Have questions? We're here to help. Send us a message and we'll
                respond as soon as possible.
            </p>
        </div>
    </section>

    <section class="contact-main-section">
        <div class="container">
            <div class="content-wrap">
                <!-- Info Cards -->
                <div class="info-grid fade-1">
                    <div class="info-card">
                        <div class="ic-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="2" y="4" width="20" height="16" rx="2.5" />
                                <polyline points="2,4 12,13 22,4" />
                            </svg>
                        </div>
                        <div class="ic-text">
                            <h3>Email Us</h3>
                            <p>hello@gstockfootage.com</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="ic-icon">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                            </svg>
                        </div>
                        <div class="ic-text">
                            <h3>Live Chat</h3>
                            <p>Available Mon–Fri, 9am–5pm EST</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="ic-icon">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12,6 12,12 16,14" />
                            </svg>
                        </div>
                        <div class="ic-text">
                            <h3>Response Time</h3>
                            <p>Usually within 24 hours</p>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="form-section fade-2">
                    <!-- Left panel -->
                    <div class="f-left">
                        <div class="f-left-top">
                            <span class="f-eyebrow">Send a Message</span>
                            <h2>Let's start a <span>conversation</span></h2>
                            <p>
                                Fill out the form and we'll get back to you shortly. We'd love
                                to hear from you.
                            </p>
                            <div class="f-divider"></div>
                            <div class="f-contacts">
                                <div class="fc-item">
                                    <div class="fc-dot">
                                        <svg viewBox="0 0 24 24">
                                            <rect x="2" y="4" width="20" height="16" rx="2" />
                                            <polyline points="2,4 12,13 22,4" />
                                        </svg>
                                    </div>
                                    <span>hello@gstockfootage.com</span>
                                </div>
                                <div class="fc-item">
                                    <div class="fc-dot">
                                        <svg viewBox="0 0 24 24">
                                            <path
                                                d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                                        </svg>
                                    </div>
                                    <span>Mon–Fri, 9am–5pm EST</span>
                                </div>
                                <div class="fc-item">
                                    <div class="fc-dot">
                                        <svg viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10" />
                                            <polyline points="12,6 12,12 16,14" />
                                        </svg>
                                    </div>
                                    <span>Usually within 24 hours</span>
                                </div>
                            </div>
                        </div>
                        <div class="f-left-bottom">
                            <div class="resp-badge">
                                <span class="resp-dot"></span>
                                Usually within 24 hours
                            </div>
                        </div>
                    </div>

                    <!-- Right: form -->
                    <div class="f-right">
                        <div class="f-right-head">
                            <h3>Send us a Message</h3>
                            <p>Fill out the form below and we'll get back to you shortly</p>
                        </div>
                        <form name="contactForm" id="contactForm" method="POST" action="{{ route('contact.add') }}">
                            @csrf
                        <div class="form-grid">
                            <div class="field">
                                <label>Name <sup>*</sup></label>
                                <input type="text" name="name" id="name" placeholder="Enter Your Name" />
                            </div>
                            <div class="field">
                                <label>Email <sup>*</sup></label>
                                <input type="email" name="email" id="email" placeholder="Enter Your Email" />
                            </div>
                            <div class="field full">
                                <label>Subject <sup>*</sup></label>
                                <input type="text" name="subject" id="subject" placeholder="Enter Subject" />
                            </div>
                            <div class="field full">
                                <label>Message <sup>*</sup></label>
                                <textarea placeholder="Enter Your Message here" name="message" id="message"></textarea>
                            </div>
                        </div>

                        <div class="submit-row">
                            <button type="submit" class="btn btn-orange">
                                Send Message
                                <svg viewBox="0 0 24 24">
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                    <polyline points="12,5 19,12 12,19" />
                                </svg>
                            </button>
                            
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- <section class="contact_section">
        <div class="container">
            <div class="heading text-center">
                <h2>Get in <span class="yellow-headings">Touch</span> </h2>
                <p>Have questions? We're here to help. Send us a message and we'll respond as soon as possible.</p>
            </div>
            <div class="contact-info">
                <div class="contact-info-content">
                    <div class="contact-info-icons">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <h3 class="contact-info-title">
                        Email Us
                    </h3>
                    <a href="mailto:hello@gstockfootage.com">hello@gstockfootage.com</a>
                </div>
                <div class="contact-info-content">
                    <div class="contact-info-icons">
                        <i class="fa-regular fa-message"></i>
                    </div>
                    <h3 class="contact-info-title">
                        Live Chat
                    </h3>
                    <p>Available Mon-Fri, 9am-5pm EST</p>
                </div>
                <div class="contact-info-content">
                    <div class="contact-info-icons">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <h3 class="contact-info-title">
                        Response Time
                    </h3>
                    <p>Usually within 24 hours</p>
                </div>
            </div>
            <div class="contact-form">
                <h3>Send us a Message</h3>
                <p>Fill out the form below and we'll get back to you shortly</p>
                <form id="contactForm" name="contactForm" method="POST" action="{{ route('contact.add') }}">
                    @csrf
                    <div class="contact-form-flex">
                        <div class="w-100">
                            <label for="">Name *</label>
                            <input class="form-control w-100" type="text" name="name" placeholder="Enter Your Name" id="">
                        </div>
                        <div class="w-100">
                            <label for="">Email *</label>
                            <input class="form-control w-100" type="email" name="email" id="" placeholder="Enter Your Email">
                        </div>
                    </div>
                    <div>
                        <label for="">Subject *</label>
                        <input class="form-control" type="text" name="subject" id="" placeholder="Enter Subject">
                    </div>
                    <div>
                        <label for="">Message *</label>
                        <textarea class="form-control contact-msg" name="message" id="" placeholder="Enter Your Message here"></textarea>
                    </div>
                    <button type="submit" class="btn btn-orange">Send Message</button>
                </form>
            </div>
        </div>
    </section> -->
</main>