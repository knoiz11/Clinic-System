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
                        
                        @if(isset($doctorStatus) && $doctorStatus->is_in)
                            <span class="text-success fw-bold" id="doctorStatusText" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">IN</span>
                        @else
                            <span class="text-danger fw-bold" id="doctorStatusText" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">OUT</span>
                        @endif
                    </h1>

                    <p class="mb-4" style="color: var(--ccp-light)" id="doctorStatusMessage">
                        @if(isset($doctorStatus) && $doctorStatus->is_in)
                            The doctor is currently available for consultations.
                        @else
                            The doctor is currently unavailable. Please check back later.
                        @endif
                    </p>

                    <div class="heroLinks d-flex flex-wrap align-items-center">
                        <a class="custom-link me-4" href="#about" data-hover="Learn More">Learn More</a>
                        <p class="contact-phone mb-0" style="color: var(--ccp-light)">
                            <i class="bi-phone" style="color: var(--ccp-light)"></i> 010-020-0340
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding" id="about">
    <div class="container">
        <div class="row">
            <div>
                <h2 class="mb-3">Meet Dr. Carson</h2>

                <p>Protect yourself and others by wearing masks and washing hands frequently. Outdoor is safer than indoor for gatherings or holding events. People who get sick with Coronavirus disease (COVID-19) will experience mild to moderate symptoms and recover without special treatments.</p>

                <p>You can feel free to use this CSS template for your medical profession or health care related websites. You can <a rel="nofollow" href="http://paypal.me/templatemo" target="#">support us a little</a> via PayPal if this template is good and useful for your work.</p>
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

<section class="section-padding" id="booking">
    <div class="container">
        <div class="row">
            @include('components.footer')
        </div>
    </div>
</section>

<!-- Auto-refresh doctor status every 30 seconds -->
<script>
async function refreshDoctorStatus() {
    try {
        const response = await fetch('/doctor-status');
        const data = await response.json();
        
        const statusText = document.getElementById('doctorStatusText');
        const statusMessage = document.getElementById('doctorStatusMessage');
        
        if (statusText && statusMessage) {
            // Update status text
            statusText.textContent = data.is_in ? 'IN' : 'OUT';
            statusText.className = data.is_in ? 'text-success fw-bold' : 'text-danger fw-bold';
            statusText.style.textShadow = '2px 2px 4px rgba(0,0,0,0.5)';
            
            // Update message
            statusMessage.textContent = data.is_in 
                ? 'The doctor is currently available for consultations.'
                : 'The doctor is currently unavailable. Please check back later.';
        }
    } catch (error) {
        console.error('Error fetching doctor status:', error);
    }
}

// Refresh every 30 seconds
setInterval(refreshDoctorStatus, 30000);
</script>
@endsection