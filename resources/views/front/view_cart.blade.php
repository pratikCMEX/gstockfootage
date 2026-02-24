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
                                        <div class="cart-product-img">
                                            @if ($cartItem['type'] == '0')
                                                <img src="{{ asset('uploads/images/low/' . $cartItem['low_path']) }}"
                                                    class="h-100 w-100" alt="">
                                            @else
                                                <img src="{{ asset('uploads/videos/thumbnails/' . $cartItem['thumbnail_path']) }}"
                                                    class="h-100 w-100" alt="">
                                            @endif
                                        </div>

                                        <button type="button" class="btn btn-cart-remove delete_add_to_cart"
                                            data-id="{{ $cartItem['id'] }}" data-price="{{ $cartItem['price'] }}">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>

                                        <p>{{ $cartItem['title'] }}</p>
                                    </div>
                                </td>

                                <td>
                                    <p>${{ $cartItem['price'] }}</p>
                                </td>

                                <td>
                                    <p>${{ $cartItem['subtotal'] }}</p>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <div class="cart-btn">
                <a class="return-shop  d-btock" href="index.html">
                    <button class="btn btn-orange" type="button">
                        Return To Shop
                    </button></a>
                <div class="cart-total-section">

                    <div class="cart-page-total">
                        <h3>Cart Total</h3>
                        <div class="cart-checkout-total">
                            <div class="total">
                                <h4 class="total-title">Subtotal:</h4>
                                <p class="total-price total_cart_amt">${{ $cart['total'] }}</p>
                            </div>
                            <div class="total">
                                <h4 class="total-title">Shipping:</h4>
                                <p class="total-price">Free</p>
                            </div>
                            <div class="total">
                                <h4 class="total-title">Total:</h4>
                                <p class="total-price total_cart_amt">${{ $cart['total'] }}</p>
                            </div>
                        </div>
                        <a href="checkout.html"><button type="button" class="btn btn-orange">Process to
                                checkout</button></a>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
