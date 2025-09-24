@extends('layout.app')
    
    @section('navbar')
        @include('components.navbar')
    @endsection
    @section('content')
    <section class="hero" id="hero">
                <div class="container">
                    <div class="row">

                        <div class="col-12">
                            <div id="myCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="images/slider/portrait-successful-mid-adult-doctor-with-crossed-arms.jpg" class="img-fluid" alt="">
                                    </div>

                                    <div class="carousel-item">
                                        <img src="images/slider/young-asian-female-dentist-white-coat-posing-clinic-equipment.jpg" class="img-fluid" alt="">
                                    </div>

                                    <div class="carousel-item">
                                        <img src="images/slider/doctor-s-hand-holding-stethoscope-closeup.jpg" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="heroText d-flex flex-column justify-content-center">

                                <h1 class="mt-auto mb-2">
                                    Doctor is 
                                    <div class="animated-info">
                                        <span class="animated-item">In</span>
                                        <span class="animated-item">Out</span>
                                    </div>
                                </h1>

                                <p class="mb-4">Medic Care is a Bootstrap 5 Template provided by TemplateMo website. Credits go to FreePik and RawPixel for images used in this template.</p>

                                <div class="heroLinks d-flex flex-wrap align-items-center">
                                    <a class="custom-link me-4" href="#about" data-hover="Learn More">Learn More</a>

                                    <p class="contact-phone mb-0"><i class="bi-phone"></i> 010-020-0340</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <section class="section-padding" id="about">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-12">
                            <h2 class="mb-lg-3 mb-3">Meet Dr. Carson</h2>

                            <p>Protect yourself and others by wearing masks and washing hands frequently. Outdoor is safer than indoor for gatherings or holding events. People who get sick with Coronavirus disease (COVID-19) will experience mild to moderate symptoms and recover without special treatments.</p>

                            <p>You can feel free to use this CSS template for your medical profession or health care related websites. You can <a rel="nofollow" href="http://paypal.me/templatemo" target="_blank">support us a little</a> via PayPal if this template is good and useful for your work.</p>
                        </div>

                        <div class="col-lg-4 col-md-5 col-12 mx-auto">
                            <div class="featured-circle bg-white shadow-lg d-flex justify-content-center align-items-center">
                                <p class="featured-text"><span class="featured-number">12</span> Years<br> of Experiences</p>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <section class="gallery">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-6 ps-0">
                            <img src="images/gallery/medium-shot-man-getting-vaccine.jpg" class="img-fluid galleryImage" alt="get a vaccine" title="get a vaccine for yourself">
                        </div>

                        <div class="col-lg-6 col-6 pe-0">
                            <img src="images/gallery/female-doctor-with-presenting-hand-gesture.jpg" class="img-fluid galleryImage" alt="wear a mask" title="wear a mask to protect yourself">
                        </div>

                    </div>
                </div>
            </section>


                    </div>
                </div>
            </section>

            <section class="section-padding" id="booking">
                <div class="container">
                    <div class="row">
                    
@include('components.footer')

                    </div>
                </div>
            </section>
        @endsection

        