@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endpush

@section('content')

<style>
    /* Color Palette */
    :root {
        --green-primary: #058248;
        --green-light: #03a65a;
        --orange: #FF6B35;
        --yellow: #FFC914;
        --blue: #4A90E2;
        --coral: #FF5A5F;
        --purple: #9B59B6;
        --pink: #E74C3C;
    }
    
    /* Hero Section */
    .hero {
        position: relative;
        min-height: 85vh;
        background: linear-gradient(135deg, var(--green-primary) 0%, var(--green-light) 100%);
        display: flex;
        align-items: center;
        color: white;
        overflow: hidden;
    }
    
    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://img.freepik.com/free-photo/happy-university-students-using-laptop-while-sitting-hallway_637285-9244.jpg') center/cover no-repeat;
        opacity: 0.15;
    }
    
    /* Floating shapes for hero */
    .hero-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    
    .shape {
        position: absolute;
        border-radius: 50%;
        opacity: 0.1;
        animation: float 20s infinite;
    }
    
    .shape-1 {
        width: 300px;
        height: 300px;
        background: var(--orange);
        top: 10%;
        left: -5%;
        animation-delay: 0s;
    }
    
    .shape-2 {
        width: 200px;
        height: 200px;
        background: var(--yellow);
        bottom: 20%;
        right: 10%;
        animation-delay: 5s;
    }
    
    .shape-3 {
        width: 150px;
        height: 150px;
        background: var(--blue);
        top: 60%;
        left: 15%;
        animation-delay: 10s;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-30px) rotate(180deg); }
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
    }
    
    .hero h1 {
        font-size: 3rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    .hero p.lead {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        opacity: 0.95;
    }
    
    .cta-primary {
        background: #fff;
        color: var(--green-primary);
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
    
    .cta-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        color: var(--green-primary);
    }
    
    .cta-secondary {
        background: transparent;
        color: #fff;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        border: 2px solid #fff;
        transition: all 0.3s ease;
    }
    
    .cta-secondary:hover {
        background: #fff;
        color: var(--green-primary);
    }
    
    .hero-stats {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255,255,255,0.3);
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        display: block;
    }
    
    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    /* Section Styling */
    .section-header {
        text-align: center;
        margin-bottom: 4rem;
    }
    
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1rem;
        position: relative;
        display: inline-block;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--orange), var(--yellow));
        border-radius: 2px;
    }
    
    .section-subtitle {
        font-size: 1.1rem;
        color: #718096;
        max-width: 600px;
        margin: 1.5rem auto 0;
    }

    /* Colorful Feature Cards */
    .feature-card {
        background: #fff;
        border-radius: 20px;
        padding: 2.5rem;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    
    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, var(--orange), var(--yellow));
    }
    
    .feature-card:nth-child(2)::before {
        background: linear-gradient(90deg, var(--blue), var(--green-light));
    }
    
    .feature-card:nth-child(3)::before {
        background: linear-gradient(90deg, var(--coral), var(--purple));
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        border-color: var(--green-primary);
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        position: relative;
    }
    
    .feature-card:nth-child(1) .feature-icon {
        background: linear-gradient(135deg, var(--orange) 0%, var(--yellow) 100%);
    }
    
    .feature-card:nth-child(2) .feature-icon {
        background: linear-gradient(135deg, var(--blue) 0%, var(--green-light) 100%);
    }
    
    .feature-card:nth-child(3) .feature-icon {
        background: linear-gradient(135deg, var(--coral) 0%, var(--purple) 100%);
    }
    
    .feature-icon i {
        font-size: 2rem;
        color: #fff;
    }
    
    .feature-card h3 {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #2d3748;
    }
    
    .feature-card p {
        color: #718096;
        line-height: 1.7;
    }

    /* Colorful Step Cards */
    .step-card {
        position: relative;
        padding-left: 5rem;
        margin-bottom: 3rem;
    }
    
    .step-number {
        position: absolute;
        left: 0;
        top: 0;
        width: 65px;
        height: 65px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        font-weight: 700;
        color: #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .step-card:nth-child(1) .step-number {
        background: linear-gradient(135deg, var(--orange) 0%, var(--yellow) 100%);
    }
    
    .step-card:nth-child(2) .step-number {
        background: linear-gradient(135deg, var(--blue) 0%, var(--green-light) 100%);
    }
    
    .step-card:nth-child(3) .step-number {
        background: linear-gradient(135deg, var(--coral) 0%, var(--purple) 100%);
    }
    
    .step-card h4 {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #2d3748;
    }
    
    .step-card p {
        color: #718096;
        line-height: 1.6;
    }

    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, var(--green-primary) 0%, var(--green-light) 100%);
        color: #fff;
        padding: 6rem 0;
        margin: 6rem 0;
        position: relative;
        overflow: hidden;
    }
    
    .cta-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: var(--yellow);
        border-radius: 50%;
        opacity: 0.1;
    }
    
    .cta-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 400px;
        height: 400px;
        background: var(--orange);
        border-radius: 50%;
        opacity: 0.1;
    }
    
    .cta-section h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }
    
    .cta-section p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        opacity: 0.95;
    }

    /* Benefits with colorful icons */
    .benefit-item {
        display: flex;
        align-items: start;
        margin-bottom: 2rem;
        padding: 1rem;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .benefit-item:hover {
        background: #f7fafc;
        transform: translateX(10px);
    }
    
    .benefit-icon {
        width: 50px;
        height: 50px;
        min-width: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.5rem;
    }
    
    .benefit-item:nth-child(1) .benefit-icon {
        background: linear-gradient(135deg, var(--orange), var(--yellow));
    }
    
    .benefit-item:nth-child(2) .benefit-icon {
        background: linear-gradient(135deg, var(--blue), var(--green-light));
    }
    
    .benefit-item:nth-child(3) .benefit-icon {
        background: linear-gradient(135deg, var(--coral), var(--purple));
    }
    
    .benefit-item:nth-child(4) .benefit-icon {
        background: linear-gradient(135deg, var(--green-primary), var(--blue));
    }
    
    .benefit-icon i {
        color: #fff;
        font-size: 1.3rem;
    }
    
    .benefit-item h5 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #2d3748;
    }
    
    .benefit-item p {
        color: #718096;
        margin: 0;
        line-height: 1.5;
    }

    /* Image decorations */
    .image-decoration {
        position: relative;
    }
    
    .image-decoration::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--orange) 0%, var(--yellow) 100%);
        border-radius: 20px;
        transform: rotate(-6deg);
        z-index: -1;
        opacity: 0.2;
    }
    
    .image-decoration img {
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }

    /* App Download Section */
    .app-download-section {
        background: linear-gradient(135deg, #f7fafc 0%, #e6f7f1 100%);
        padding: 6rem 0;
        position: relative;
        overflow: hidden;
    }
    
    .app-download-section::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: var(--green-light);
        border-radius: 50%;
        opacity: 0.05;
        transform: translate(30%, -30%);
    }
    
    .app-badge {
        height: 60px;
        transition: all 0.3s ease;
        filter: drop-shadow(0 4px 10px rgba(0,0,0,0.1));
    }
    
    .app-badge:hover {
        transform: scale(1.05);
    }
    
    /* Decorative blobs */
    .blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        opacity: 0.3;
        z-index: 0;
    }
    
    .blob-1 {
        width: 400px;
        height: 400px;
        background: var(--yellow);
        top: -10%;
        left: -5%;
    }
    
    .blob-2 {
        width: 350px;
        height: 350px;
        background: var(--blue);
        bottom: -15%;
        right: -8%;
    }

    /* Contact Cards */
    .contact-card {
        background: #fff;
        border-radius: 15px;
        padding: 2rem;
        border-left: 4px solid var(--green-primary);
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    /* Spacing utilities */
    .py-80 { padding-top: 6rem; padding-bottom: 6rem; }
    .my-80 { margin-top: 6rem; margin-bottom: 6rem; }
    
    /* Badge colors */
    .badge-orange { background: linear-gradient(135deg, var(--orange), var(--yellow)); }
    .badge-blue { background: linear-gradient(135deg, var(--blue), var(--green-light)); }
    .badge-coral { background: linear-gradient(135deg, var(--coral), var(--purple)); }
    
    @media (max-width: 768px) {
        .hero h1 { font-size: 2rem; }
        .hero p.lead { font-size: 1.1rem; }
        .section-title { font-size: 2rem; }
        .stat-number { font-size: 2rem; }
        .shape { display: none; }
    }
</style>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    
    <div class="container hero-content">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1>Find Your Perfect Peer Tutor Today</h1>
                <p class="lead">
                    Connect with qualified student tutors at South African universities, colleges, and TVET institutions. 
                    Get the academic support you need to excel in your studies.
                </p>
                
                <!-- Primary CTA -->
                <div class="mb-4">
                    <a href="/instructors" class="btn cta-primary me-3 mb-3">
                        <i class="fas fa-search me-2"></i>Find a Tutor Now
                    </a>
                    <a href="/become-instructor" class="btn cta-secondary mb-3">
                        Become a Tutor
                    </a>
                </div>
                
                <!-- Quick Search -->
                <form action="/search" method="get" class="mt-4">
                    <div class="input-group input-group-lg" style="max-width: 500px;">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search by subject or course...">
                        <button type="submit" class="btn btn-light" style="border-top-left-radius:0;border-bottom-left-radius:0;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                
                <!-- Stats 
                <div class="hero-stats">
                    <div class="row">
                        <div class="col-4">
                            <div class="stat-item">
                                <span class="stat-number">500+</span>
                                <span class="stat-label">Active Tutors</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <span class="stat-number">2000+</span>
                                <span class="stat-label">Students Helped</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <span class="stat-number">4.8★</span>
                                <span class="stat-label">Average Rating</span>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
            
            <div class="col-lg-5 d-none d-lg-block text-center">
                <div class="image-decoration">
                    <img src="{{ asset('assets/default/img/home/app.png') }}" 
                         alt="TeachMe App" 
                         class="img-fluid" 
                         style="max-height: 500px;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-80">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">How It Works</h2>
            <p class="section-subtitle">Get started with TeachMe App in three simple steps</p>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h4>Search & Browse</h4>
                    <p>Find tutors by Course, Institution, availability, and or rating. Filter results to match your exact needs.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h4>Book a Session</h4>
                    <p>Choose a time that works for you and book directly through the platform. Get instant confirmation.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h4>Learn & Succeed</h4>
                    <p>Meet online, get the support you need, and monitor your academic progress every step of the way.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visual Break - Students Learning -->
<section class="py-5" style="background: linear-gradient(135deg, #f7fafc 0%, #fff 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="image-decoration">
                    <img src="{{ asset('assets/default/img/home/student.jpg') }}" 
                         alt="Students studying together" 
                         class="img-fluid">
                </div>
            </div>
            <div class="col-md-6 ps-md-5">
                <span class="badge badge-orange text-white px-3 py-2 mb-3">
                    <i class="fas fa-star me-2"></i>Student Success
                </span>
                <h3 class="fw-bold mb-3" style="font-size: 2rem; color: #2d3748;">
                    Join Other Students Already Excelling
                </h3>
                <p class="text-muted" style="font-size: 1.1rem; line-height: 1.7;">
                    Our peer tutoring platform has helped students improve their grades by an average of 15-20%. 
                    Whether you're struggling with a difficult course or want to maintain your top performance, 
                    we have the right tutor for you.
                </p>
              <!--  <div class="mt-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="badge badge-blue text-white me-3" style="font-size: 1.5rem; padding: 0.5rem 1rem;">
                            95%
                        </div>
                        <span class="text-muted">Students report improved understanding</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="badge badge-coral text-white me-3" style="font-size: 1.5rem; padding: 0.5rem 1rem;">
                            88%
                        </div>
                        <span class="text-muted">Would recommend to a friend</span>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-80" style="background: #f7fafc;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">What We Offer</h2>
            <p class="section-subtitle">Everything you need for academic success</p>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-users text-white fs-2"></i>
                    </div>
                    <h3>Verified Peer Tutors</h3>
                    <p>Our tutors are graduates and high-performing university and TVET students who have excelled in their courses and successfully passed our verification process.</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check text-white fs-2"></i>
                    </div>
                    <h3>Flexible Scheduling</h3>
                    <p>Book sessions that fit your schedule and choose how long you'd like each session to be. Learn from anywhere, at any time.</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-graduation-cap text-white fs-2"></i>
                    </div>
                    <h3>Exam Preparation</h3>
                    <p>Receive focused support for your coursework, assignments, tests, and exams from tutors who understand the curriculum and know what it takes to succeed.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-80 position-relative" style="overflow: hidden;">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="image-decoration">
                    <img src="{{ asset('assets/default/img/home/students2.jpg') }}" 
                         alt="Students collaborating" 
                         class="img-fluid">
                </div>
            </div>
            
            <div class="col-lg-6 ps-lg-5">
                <h2 class="section-title text-start">Why Students Choose TeachMe App</h2>
                <p class="text-muted mb-5" style="font-size: 1.1rem;">
                    We're dedicated to bridging the academic gap and ensuring every student has access to quality peer support.
                </p>
                
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h5>Affordable Rates</h5>
                        <p>Peer tutoring at prices students can actually afford</p>
                    </div>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h5>Same Curriculum Understanding</h5>
                        <p>Tutors who recently took the same courses you're struggling with</p>
                    </div>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h5>Mobile & Web Access</h5>
                        <p>Book and manage sessions from anywhere, anytime</p>
                    </div>
                </div>
                <!--
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h5>Proven Results</h5>
                        <p>Students see average grade improvements of 10-20%</p>
                    </div>
                </div>
            -->
                <a href="/register" class="btn btn-primary btn-lg mt-4" style="background: var(--green-primary); border: none; box-shadow: 0 4px 15px rgba(5,130,72,0.3);">
                    <i class="fas fa-user-plus me-2"></i>Get Started Free
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Become a Tutor CTA -->
<section class="cta-section position-relative">
    <div class="container text-center position-relative" style="z-index: 1;">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0 d-none d-lg-block">
                <img src="{{ asset('assets/default/img/home/student3.jpg') }}" 
                     alt="Happy tutor teaching" 
                     class="img-fluid rounded-circle"
                     style="box-shadow: 0 20px 60px rgba(0,0,0,0.3); border: 8px solid rgba(255,255,255,0.2);">
            </div>
            <div class="col-lg-7 text-lg-start">
                <span class="badge bg-white text-dark px-3 py-2 mb-3">
                    <i class="fas fa-coins me-2" style="color: var(--yellow);"></i>Earn While You Learn
                </span>
                <h2>Earn Money Sharing Your Knowledge</h2>
                <p>
                    Join hundreds of student tutors earning up to 70% commission while helping fellow students succeed. 
                    Set your own rates and schedule.
                </p>
                <div class="mb-4">
                    <a href="/become-instructor" class="btn cta-primary btn-lg me-3">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Apply to Become a Tutor
                    </a>
                    <a href="#" class="btn cta-secondary btn-lg" data-bs-toggle="modal" data-bs-target="#tutorInfoModal">
                        Learn More
                    </a>
                </div>
                
                <!-- Mini stats for tutors -->
                <div class="row mt-5 text-start">
                   <!-- <div class="col-4">
                        <h4 class="fw-bold mb-1">R+</h4>
                        <small style="opacity: 0.9;">Decide Your Earnings</small>
                    </div>-->
                    <div class="col-6">
                        <h4 class="fw-bold mb-1">70%</h4>
                        <small style="opacity: 0.9;">Commission Rate</small>
                    </div>
                    <div class="col-6">
                        <h4 class="fw-bold mb-1">Flexible</h4>
                        <small style="opacity: 0.9;">Set Your Schedule</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- App Download Section -->
<section class="app-download-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0 text-center text-lg-start">
                <h2 class="section-title text-start">Download Our Mobile App</h2>
                <p class="text-muted mb-4">
                    Get the full TeachMe experience on your phone. Book sessions, chat with tutors, 
                    and manage your learning on the go.
                </p>
                
                <div class="d-flex flex-column flex-sm-row align-items-start">
                     <a href="https://play.google.com/store">
                        <img style="height: 6rem;" loading="lazy" src="data:image/png;base64,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"/>
                </a>
                    <p class="text-muted small mt-2">*iOS version coming soon</p>
                </div>
            </div>
            
            <div class="col-lg-6 text-center">
                <img src="{{ asset('assets/default/img/home/app.png') }}" 
                     alt="Mobile App Preview" 
                     class="img-fluid" 
                     style="max-height: 400px;">
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-80" style="background: linear-gradient(to bottom, #fff 0%, #f7fafc 100%);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Get in Touch</h2>
            <p class="section-subtitle">Have questions? We're here to help you succeed!</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 mb-4">
                <div class="contact-card h-100">
                    <div class="mb-3">
                        <div class="d-inline-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--orange), var(--yellow)); border-radius: 15px;">
                            <i class="fas fa-envelope fa-2x text-white"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-2">Email Us</h5>
                    <p class="text-muted mb-3">Get a response within 24 hours</p>
                    <a href="mailto:Info@teachmeapp.co.za" class="text-decoration-none fw-bold" style="color: var(--green-primary);">
                        Info@teachmeapp.co.za
                    </a>
                </div>
            </div>
            
            <div class="col-lg-5 col-md-6 mb-4">
                <div class="contact-card h-100">
                    <div class="mb-3">
                        <div class="d-inline-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--blue), var(--green-light)); border-radius: 15px;">
                            <i class="fab fa-whatsapp fa-2x text-white"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-2">WhatsApp Us</h5>
                    <p class="text-muted mb-3">Chat with us instantly</p>
                    <a href="https://wa.me/27713364034" class="text-decoration-none fw-bold" style="color: var(--green-primary);">
                        +27 71 336 4034
                    </a>
                </div>
            </div>
        </div>
        {{-- 
        <div class="row mt-5">
            <div class="col-12">
                <div class="p-5 rounded-3" style="background: linear-gradient(135deg, #f7fafc 0%, #e6f7f1 100%);">
                    <h4 class="fw-bold mb-4 text-center">Quick Links</h4>
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3">
                            <a href="/about" class="text-decoration-none d-flex align-items-center">
                                <div class="me-2" style="width: 40px; height: 40px; background: var(--orange); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-info-circle text-white"></i>
                                </div>
                                <span style="color: #2d3748;">About Us</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <a href="/faq" class="text-decoration-none d-flex align-items-center">
                                <div class="me-2" style="width: 40px; height: 40px; background: var(--blue); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-question-circle text-white"></i>
                                </div>
                                <span style="color: #2d3748;">FAQ</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <a href="/terms" class="text-decoration-none d-flex align-items-center">
                                <div class="me-2" style="width: 40px; height: 40px; background: var(--coral); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-file-contract text-white"></i>
                                </div>
                                <span style="color: #2d3748;">Terms</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <a href="/privacy" class="text-decoration-none d-flex align-items-center">
                                <div class="me-2" style="width: 40px; height: 40px; background: var(--purple); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-shield-alt text-white"></i>
                                </div>
                                <span style="color: #2d3748;">Privacy</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        --}}
    </div>
</section>

<!-- Tutor Info Modal -->
<div class="modal fade" id="tutorInfoModal" tabindex="-1" aria-labelledby="tutorInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tutorInfoModalLabel">Becoming a Tutor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold mb-3">Requirements:</h6>
                <ul>
                    <li>Currently enrolled at a South African university, college, or TVET institution</li>
                    <li>Achieve 70% or Higher in your Grade Pass Average </li>
                    <li>75% or higher in a module or Subject you tutor in</li>
                    <li>Good communication skills</li>
                    <li>Reliable and committed to helping students succeed</li>
                </ul>
                
                <h6 class="fw-bold mb-3 mt-4">Benefits:</h6>
                <ul>
                    <li>Earn up to 70% commission on all sessions</li>
                    <!--<li>Set your own rates and availability</li>-->
                    <li>Build your teaching portfolio</li>
                    <li>Help fellow students while earning money</li>
                    <li>Flexible - work around your own study schedule</li>
                </ul>
                
                <h6 class="fw-bold mb-3 mt-4">How to Apply:</h6>
                <ol>
                    <li>Click "Apply to Become a Tutor"</li>
                    <li>Complete the registration form</li>
                    <li>Upload your academic transcript</li>
                    <li>Wait for verification (usually 24-48 hours)</li>
                    <li>Start tutoring and earning!</li>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="/become-instructor" class="btn btn-primary">Apply Now</a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts_bottom')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
@endpush