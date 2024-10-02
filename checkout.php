<?php include 'header.php' ?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Checkout</h2>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <li>Checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="checkout-area ptb-90">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="check">
                    <h1>Checkout</h1>
                </div>

                <!-- Billing and Account Details -->
                <div class="checkout-section">
                    <h4>Step 1: Account & Billing Details</h4>
                    <form action="checkout_process.php" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <label for="telephone">Telephone</label>
                                    <input type="tel" name="telephone" class="form-control" placeholder="Telephone" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" class="form-control" placeholder="Address" required>
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" name="city" class="form-control" placeholder="City" required>
                                </div>
                                <div class="form-group">
                                    <label for="state">State/Province</label>
                                    <input type="text" name="state" class="form-control" placeholder="State/Province" required>
                                </div>
                                <div class="form-group">
                                    <label for="postal_code">Postal Code</label>
                                    <input type="text" name="postal_code" class="form-control" placeholder="Postal Code" required>
                                </div>
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <select name="country" class="form-control" required>
                                        <option value="">Select Country</option>
                                        <option value="US">United States</option>
                                        <option value="CA">Canada</option>
                                        <option value="GB">United Kingdom</option>
                                        <!-- Add more countries as needed -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Delivery Method -->
                <div class="checkout-section">
                    <h4>Step 2: Delivery Method</h4>
                    <div class="form-group">
                        <label for="delivery_method">Select Delivery Method</label>
                        <select name="delivery_method" class="form-control" required>
                            <option value="standard">Standard Shipping (Free)</option>
                            <option value="express">Express Shipping ($20.00)</option>
                        </select>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="checkout-section">
                    <h4>Step 3: Payment Method</h4>
                    <div class="form-group">
                        <label>Select Payment Method</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="payment_method" value="credit_card" required> Credit Card
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="payment_method" value="paypal" required> PayPal
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="card_number">Credit Card Number</label>
                        <input type="text" name="card_number" class="form-control" placeholder="Credit Card Number" required>
                    </div>
                    <div class="form-group">
                        <label for="expiry_date">Expiration Date</label>
                        <input type="month" name="expiry_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" name="cvv" class="form-control" placeholder="CVV" required>
                    </div>
                </div>

                <!-- Order Review -->
                <div class="checkout-section">
                    <h4>Step 4: Order Review</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through cart items and display them here -->
                            <tr>
                                <td>Example Product 1</td>
                                <td>$100.00</td>
                                <td>2</td>
                                <td>$200.00</td>
                            </tr>
                            <!-- Add more products as needed -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">Subtotal</td>
                                <td>$200.00</td>
                            </tr>
                            <tr>
                                <td colspan="3">Shipping</td>
                                <td>$20.00</td>
                            </tr>
                            <tr>
                                <td colspan="3">Grand Total</td>
                                <td>$220.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Place Order Button -->
                <div class="checkout-section">
                    <button type="submit" class="btn btn-primary btn-lg">Place Order</button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php' ?>
