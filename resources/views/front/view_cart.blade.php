<main>
    <section class="cart_section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="heading">
                        <h2>Cart Page</h2>
                    </div>
                </div>
            </div>
            <div class="cart-table">
                <table id="cartTable">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($cart['items'] as $cartItem)
                            <tr id="cart-item-{{ $cartItem['id'] }}" data-price="{{ $cartItem['price'] }}">
                                <td>
                                    <div class="cart-product">
                                        <a href="{{ route('product.detail', encrypt($cartItem['id'])) }}">
                                            <div class="cart-product-img">
                                                @if ($cartItem['type'] == 'image')
                                                    <img src="{{ $cartItem['mid_path'] ? Storage::disk('s3')->url($cartItem['mid_path']) : '' }}"
                                                        class="h-100 w-100" alt="">
                                                @else
                                                    <img src="{{ Storage::disk('s3')->url($cartItem['thumbnail_path']) }}"
                                                        class="h-100 w-100" alt="">
                                                @endif
                                            </div>
                                        </a>

                                        <button type="button" class="btn btn-cart-remove delete_add_to_cart"
                                            data-id="{{ $cartItem['id'] }}" data-price="{{ $cartItem['price'] }}">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>

                                        <a href="{{ route('product.detail', encrypt($cartItem['id'])) }}">
                                            <p>
                                                {{ $cartItem['title'] }}
                                            </p>
                                        </a>
                                        <span class="imageVideo-badge top-0 start-0 m-2 badge"
                                            style="background: {{ $cartItem['type'] === 'video' ? '#ff6b00' : '#ff6b00' }}; font-size:10px;">
                                            {{ $cartItem['type'] === 'video' ? '▶ Video' : '🖼 Photo' }}
                                        </span>
                                    </div>

                                </td>

                                <td>
                                    <p>${{ number_format($cartItem['price'], 2) }}</p>
                                </td>

                                <td>
                                    <p>${{ number_format($cartItem['subtotal'], 2) }}</p>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <div class="cart-btn">
                <a class="return-shop  d-btock" href="{{ route('home') }}">
                    <button class="btn btn-orange" type="button">
                        Return To Shop
                    </button></a>
                <div class="cart-total-section">

                    <div class="cart-page-total">
                        <h3>Cart Total</h3>
                        <div class="cart-checkout-total">
                            <div class="total">
                                <h4 class="total-title">Subtotal:</h4>
                                <p class="total-price total_cart_amt">${{ number_format($cart['total'], 2) }}</p>
                            </div>
                            <div class="total">
                                <h4 class="total-title">Shipping:</h4>
                                <p class="total-price">Free</p>
                            </div>
                            <div class="total">
                                <h4 class="total-title">Total:</h4>
                                <p class="total-price total_cart_amt">${{ number_format($cart['total'], 2) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('checkout') }}"><button type="button"
                                class="btn btn-orange cart-btns {{ count($cart['items']) > 0 ? '' : 'd-none' }}">Process
                                to
                                checkout</button></a>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
