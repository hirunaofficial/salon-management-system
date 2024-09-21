<?php include 'header.php' ?>

        <section class="breadcrumbs-area ptb-100 bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="breadcrumbs">
                            <h2 class="page-title">My Account</h2>
                            <ul>
                                <li>
                                    <a class="active" href="#">Home</a>
                                </li>
                                <li>My Account</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="collapse_area coll2 ptb-90">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="check">
                            <h1>My Account :</h1>
                        </div>
                        <div class="faq-accordion">
                            <div class="panel-group pas7" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a class="collapsed method" role="button" data-bs-toggle="collapse"  href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Edit your account information <i class="zmdi zmdi-caret-down"></i> </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                        <div class="row align-items-center">
                                            <div class="col-12 easy2">
                                                <h1>My Account Information</h1>
                                                <form class="form-horizontal" action="#">
                                                    <fieldset>
                                                        <legend>Your Personal Details</legend>
                                                        <div class="form-group row align-items-center required pt-5 mt-0">
                                                            <label class="col-md-2 control-label">First Name </label>
                                                            <div class="col-md-10">
                                                                <input class="form-control" type="text" placeholder="First Name">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row align-items-center required">
                                                            <label class="col-md-2 control-label">Last Name</label>
                                                            <div class="col-md-10">
                                                                <input class="form-control" type="text" placeholder="Last Name">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row align-items-center required">
                                                            <label class="col-md-2 control-label">E-Mail</label>
                                                            <div class="col-md-10">
                                                                <input class="form-control" type="email" placeholder="E-Mail">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row align-items-center required">
                                                            <label class="col-md-2 control-label">Telephone</label>
                                                            <div class="col-md-10">
                                                                <input class="form-control" type="tel" placeholder="Telephone">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row align-items-center">
                                                            <label class="col-md-2 control-label">Fax</label>
                                                            <div class="col-md-10">
                                                                <input class="form-control" type="text" placeholder="Fax">
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <div class="buttons d-flex justify-content-between flex-wrap mt-5">
                                                        <div class="pull-left">
                                                            <a class="btn btn-default ce5" href="#">Back</a>
                                                        </div>
                                                        <div class="pull-right">
                                                            <input class="btn btn-primary ce5" type="submit" value="Continue">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-bs-toggle="collapse"  href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Change your password <i class="zmdi zmdi-caret-down"></i></a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" data-bs-parent="#accordion" style="height: 0px;">
                                        <div class="row align-items-center">
                                            <div class="col-12 easy2">
                                                <h1>Change Password</h1>
                                                <form class="form-horizontal" action="#">
                                                    <fieldset>
                                                        <legend>Your Password</legend>
                                                        <div class="form-group row align-items-center required pt-5 mt-0">
                                                            <label class="col-md-2 control-label">Password</label>
                                                            <div class="col-md-10">
                                                                <input class="form-control" type="password" placeholder="password">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row align-items-center required">
                                                            <label class="col-md-2 control-label">Password Confirm</label>
                                                            <div class="col-md-10">
                                                                <input class="form-control" type="password" placeholder="password confirm">
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <div class="buttons d-flex justify-content-between flex-wrap mt-5">
                                                        <div class="pull-left">
                                                            <a class="btn btn-default ce5" href="#">Back</a>
                                                        </div>
                                                        <div class="pull-right">
                                                            <input class="btn btn-primary ce5" type="submit" value="Continue">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-bs-toggle="collapse"  href="#collapseThree" aria-expanded="false" aria-controls="collapseTwo">Modify your address book entries  <i class="zmdi zmdi-caret-down"></i></a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" data-bs-parent="#accordion" style="height: 0px;">
                                        <div class="easy2">
                                            <h1 class="mb-20">Address Book Entries</h1>
                                            <table class="table table-bordered table-hover">
                                                <tr>
                                                    <td class="text-left">
                                                        Farhana hayder (shuvo)
                                                        <br>
                                                        hastech
                                                        <br>
                                                        Road#1 , Block#c
                                                        <br>
                                                        Rampura.
                                                        <br>
                                                        Dhaka
                                                        <br>
                                                        Bangladesh
                                                    </td>
                                                    <td class="text-right">
                                                        <a class="btn btn-info g6" href="#">Edit</a>
                                                        <a class="btn btn-danger g6" href="#">Delete</a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="buttons d-flex justify-content-between flex-wrap mt-5">
                                                <div class="pull-left">
                                                    <a class="btn btn-default ce5" href="#">Back</a>
                                                </div>
                                                <div class="pull-right">
                                                    <input class="btn btn-primary ce5" type="submit" value="Continue">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="collap mt-2" href="wishlist.html">Modify your wish list <i class="zmdi zmdi-caret-down"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php include 'footer.php' ?>