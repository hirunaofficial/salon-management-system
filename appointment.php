<?php include 'header.php'; ?>

<section class="breadcrumbs-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Appointment</h2>
                    <ul>
                        <li>
                            <a class="active" href="index.php">Home</a>
                        </li>
                        <li>Appointment</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="hs-appoinment-area" class="hs-appoinment-area bg-gray">
    <div class="container-fluid ps-0 pe-0">
        <div class="row g-0 align-items-center">
            <div class="col-lg-6">
                <div class="appoinment-thumb appoinment-thumb-st2">
                    <img src="images/others/appoinment/1.jpg" alt="appointment image">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="appoinment-inner appoinment-inner-st2">
                    <div class="appoinment-title text-center">
                        <h2 class="section-title">Book an Appointment</h2>
                        <p class="section-details appoinment">
                            Schedule your beauty experience with Glamour Salon. Fill in the details below and we will take care of the rest.
                        </p>
                    </div>
                    <div class="appoinment-form mt-40">
                        <form action="submit_appointment.php" method="POST">
                            <div class="input-box">
                                <input type="text" name="name" placeholder="Your Name" required>
                                <input type="email" name="email" placeholder="Your Email" required>
                            </div>
                            <div class="input-box">
                                <input type="tel" name="phone" placeholder="Phone Number" required>
                                <select name="service" required>
                                    <option disabled selected>Choose Service</option>
                                    <option value="Classic Haircut">Classic Haircut</option>
                                    <option value="Hair Extensions">Hair Extensions</option>
                                    <option value="Hair Coloring">Hair Coloring</option>
                                    <option value="Hair Treatment">Hair Treatment</option>
                                </select>
                            </div>
                            <div class="input-box">
                                <input type="text" name="date" placeholder="Preferred Date (DD/MM/YYYY)" required>
                                <select name="time" required>
                                    <option disabled selected>Choose Time</option>
                                    <option value="9:00 AM">9:00 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                </select>
                            </div>
                            <div class="book-appoin-btn mt-30">
                                <button type="submit" class="hs-btn hs-btn-2">Book Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>