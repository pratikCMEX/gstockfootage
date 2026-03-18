{{-- {{ dd($cartItems, $total) }} --}}
<section class="checkout">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="heading">
                    <h2>Checkout</h2>
                </div>
            </div>
            <div class="col-12">
                <form id="checkoutForm">
                    <div class="row row-gap-4">
                        <div class="col-12 col-lg-8">
                            <div class="summary order-summery">
                                <div class="checkout-title">
                                    <h4>Order Summary</h4>
                                    <p>Review your items before checkout</p>
                                </div>
                                <ul class="add-product-div">
                                    @foreach ($cartItems as $item)
                                        <li class="add-product-content">
                                            <div class="add-product-img">
                                                {{-- @if ($item->product->type == '0')
                                                    <img src="{{ asset('uploads/images/low/' . $item->product->low_path) }}"
                                                        class="h-100 w-100" alt="">
                                                @else
                                                    <img src="{{ asset('uploads/videos/thumbnails/' . $item->product->thumbnail_path) }}"
                                                        class="h-100 w-100" alt="">
                                                @endif --}}

                                                @if ($item->product->type == 'image')
                                                    <img src="{{ Storage::disk('s3')->url($item->product->mid_path) }}"
                                                        class="h-100 w-100"
                                                        alt="{{ Storage::disk('s3')->url($item->product->mid_path) }}">
                                                @else
                                                    @if ($item->product->thumbnail_path == null)
                                                        <img src="{{ asset('assets/admin/images/demo_thumbnail.png') }}"
                                                            class="h-100 w-100" alt="">
                                                    @else
                                                        <img src="{{ Storage::disk('s3')->url($item->product->thumbnail_path) }}"
                                                            class="h-100 w-100" alt="">
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="add-product-detail">
                                                <div class="checkout-title-price">
                                                    <h5>
                                                        {{ $item->product->name }}
                                                    </h5>
                                                    <p>${{ $item->product->price }}</p>
                                                </div>
                                                @if ($item->product->type == '0')
                                                    <p>{{ $item->product->height }} x {{ $item->product->width }}</p>
                                                @else
                                                    <p>HD Quality</p>
                                                @endif
                                                <span>Standard License</span>
                                            </div>
                                        </li>
                                    @endforeach
                                    {{-- 
                                    <li class="add-product-content">
                                        <div class="add-product-img">
                                            <img src="imgs/danielle-suijkerbuijk-zeedbMYCbx8-unsplash.jpg"
                                                class="h-100 w-100" alt="">
                                        </div>
                                        <div class="add-product-detail">
                                            <div class="checkout-title-price">
                                                <h5>
                                                    diamond_logo (Standard License)
                                                </h5>
                                                <p>$149</p>
                                            </div>
                                            <p>518x352</p>
                                            <span>Standard License</span>
                                        </div>
                                    </li>
                                    <li class="add-product-content">
                                        <div class="add-product-img">
                                            <img src="imgs/danielle-suijkerbuijk-zeedbMYCbx8-unsplash.jpg"
                                                class="h-100 w-100" alt="">
                                        </div>
                                        <div class="add-product-detail">
                                            <div class="checkout-title-price">
                                                <h5>
                                                    diamond_logo (Standard License)
                                                </h5>
                                                <p>$149</p>
                                            </div>
                                            <p>518x352</p>
                                            <span>Standard License</span>
                                        </div>
                                    </li>
                                    <li class="add-product-content">
                                        <div class="add-product-img">
                                            <img src="imgs/danielle-suijkerbuijk-zeedbMYCbx8-unsplash.jpg"
                                                class="h-100 w-100" alt="">
                                        </div>
                                        <div class="add-product-detail">
                                            <div class="checkout-title-price">
                                                <h5>
                                                    diamond_logo (Standard License)
                                                </h5>
                                                <p>$149</p>
                                            </div>
                                            <p>518x352</p>
                                            <span>Standard License</span>
                                        </div>
                                    </li>
                                    <li class="add-product-content">
                                        <div class="add-product-img">
                                            <img src="imgs/danielle-suijkerbuijk-zeedbMYCbx8-unsplash.jpg"
                                                class="h-100 w-100" alt="">
                                        </div>
                                        <div class="add-product-detail">
                                            <div class="checkout-title-price">
                                                <h5>
                                                    diamond_logo (Standard License)
                                                </h5>
                                                <p>$149</p>
                                            </div>
                                            <p>518x352</p>
                                            <span>Standard License</span>
                                        </div>
                                    </li> --}}
                                </ul>

                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="summary payment-summary">
                                <div class="checkout-title">

                                    <h4>Payment Summary</h4>
                                </div>
                                <div class="sub-total">
                                    <p>subtotal <span>({{ count($cartItems) }} item)</span></p>
                                    <h6>${{ $total }}</h6>
                                </div>
                                <div class="checkout-total">
                                    <p>Total</p>
                                    <h6>${{ number_format($total, 2) }}</h6>
                                </div>
                                <button type="button" id="processPaymentBtn" class="btn btn-orange w-100">Process to
                                    payment</button>

                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <div class="summary payment-information">
                                <div class="checkout-title">
                                    <h4> <i class="bi bi-wallet2"></i> Payment Information</h4>
                                    <p>Secure payment processing via Stripe</p>
                                </div>
                                <div class="mail">
                                    <label for="">Email</label>
                                    <input type="email" name="checkout_email" id="checkout_email"
                                        value="{{ auth()->user()->email }}" placeholder="you@email.com"
                                        {{ auth()->user()->email ? 'disabled' : '' }}>
                                    <span>receipt will be sent to this email</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
