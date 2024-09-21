<?php include 'header.php' ?>

        <section class="breadcrumbs-area ptb-100 bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="breadcrumbs">
                            <h2 class="page-title">checkout</h2>
                            <ul>
                                <li>
                                    <a class="active" href="#">Home</a>
                                </li>
                                <li>checkout</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="collapse_area ptb-90">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="check">
                            <h1>Checkout</h1>
                        </div>
                        <div class="faq-accordion">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a class="collapsed method" role="button" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> <span class="number">step 1 : </span>Checkout Method <i class="zmdi zmdi-caret-down"></i></a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" data-bs-parent="#accordion" aria-labelledby="headingOne" >
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="easy">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="Register">
                                                                <h3>New Customer</h3>
                                                            </div>
                                                            <p>Checkout Options:</p>
                                                            <div class="method-input-box">
                                                                <p>
                                                                    <input type="radio" checked="" value="Checkout" name="checkout">
                                                                    <label>Register Account</label>
                                                                </p>
                                                                <p>
                                                                    <input type="radio" value="Register" name="checkout">
                                                                    <label>Guest Checkout</label>
                                                                </p>
                                                            </div>
                                                            <div class="easy-text">
                                                                <p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
                                                            </div>
                                                            <div class="block-button-left">
                                                                <button class="button2 get" type="button" title="">
                                                                    <span>Continue</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="Register easy-res">
                                                                <h3>Returning Customer</h3>
                                                            </div>
                                                            <div class="easy-text">
                                                                <p>I am a returning customer</p>
                                                            </div>
                                                            <p class="log">Please log in below:</p>
                                                            <form action="#">
                                                                <div class="input-one form-list crnd">
                                                                    <label class="required">
                                                                        Email Address
                                                                        <em>*</em>
                                                                    </label>
                                                                    <input class="email small" type="text" placeholder="E-Mail" required="">
                                                                </div>
                                                                <div class="input-one form-list">
                                                                    <label class="required">
                                                                        Password
                                                                        <em>*</em>
                                                                    </label>
                                                                    <input class="email small" type="password" placeholder="Password" required="">
                                                                </div>
                                                            </form>
                                                            <div class="block-button-right">
                                                                <a href="#">Forgot your pasword?</a>
                                                                <button class="button2 get" type="button" title="">
                                                                    <span>Login</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Step 2: Account & Billing Details  <i class="zmdi zmdi-caret-down"></i>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" data-bs-parent="#accordion" aria-labelledby="headingTwo" style="height: 0px;">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="easy">
                                                    <div class="billing-info">
                                                        <div class="row">
                                                            <div class="input-one form-list col-md-4">
                                                                <label class="required">
                                                                    First Name
                                                                    <em>*</em>
                                                                </label>
                                                                <input class="email" type="text" required="">
                                                            </div>
                                                            <div class="input-one form-list col-md-4">
                                                                <label class="required">Middle Name/Initial</label>
                                                                <input class="email" type="text" required="">
                                                            </div>
                                                            <div class="input-one form-list col-md-4">
                                                                <label class="required">
                                                                    Last Name
                                                                    <em>*</em>
                                                                </label>
                                                                <input class="email" type="text" required="">
                                                            </div>
                                                            <div class="input-one form-list col-md-6">
                                                                <label class="required">Company</label>
                                                                <input class="email" type="text" required="">
                                                            </div>
                                                            <div class="input-one form-list col-md-6">
                                                                <label class="required">
                                                                    Email Address
                                                                    <em>*</em>
                                                                </label>
                                                                <input class="email" type="text" required="">
                                                            </div>
                                                            <div class="input-one form-list col-12">
                                                                <label class="required">
                                                                    Address
                                                                    <em>*</em>
                                                                </label>
                                                                <input class="email" type="text" required="">
                                                            </div>
                                                            <div class="input-one form-list col-md-6">
                                                                <label class="required">
                                                                    City
                                                                    <em>*</em>
                                                                </label>
                                                                <input class="email" type="text" required="">
                                                            </div>
                                                            <div class="input-one form-list col-md-6">
                                                                <label class="required">
                                                                    State/Province
                                                                    <em>*</em>
                                                                </label>
                                                                <input class="email" type="text" required="">
                                                            </div>
                                                            <div class="input-one form-list col-md-6">
                                                                <label class="required">
                                                                    Zip/Postal Code
                                                                    <em>*</em>
                                                                </label>
                                                                <input class="email" type="text" required="">
                                                            </div>
                                                            <div class="input-one form-listcol col-md-6">
                                                                <div class="country-select">
                                                                    <label class="required req2">
                                                                        Country
                                                                        <em>*</em>
                                                                    </label>
                                                                    <select class="email s-email">
                                                                        <option value="1">United State</option>
                                                                        <option value="2">Azerbaijan</option>
                                                                        <option value="3">Bahamas</option>
                                                                        <option value="4">Bahrain</option>
                                                                        <option value="5">Bangladesh</option>
                                                                        <option value="6">Barbados</option>
                                                                        <option value="7">Belarus</option>
                                                                        <option value="8">Belgium</option>
                                                                        <option value="9">Belize</option>
                                                                        <option value="10">Benin</option>
                                                                        <option value="11">Bermuda</option>
                                                                        <option value="12">Bhutan</option>
                                                                        <option value="13">Bolivia</option>
                                                                        <option value="14">Bosnia and Herzegovina</option>
                                                                        <option value="15">Botswana</option>
                                                                        <option value="16">Bouvet Island</option>
                                                                        <option value="17">Brazil</option>
                                                                        <option value="18">British Indian Ocean Territory</option>
                                                                        <option value="19">British Virgin Islands</option>
                                                                        <option value="20">Brunei</option>
                                                                        <option value="21">United State</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="input-one form-list che col-12">
                                                                <label class="required">
                                                                    Telephone
                                                                    <em>*</em>
                                                                </label>
                                                                <input class="email" type="text" required="">
                                                            </div>
                                                            <div class="form-group col-12">
                                                                <div class="method-input-box">
                                                                    <p>
                                                                        <input type="radio" checked="" value="address" name="address">
                                                                        <label>Ship to this address</label>
                                                                    </p>
                                                                    <p>
                                                                        <input type="radio" value="dadress" name="address">
                                                                        <label>Ship to different address</label>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="block-button-right col-12">
                                                                <a class="o-back-to" href="#">
                                                                    <i class="fa fa-arrow-up"></i>
                                                                    Back
                                                                </a>
                                                                <button class="button2 get" type="button" title="">
                                                                    <span>Get a Quote</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-bs-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseTwo">Step 3: Delivery Details <i class="zmdi zmdi-caret-down"></i></a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" data-bs-parent="#accordion" aria-labelledby="headingThree" style="height: 0px;">
                                        <div class="easy">
                                            <div class="left-info ship-info">
                                                <div class="left-up">
                                                    <span>BootExpert</span>
                                                    <span>Bonosrie</span>
                                                    <span>D- Block</span>
                                                    <span>Dkaka, 1201</span>
                                                    <span>Bangladesh</span>
                                                    <span>T: +8800 879 9876 </span>
                                                </div>
                                                <a href="#">Edit Address</a>
                                                <div class="use-billing-add">
                                                    <div class="country-select">
                                                        <select class="email s-email s-wid">
                                                            <option>Select Your Address</option>
                                                            <option>Add New Address</option>
                                                            <option>Boot Experts, Bonosrie D- Block, Dkaka, 1201, Bangladesh</option>
                                                        </select>
                                                    </div>
                                                    <p>
                                                        <input type="checkbox" name="billadddress">
                                                        <label>Use Billing Address</label>
                                                    </p>
                                                </div>
                                                <div class="block-button-right back">
                                                    <a class="o-back-to" href="#">
                                                    <i class="fa fa-arrow-up"></i>
                                                    Back
                                                    </a>
                                                    <button class="button2 get" type="button" title="">
                                                        <span>Continue</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-bs-toggle="collapse" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Step 4: Delivery Method <i class="zmdi zmdi-caret-down"></i></a>
                                        </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" data-bs-parent="#accordion" aria-labelledby="headingFour" style="height: 0px;">
                                        <div class="easy">
                                            <div class="shiping-method">
                                                <p>Flat Rate</p>
                                                <p>Fixed $40.00</p>
                                                <div class="block-button-right">
                                                    <a class="o-back-to" href="#">
                                                    <i class="fa fa-arrow-up"></i>
                                                    Back
                                                    </a>
                                                    <button class="button2 get" type="button" title="">
                                                        <span>Continue</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingFive">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-bs-toggle="collapse" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Step 5: Payment Method <i class="zmdi zmdi-caret-down"></i></a>
                                        </h4>
                                    </div>
                                    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" data-bs-parent="#accordion" aria-labelledby="headingFive" style="height: 0px;">
                                        <div class="easy">
                                            <div class="checkout-option">
                                                <div class="method-input-box">
                                                    <p>
                                                        <input type="radio" value="check" name="payment">
                                                        <label>Check / Money order </label>
                                                    </p>
                                                    <p>
                                                        <input type="radio" checked="" value="card" name="payment">
                                                        <label>Credit Card (saved) </label>
                                                    </p>
                                                </div>
                                                <div class="master-card-info">
                                                    <form action="#">
                                                        <div class="input-one form-list col-sm-12">
                                                            <label class="required">
                                                                Name on Card
                                                                <em>*</em>
                                                            </label>
                                                            <input class="email" type="text" required="">
                                                        </div>
                                                        <div class=" input-one form-list col-sm-12">
                                                            <label class="required ">Credit Card Type</label>
                                                            <select class="email s-email s-wid cen type6">
                                                                <option>--Please Select--</option>
                                                                <option>American Express</option>
                                                                <option>Visa</option>
                                                                <option>MasterCard</option>
                                                                <option>Discover</option>
                                                            </select>
                                                        </div>
                                                        <div class="input-one form-list col-sm-12">
                                                            <label class="required">
                                                                Credit Card Number
                                                                <em>*</em>
                                                            </label>
                                                            <input class="email" type="text" required="">
                                                        </div>
                                                        <div class="experi">
                                                            <div class="input-one form-list col-sm-12">
                                                                <label class="required">Expiration Date</label>
                                                            
                                                            </div>
                                                            <div class="date">
                                                                <select class="email s-email us tr6">
                                                                    <option>--Month--</option>
                                                                    <option>01 - January</option>
                                                                    <option>02 - February</option>
                                                                    <option>03 - March</option>
                                                                    <option>04 - April</option>
                                                                    <option>05 - May</option>
                                                                    <option>06 - June</option>
                                                                    <option>07 - July</option>
                                                                    <option>08 - August</option>
                                                                    <option>09 - September</option>
                                                                    <option>10 - October</option>
                                                                    <option>11 - November</option>
                                                                    <option>12 - December</option>
                                                                </select>
                                                                <select class="email s-email us">
                                                                    <option>--Year--</option>
                                                                    <option>2015</option>
                                                                    <option>2016</option>
                                                                    <option>2017</option>
                                                                    <option>2018</option>
                                                                    <option>2019</option>
                                                                    <option>2020</option>
                                                                    <option>2021</option>
                                                                    <option>2022</option>
                                                                    <option>2023</option>
                                                                    <option>2024</option>
                                                                    <option>2025</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="verificationcard input-one form-list col-sm-12">
                                                            <label class="required">
                                                                Card Verification Number
                                                                <em>*</em>
                                                            </label>
                                                            <input class="email" type="text" required="">
                                                        </div>
                                                    </form>
                                                    <div class="block-button-right">
                                                        <a class="o-back-to" href="#">
                                                            <i class="fa fa-arrow-up"></i>
                                                            Back
                                                        </a>
                                                        <button class="button2 get" type="button" title="">
                                                            <span>Continue</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingSix">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-bs-toggle="collapse" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">Step 6: Confirm Order <i class="zmdi zmdi-caret-down"></i></a>
                                        </h4>
                                    </div>
                                    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" data-bs-parent="#accordion" aria-labelledby="headingSix" style="height: 0px;">
                                        <div class="easy">
                                            <div class="order-review">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th class="width-1">Product Name</th>
                                                                <th class="width-2">Price</th>
                                                                <th class="width-3">Qty</th>
                                                                <th class="width-4">Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="o-pro-dec">
                                                                        <p>Fusce aliquam</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-price">
                                                                        <p>$236.00</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-qty">
                                                                        <p>2</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-subtotal">
                                                                        <p>$236.00</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="o-pro-dec">
                                                                        <p>Primis in faucibus</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-price">
                                                                        <p>$265.00</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-qty">
                                                                        <p>3</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-subtotal">
                                                                        <p>$265.00</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="o-pro-dec">
                                                                        <p>Etiam gravida</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-price">
                                                                        <p>$363.00</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-qty">
                                                                        <p>2</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-subtotal">
                                                                        <p>$363.00</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="o-pro-dec">
                                                                        <p>Quisque in arcu</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-price">
                                                                        <p>$328.00</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-qty">
                                                                        <p>2</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-subtotal">
                                                                        <p>$328.00</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">Subtotal </td>
                                                                <td colspan="1">$4,001.00</td>
                                                            </tr>
                                                            <tr class="tr-f">
                                                                <td colspan="3">Shipping & Handling (Flat Rate - Fixed</td>
                                                                <td colspan="1">$45.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">Grand Total</td>
                                                                <td colspan="1">$4,722.00</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="block-right">
                                                    <span>
                                                        Forgot an Item?
                                                        <a class="o-back-to" href="#"> Edit Your Cart</a>
                                                        
                                                    </span>
                                                    <button class="button2 get" type="button" title="">
                                                        <span>Continue</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php include 'footer.php' ?>