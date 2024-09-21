<?php include 'header.php' ?>

        <section class="breadcrumbs-area ptb-100 bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="breadcrumbs">
                            <h2 class="page-title">shop page</h2>
                            <ul>
                                <li>
                                    <a class="active" href="#">Home</a>
                                </li>
                                <li>shop</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="top-shop-area ptb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="shop-around">
                           <div class="all-shop2-area ptb-20">
                                <h3 class="leave-comment-text">Price</h3>
                                <div class="widget shop-filter">
                                    <div class="info_widget">
                                        <div class="price_filter">
                                            <div id="slider-range"></div>
                                            <div class="price_slider_amount">
                                                <input type="text" id="amount" name="price"  />

                                            </div>
                                        </div>
                                    </div>							
                                </div>
                                <div class="blog-right-sidebar">
                                    <div class="blog-search mt-40 mb-60">
                                        <h3 class="leave-comment-text">Search</h3>
                                        <form action="#">
                                            <input value="" placeholder="Search" type="text">
                                            <button class="submit" type="submit"><i class="zmdi zmdi-search"></i></button>
                                        </form>
                                    </div>
                                    <div class="blog-right-sidebar-top mb-60">
                                        <h3 class="leave-comment-text">Categories</h3>
                                        <ul>
                                            <li><a href="#">Hair Straightner <span>(20)</span></a></li>
                                            <li><a href="#">Hair Dryer <span>(70)</span></a></li>
                                            <li><a href="#">Beard Trimmer <span>(25)</span></a></li>
                                            <li><a href="#">Hair Spray <span>(30)</span></a></li>
                                            <li><a href="#">Beard Wax <span>(40)</span></a></li>
                                            <li><a href="#">Hair Shining Oil <span>(50)</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="blog-right-sidebar-bottom">
                                        <h3 class="leave-comment-text">Tags</h3>
                                        <ul>
                                            <li><a href="#">Shaving</a></li>
                                            <li><a href="#">Cuting</a></li>
                                            <li><a href="#">Triming</a></li>
                                            <li><a href="#">Pedicure</a></li>
                                            <li><a href="#">Manicure</a></li>
                                            <li><a href="#">Manicure</a></li>
                                            <li><a href="#">Hair Straigtening</a></li>
                                        </ul>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="features-tab fe-again">
                                    <div class="shop-all-tab top-shop-n">
                                        <div class="two-part an-tw">
                                            <ul class="nav tabs" role="tablist">
                                                <li role="presentation"><a class="active" href="#home" aria-controls="home" role="tab" data-bs-toggle="tab"> Grid</a></li>
                                                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-bs-toggle="tab">List</a></li>
                                            </ul>
                                            <div class="shop5">
                                                <label>Show</label>
                                                <select>
                                                    <option value="">12</option>
                                                    <option value="">24</option>
                                                    <option value="">36</option>
                                                </select>        
                                            </div>
                                        </div>
                                        <div class="sort-by an-short">
                                            <div class="shop6">
                                                <label>Sort By</label>
                                                <select>
                                                    <option value="">Position</option> 
                                                    <option value="">Name</option>
                                                    <option value="">Price</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home">
                                            <div class="row">

                                                <div class="col-lg-4 col-md-6">
                                                    <div class="hs-single-shop-area mb-30">
                                                        <div class="single-shop-thumd">
                                                            <img src="images/shop/1.jpg" alt="product images">
                                                            <div class="product-information">
                                                                <ul>
                                                                    <li><a href="#"><i class="zmdi zmdi-shopping-cart"></i></a></li>
                                                                    <li><a href="#"><i class="zmdi zmdi-favorite"></i></a></li>
                                                                    <li><a data-bs-toggle="modal" data-bs-target="#productModal" title="quick-view" class="quick-view modal-view detail-link" href="#"><i class="zmdi zmdi-eye"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="hs-shop-details">
                                                            <h4 class="shop-title"><a href="#">Hair Shampoo</a></h4>
                                                            <ul class="product-price">
                                                               <li class="new-price">$50.00</li>
                                                               <li class="old-price">20.00</li> 
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 mb-30">
                                                    <div class="hs-single-shop-area">
                                                        <div class="single-shop-thumd">
                                                            <img src="images/shop/2.jpg" alt="product images">
                                                            <div class="product-information">
                                                                <ul>
                                                                    <li><a href="#"><i class="zmdi zmdi-shopping-cart"></i></a></li>
                                                                    <li><a href="#"><i class="zmdi zmdi-favorite"></i></a></li>
                                                                    <li><a data-bs-toggle="modal" data-bs-target="#productModal" title="quick-view" class="quick-view modal-view detail-link" href="#"><i class="zmdi zmdi-eye"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="hs-shop-details">
                                                            <h4 class="shop-title"><a href="#">Hair Shampoo</a></h4>
                                                            <ul class="product-price">
                                                               <li class="new-price">$50.00</li>
                                                               <li class="old-price">20.00</li> 
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 mb-30">
                                                    <div class="hs-single-shop-area">
                                                        <div class="single-shop-thumd">
                                                            <img src="images/shop/3.jpg" alt="product images">
                                                            <div class="product-information">
                                                                <ul>
                                                                    <li><a href="#"><i class="zmdi zmdi-shopping-cart"></i></a></li>
                                                                    <li><a href="#"><i class="zmdi zmdi-favorite"></i></a></li>
                                                                    <li><a data-bs-toggle="modal" data-bs-target="#productModal" title="quick-view" class="quick-view modal-view detail-link" href="#"><i class="zmdi zmdi-eye"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="hs-shop-details">
                                                            <h4 class="shop-title"><a href="#">Hair Shampoo</a></h4>
                                                            <ul class="product-price">
                                                               <li class="new-price">$50.00</li>
                                                               <li class="old-price">20.00</li> 
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 mb-30">
                                                    <div class="hs-single-shop-area">
                                                        <div class="single-shop-thumd">
                                                            <img src="images/shop/1.jpg" alt="product images">
                                                            <div class="product-information">
                                                                <ul>
                                                                    <li><a href="#"><i class="zmdi zmdi-shopping-cart"></i></a></li>
                                                                    <li><a href="#"><i class="zmdi zmdi-favorite"></i></a></li>
                                                                    <li><a data-bs-toggle="modal" data-bs-target="#productModal" title="quick-view" class="quick-view modal-view detail-link" href="#"><i class="zmdi zmdi-eye"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="hs-shop-details">
                                                            <h4 class="shop-title"><a href="#">Hair Shampoo</a></h4>
                                                            <ul class="product-price">
                                                               <li class="new-price">$50.00</li>
                                                               <li class="old-price">20.00</li> 
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 mb-30">
                                                    <div class="hs-single-shop-area">
                                                        <div class="single-shop-thumd">
                                                            <img src="images/shop/2.jpg" alt="product images">
                                                            <div class="product-information">
                                                                <ul>
                                                                    <li><a href="#"><i class="zmdi zmdi-shopping-cart"></i></a></li>
                                                                    <li><a href="#"><i class="zmdi zmdi-favorite"></i></a></li>
                                                                    <li><a data-bs-toggle="modal" data-bs-target="#productModal" title="quick-view" class="quick-view modal-view detail-link" href="#"><i class="zmdi zmdi-eye"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="hs-shop-details">
                                                            <h4 class="shop-title"><a href="#">Hair Shampoo</a></h4>
                                                            <ul class="product-price">
                                                               <li class="new-price">$50.00</li>
                                                               <li class="old-price">20.00</li> 
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 mb-30">
                                                    <div class="hs-single-shop-area">
                                                        <div class="single-shop-thumd">
                                                            <img src="images/shop/3.jpg" alt="product images">
                                                            <div class="product-information">
                                                                <ul>
                                                                    <li><a href="#"><i class="zmdi zmdi-shopping-cart"></i></a></li>
                                                                    <li><a href="#"><i class="zmdi zmdi-favorite"></i></a></li>
                                                                    <li><a data-bs-toggle="modal" data-bs-target="#productModal" title="quick-view" class="quick-view modal-view detail-link" href="#"><i class="zmdi zmdi-eye"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="hs-shop-details">
                                                            <h4 class="shop-title"><a href="#">Hair Shampoo</a></h4>
                                                            <ul class="product-price">
                                                               <li class="new-price">$50.00</li>
                                                               <li class="old-price">20.00</li> 
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="profile">
                                            <div class="sho">
                                                <div class="row hs-single-shop-area shop-over mb-30">
                                                    <div class="col-lg-4 col-md-4 col-shop">
                                                        <div class="single-shop-thumd">
                                                            <img src="images/shop/1.jpg" alt="product images">
                                                            <div class="product-information">
                                                                <ul>
                                                                    <li><a href="#"><i class="zmdi zmdi-shopping-cart"></i></a></li>
                                                                    <li><a href="#"><i class="zmdi zmdi-favorite"></i></a></li>
                                                                    <li><a data-bs-toggle="modal" data-bs-target="#productModal" title="quick-view" class="quick-view modal-view detail-link" href="#"><i class="zmdi zmdi-eye"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-lg-8 col-shop">
                                                        <div class="hs-shop-details">
                                                            <h4 class="shop-title"><a href="#">Hair Shampoo</a></h4>
                                                            <ul>
                                                                <li><a href="#"><i class="zmdi zmdi-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star"></i></a></li>
                                                            </ul>
                                                            <p>Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Viva </p>
                                                            <ul class="product-price">
                                                               <li class="new-price">$50.00</li>
                                                               <li class="old-price">20.00</li> 
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row hs-single-shop-area shop-over mb-30">
                                                    <div class="col-lg-4 col-md-4 col-shop">
                                                        <div class="single-shop-thumd">
                                                            <img src="images/shop/2.jpg" alt="product images">
                                                            <div class="product-information">
                                                                <ul>
                                                                    <li><a href="#"><i class="zmdi zmdi-shopping-cart"></i></a></li>
                                                                    <li><a href="#"><i class="zmdi zmdi-favorite"></i></a></li>
                                                                    <li><a data-bs-toggle="modal" data-bs-target="#productModal" title="quick-view" class="quick-view modal-view detail-link" href="#"><i class="zmdi zmdi-eye"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-lg-8 col-shop">
                                                        <div class="hs-shop-details">
                                                            <h4 class="shop-title"><a href="#">Hair Shampoo</a></h4>
                                                            <ul>
                                                                <li><a href="#"><i class="zmdi zmdi-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star"></i></a></li>
                                                            </ul>
                                                            <p>Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Viva </p>
                                                            <ul class="product-price">
                                                               <li class="new-price">$50.00</li>
                                                               <li class="old-price">20.00</li> 
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row hs-single-shop-area shop-over mb-30">
                                                    <div class="col-lg-4 col-md-4 col-shop">
                                                        <div class="single-shop-thumd">
                                                            <img src="images/shop/3.jpg" alt="product images">
                                                            <div class="product-information">
                                                                <ul>
                                                                    <li><a href="#"><i class="zmdi zmdi-shopping-cart"></i></a></li>
                                                                    <li><a href="#"><i class="zmdi zmdi-favorite"></i></a></li>
                                                                    <li><a data-bs-toggle="modal" data-bs-target="#productModal" title="quick-view" class="quick-view modal-view detail-link" href="#"><i class="zmdi zmdi-eye"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-lg-8 col-shop">
                                                        <div class="hs-shop-details">
                                                            <h4 class="shop-title"><a href="#">Hair Shampoo</a></h4>
                                                            <ul>
                                                                <li><a href="#"><i class="zmdi zmdi-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star"></i></a></li>
                                                            </ul>
                                                            <p>Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Viva </p>
                                                            <ul class="product-price">
                                                               <li class="new-price">$50.00</li>
                                                               <li class="old-price">20.00</li> 
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row hs-single-shop-area shop-over mb-30">
                                                    <div class="col-lg-4 col-md-4 col-shop">
                                                        <div class="single-shop-thumd">
                                                            <img src="images/shop/1.jpg" alt="product images">
                                                            <div class="product-information">
                                                                <ul>
                                                                    <li><a href="#"><i class="zmdi zmdi-shopping-cart"></i></a></li>
                                                                    <li><a href="#"><i class="zmdi zmdi-favorite"></i></a></li>
                                                                    <li><a data-bs-toggle="modal" data-bs-target="#productModal" title="quick-view" class="quick-view modal-view detail-link" href="#"><i class="zmdi zmdi-eye"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-lg-8 col-shop">
                                                        <div class="hs-shop-details">
                                                            <h4 class="shop-title"><a href="#">Hair Shampoo</a></h4>
                                                            <ul>
                                                                <li><a href="#"><i class="zmdi zmdi-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star-outline"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-star"></i></a></li>
                                                            </ul>
                                                            <p>Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Viva </p>
                                                            <ul class="product-price">
                                                               <li class="new-price">$50.00</li>
                                                               <li class="old-price">20.00</li> 
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>	
                                        </div>
                                    </div>
                                    <div class="page text-center">
                                        <ul>
                                            <li><a href="#">01</a></li>
                                            <li><a href="#">02</a></li>
                                            <li class="active"><a href="#">03</a></li>
                                            <li><a href="#">04</a></li>
                                            <li class="p-icon"><a href="#"><i class="zmdi zmdi-long-arrow-right"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php include 'footer.php' ?>