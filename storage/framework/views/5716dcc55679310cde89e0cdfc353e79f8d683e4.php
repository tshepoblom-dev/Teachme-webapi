<?php $__env->startPush('styles_top'); ?>
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
    <!-- Include Font Awesome for social media icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>




  <style>
     .hero {
            position: relative;
            min-height: 70vh; /* Increased height */
            background: url('https://img.freepik.com/free-photo/happy-university-students-using-laptop-while-sitting-hallway_637285-9244.jpg?t=st=1742467627~exp=1742471227~hmac=dc810f71fefb396597aae76088cbbcddd4835c130e211e6d209f65c70c5c7e51&w=1800') center/cover no-repeat;
            display: flex;
            align-items: center;
            color: white;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent black overlay */
        }
        .hero-content {
            position: relative;
            z-index: 1;
        }
        .btn-light {
            color: #000;
        }
</style>
<!-- Hero Section -->
<section class="hero text-white text-center py-5">
    <div class="hero-overlay"></div>
    <div class="container py-4 hero-content">
        <div class="row align-items-center">
            <!-- Left Side: Text Content -->
            <div class="col-lg-6 text-lg-start">
                <h1 class="fw-bold display-5">Connecting Students & Tutors for Seamless Learning!</h1>
                <p class="mt-3 fs-5">
                    Find expert tutors, book sessions, and improve your skills – all in one place.
                </p>
                <div class="mt-4">
                    <!-- Trigger Modal Button -->
                   
                    <a href="/instructors" class="btn btn-light btn-md me-2 px-4 py-2">Find a tutor</a>
                    <a href="/become-instructor" class="btn btn-outline-light btn-md me-2 px-4 py-2">Become a Tutor</a>
                    <a href="<?php echo e(url('/download-app')); ?>" target="_blank" class="btn btn-dark btn-md px-4 py-2">Download the App</a>
                </div>
            </div>
            <!-- Right Side: Image -->
            <div class="col-lg-6 mt-4 mt-lg-0">
                <img src="<?php echo e(asset('assets/default/img/home/app.png')); ?>" style="height: 20rem;" alt="TeachMe App" class="img-fluid rounded shadow-lg">
            </div>
        </div>
    </div>
</section>


<div class="container">

    <!-- WHO ARE WE SECTION -->
    <section class="section my-40" id="who-we-are">
      <div class="row align-items-center">
        <div class="col-md-7 order-md-1 order-2">
          <h1 class="font-28 font-weight-bold text-dark my-15">Who Are We?</h1>
          <p>Teachme App was established in 2022 with the mission of providing tertiary students with high-quality peer tutoring services to support them in achieving their academic goals. <br>Our mission has always been to empower you and ensure your academic success through effective, collaborative peer support. With our platform, you’ll have access to dedicated peer tutors who are here to help you achieve your goals and excel in your studies. <br>Join us and experience the benefits of learning with peers who are committed to your success!</p>
        </div>
        <div class="col-md-5 order-md-2 order-1 image-col">
          <img src="<?php echo e(asset('assets/default/img/home/teach5.png')); ?>" class="img-fluid about-us-img rounded" alt="About Us Image">
        </div>
      </div>
    </section>


<section class="container my-40">
    <div class="text-center mb-4">
        <h1 class="fw-bold text-dark font-weight-bold font-28 my-15">Our Services</h1>
        <p class="text-muted">Empowering tertiary students in South Africa with top-notch peer tutoring.</p>
    </div>

    <div class="row">
        <!-- Service 1 -->
        <div class="col-md-4 text-center">
            <div class="p-4 shadow-sm rounded bg-white">
                <i class="fas fa-mobile-alt fa-3x text-primary mb-3"></i>
                <h2 class="fw-bold">Mobile & Web App</h2>
                <p class="text-muted">Access tutoring services anytime, anywhere with our user-friendly platform.</p>
            </div>
        </div>

        <!-- Service 2 -->
        <div class="col-md-4 text-center">
            <div class="p-4 shadow-sm rounded bg-white">
                <i class="fas fa-chalkboard-teacher fa-3x text-primary mb-3"></i>
                <h2 class="fw-bold">Skilled Peer Tutors</h2>
                <p class="text-muted">We carefully select the best tutors to provide exceptional academic support.</p>
            </div>
        </div>

        <!-- Service 3 -->
        <div class="col-md-4 text-center">
            <div class="p-4 shadow-sm rounded bg-white">
                <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
                <h2 class="fw-bold">Exam & Test Prep</h2>
                <p class="text-muted">Get fully prepared for your tests and exams with expert peer tutoring.</p>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid container d-flex align-items-center mb-50">
    <div class="row w-100">
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="text-center">
                <h2>Get Our App</h2>
                <p class="lead">Download the app version on...</p>
                <a href="https://play.google.com/store">
                        <img style="height: 6rem;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAWkAAACLCAMAAACUXphBAAABMlBMVEX///8AAADr6+uOjo6vr69ChfQ0qFPqQzX7vAQ2Njb8/PyGhoaUlJTw8PAyZLhDh/hSUlLJycmAgIBZWVnT09MuLi6bm5snJyf39/fl5eWpqal4eHhycnJmZmZfX1/a2tpERERHR0e6uroPDw/Ozs7ExMS4uLg0NDQcHBwfHx80qUwpp1WioqILCwtDg/vpPTY8lqw8lLXhRj0xnU4zq0Dsugv/xATwdCXpOTdwd88GEggVRSIZUCcOLxctkkghaTQSORwldjoUOS0eYDApT5g6laMJHg8qhkI/WCBaq0nWnwBKOAGzhgMeFgCRbQPprwRuUgJlrEZWjKffR0OUbwMrIADCkgPrQCQ3KQF0dsvdpgOOTRSkLyUlCgnANywwDgtiHBaFJh5IFRE3JDYZBwZhHBbq6cttAAAMwUlEQVR4nO2d+YOjthXHBWYOc3TwxQA2xtjGR9fettl0203SbNI727TpkR7ZbrebNv3//4VKTwLEZQ8M9ni8+v4yY07po8fTk5AEQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQu+7ZKG76N6YlaneEtovfaEY9+DsbHTXVYTuItfVldqGHWLOXXMlCe3VdjXWXLc1rwd6Ybnd24fOwiNSu6VYizqgO5Y7eujEPzKNXMuvDtoRoKtr6OrVfbXlth463Y9Q+kapClq23PZDJ/sRauLqdkXS4UaYdB3pm2lF0lN3/NCJfpQauZ1qoNWWIpxHHZnuRq1GWhOka2mp6IL0UdQWpI8kQfpYEqSPpWZJf/TxJz9rJFndzTR0uzSFc6r+SFLmkZawqzefxrvnc2UbZ8pSwoU1oT/mfQv+rsL+g5pIk6Q//vSS6OW9E+Wx1pRN2kiT6M665MSpoBSHSJbMeJsTkQ7Zhuma/MLZG5K/a5Wd9UBqkPTLS6Znn9wvTS1MTRkOFQzWw6RVFJhEAwn/HctIw39mcOAIOdLMNAMNyWPTZBwHPkKd1kgLVWQM8G9cajLpSV/b50L6k8tEn352jySNEFLAGtdTXQLS3M61g0zuSAf+mshZxxtDZNNGLH4yOviPbcvIlc6J9LNLXp9/VDtJDgr5n2nStw7qxT8i0j3kxC8mPISi3oIxQiNMWtXA25wN6Z9//zKtX9RMkYdUk/9dkXQH+fH+BSkzGw0WZNvZkP7lDz/MoK7prjWKatsGLQnpxRRrAxXeXtI+0uL9OrmUjdorA7XOh/T3nv4qa9WXv6njrhnptmqD1hOWPgdqwTuQ7nKXkm8lAriL7PbqbEjf3ORRX37+68op6lJ8S8OAUSmE9GiI5cHeO5BOus8t1JeAtNRH4fZ8SF8UoX5W2V33VORF/wdIXVX001O2jSikfhoDDlQ0NM6H9MXTnK+uE/E5xBKpCKqKpHsQcLDdJAyhpuwi+4xsmqDOWzV219Va6IGNaLt5pSAcPFckjZmyOhE3gKZSRBqX37m0EYF0CeqK0TVucthzywqxl25BlGdtiCD22096NSVNTIu0MH0SrjDSnorOivTFTTHqahFfwEah+KTDIojuTBqM0q2MkteYpN+DaExijEQbOrLC3kC0EgHGBRBUSUTTapo0Rl3gqyu7a0+zrBatGAeWDrLApmeatYyPmlg0zlha2ow/+3aoW/pwQH9YFi2FVfTPA6lx0sXVIrjr+g30c1DzpMt8NdbLbdGZ74kOQLrMVxN3/dtj5+90dAjSpaiffPHjV787dg5PRQchXVItYtDX19df/v7YeTwNHYb0xdMf5VFT0NfPr/9w7EyehA5EGqPOOpAnX1wzPf/qj8fO5gnoUKQvbjKomUUzvYfu+mCkM6if/IkHfUd3PZuYI23Um8z2H3r6OhxpjPrDEoumLmSfuw6m0dQQfxE0l+PBeDzu7Sy7tTeO1UsmqPXwz3uk44CkuWoxD5qwfrWrIdNLz8BpblSMhq9mL3cdYabu7OhsMxmEMq9/30OSjqvFpDJM61Vpsmb58fN66cHV1MXXMga7jjAzd7ZpBwyZKdupf9+Dkma+OuejY6sucyCDaLSS4fhONBd4Wj+XvKqTZoOgTpo0oC4FfX39ujhRawrXXozaK2k18UIYPdbQ9Jo7kjbY/HpKh1j1aZMmqIt8dGTUhWmaURcdct2jHcS98r6f7kg6ekU2hsSQNw4nTvri6Z/LQV8/Lwz16MQ9LbWtpRUdWUd3JD2Mf8KU7+7Jk7558YOf7CBddKUx4m2qcVUmPSCAwlMnffPig6sdqL8quhI8rpv6WdqjyqRhlLB94qRvXvzl6qoc9fOvi/JJ0uMcrllYnTTxZuppkyYWfQWonxeSLgw9NuQue73y7ajVapnZrZNuqzXMtkpmHt6YvEJMk+61Wnr2MlnSizzpwdANrVElczgk6ZsXV0w/LUL9/PVfiy4EofSeVHdZA1Jd8Ma5YZG3zDdy2myGwLxt4ZgtTJFeskU37LSvypImKfJ50t0o3O+T9/RdHBAa8bArqYNv4wT5NB+y3yMGTVDnSX9d3BhHaN9DOuAb6nHwN+YmwMuxmVrxNpuc1edJt5KcG/yDkCGtk586RzpMboQUjNCgF6bqQbEWpPqAfXnMdVwxB5Lh/Ld/FGNcsfRH8ixeJP/L9EIZLj1ulNrIGtBSdqUHnrTO75C5hyMVT5OhUPh6k4R0mLqiS29iR2ULj0nRzPrD9U+nQGdRvy59FwADabinOc2KmA59dJ2NNaVWDNYH9SgZ+rTpw3/qKqaEjIUVLe/Fke7RfUpXd6Ir86SVYZeILTVDipORpuf5m2gZq0CawPHMUEia/KKn9VCks6D5anFnh2mWtJu6uz+jpqiCza6hHwrGLwGQOYxWCoAczOBAycU2WdJ9OGob70vaoPl+DygGRvq25US+RWE3Iosc2PRc0lNYXJ8fiPTNi79fZRX76i/LOee9R5Y0GI3a5vfqzHfE3hFQT9jeqLtET5MO4uLAHopATAYD50jTvq2kRhxHTnxBC9pM8PoJ9KOQ5ivDLOoyBx0pxQw7AD8SrXi8JFdYWwJVhkF3SI1rNWhlbqRtGmC6RiSQbGLRA515ltgzZ0j7bAcX5a00N/Sn1hiODOil4UZteuejkb75Jus6Yl9d7qB5ICiJVLczJnhG5/DEGkl0TGILdQ0UuBlfDkBdpgoFfERCukPPGC9YyOIP44l2wM+hxTvfxO9nYtIDhZ2jQk9fwHwGcV3gT4qH/x1kDFMJaIz6n/s4s7isyNORCkiB/p7ETqF+Uk14H8JF0STDPpg2Nw/MTJEmBWqNWLxohz3uRunYI1ZEOsgsEhZI9H3MAjeSMiXO6wCki10H0Zt/leHl80nSI+ebX2OyfQwVGUe6TanY6dIhMYcz81Cq3R3wpGfE7FnO5VbaCrMtF6aIdHbhqkCKHy2oLkoWT2qedFFlCHr77zK4acFyRUpuM0GsbrM2DXYbQO4590jcNrPpxFjTNt2PMhR6Uka7SUM168BJvTAi3SYJaMFF/dyJVM2Pn/6mhPO7khTkREPj7BsWCB0WNKNGkgLo/ZmBZ+EaljKK/XRynbSfpu0Pp2hM9U7S8DBERe1FpKGC9UvcDlXjcwJKfPS3FQb00tDXSm2jbZCowRGb78CgVgQ1UWy+BCZx2ywwodrKKdJQHbjRzgmfp52kbw2u+KYxaTgHQpCybqeGSZeAfnNHx8FEn+xOcp/2NIY/g/ooeuLBMjVmXA4L85YQti1ZkUV+CAojIQ1xu8zKf+DYnCnuJ81KGkIOFMD/0WK8Vu68KA+Nki6uDN/+Zx/arFhIEMKKwDMvpElkHWmI0cWJhyKBdT3AuVPvSVcHAcBw3hQuQsuKayMCedrpNpajw0C7/TTUF1DrsY4TuAR7U4Ts0hkejZIurAw/uLOD5tQvuHPkh6n1qJ2QlgeN4wY0IpCnIW2HGHAo63byp9H1+B4mGqw54ZSe4aTj6VLSGjutE3GjpJl1LEqz1Ogc26LK8NvqmIk2uRsnj2WqGFTWX9FOBV8yS6OevkaKdDou9hNj3BPlcX22UcuFiJZA+aSlJueNF/joig6aUxCm0uXzUaqS7JLjanDJFUAYR9GjeI1+J6SkYbQY7G9zC52HyVIsu0iTboJVjNoBRxWw/Qjt7FhvkHQedHUHzcu0ZJukTbUNJRPzmgvYYzsav4L+sE+2qvacP3q5MchGQ9kqlLQ373Qin+z57IxUaDbBR8zz7Y9pp9OhD5bm2HDJVTvERzIc0GWVi80TNbe+R85H13LQaa17nueNC59IE+/JvXddjT2vl/t8QYA3SrQKzLlROKP66+GB52XfPpJHxik8mKox0v9tyEE3rFXy2oqEJ6Ux2L0F3QK7XjQ3tw5T2ne8+e4wGaqm8SJpHAOKvPdtSiSKNHZ9DaQ50u8ac9CNCULvqB1ITNpY7zz+Hmpnel4Kjmhuvbw3DTrohkRbLpOttDIhMsn3WzUl0ri3d6610OQakP97e0IOGhS1XPr0La9xsCn6uzqmmZpd1/S7d+9Ow29E6qaSnhvz1Jig2RLsPOTc1+r1koagc8B0Ey/d333IuZOWVpov27Yt9w/5tZ9bTdPyowTTOnvSWAPTDB7+a2zvA+nTkCB9LFX/9oX4nks9Vf6ei/hGUU1V/kaR+O5WTVX/7pb4llwt1fiWnPg+Yi3V+D6i+OZnHdX65qf4jm111fuOrfg2c1XV/jaz+N54Bd3ve+NkPg9m/dAfp38kct1o8lE9ycpUbwntl75QjP0498AWuovui1lISEhISEhISEhISEhISEhISEhISEhISEhISEhISOjR6//MgZ8r7dDfygAAAABJRU5ErkJggg=="/>
                </a>
            </div>
        </div>
        <div class="col-md-6 d-md-block">
            <img src="<?php echo e(asset('assets/default/img/home/app.png')); ?>" class="img-fluid" alt="App Preview" style="height: 350px; ">
        </div>
    </div>
</div>




<section class="container my-65">
    <div class="row align-items-center">
        <!-- Text Content -->
        <div class="col-lg-6">
            <h1 class="font-2 fw-bold text-dark my-15">Why Us?</h1>
            <p class="text-muted">
                We are dedicated to bridging the gap caused by inadequate academic preparation. Our mission is to ensure every student is equipped for success and no student is left behind.
            </p>
            <ul class="list-unstyled">
                <li class="d-flex align-items-center mb-3">
                    <i class="fas fa-check-circle text-primary me-2"></i>
                    <span class="text-muted">  Personalized academic support</span>
                </li>
                <li class="d-flex align-items-center mb-3">
                    <i class="fas fa-check-circle text-primary me-2"></i>
                    <span class="text-muted">  Expert peer tutors to guide you</span>
                </li>
                <li class="d-flex align-items-center mb-3">
                    <i class="fas fa-check-circle text-primary me-2"></i>
                    <span class="text-muted">  Boost confidence & academic performance</span>
                </li>
            </ul>
            <a href="/register" class="btn btn-primary">Join Us Today</a>
        </div>

        <!-- Image -->
        <div class="col-lg-6 text-center mt-4 mt-lg-0">
            <img src="https://www.ospar.org/site/assets/files/1205/cooperation.629x0-is.png" alt="Why Us?" class="img-fluid rounded shadow">
        </div>
    </div>
</section>
<section class="container my-50">
    <div class="row align-items-center">
        <!-- How It Works (Left Side) -->
        <div class="col-md-6">
            <h3 class="fw-bold text-dark mb-3">How It Works</h3>
            <div class="d-flex align-items-start mb-3">
                <i class="fas fa-search fa-2x text-primary me-3"></i>
                <div>
                    <h6 class="fw-bold"> Search & Connect</h6>
                    <p class="text-muted"> Find tutors based on subjects, location, or availability.</p>
                </div>
            </div>
            <div class="d-flex align-items-start mb-3">
                <i class="fas fa-calendar-check fa-2x text-primary me-3"></i>
                <div>
                    <h6 class="fw-bold"> Book & Learn</h6>
                    <p class="text-muted"> Schedule a session at your convenience.</p>
                </div>
            </div>
            <div class="d-flex align-items-start mb-3">
                <i class="fas fa-chart-line fa-2x text-primary me-3"></i>
                <div>
                    <h6 class="fw-bold"> Track Progress</h6>
                    <p class="text-muted"> Get feedback and improve.</p>
                </div>
            </div>
        </div>

        <!-- Features & Benefits (Right Side) -->
        <div class="col-md-6">
            <h3 class="fw-bold text-dark mb-3">Benefits</h3>
            <div class="d-flex align-items-start mb-3">
                <i class="fas fa-book-open fa-2x text-primary me-3"></i>
                <div>
                    <h6 class="fw-bold"> Wide Subject Coverage</h6>
                    <p class="text-muted"> Find tutors for math, science, languages, and more.</p>
                </div>
            </div>
            <div class="d-flex align-items-start mb-3">
                <i class="fas fa-clock fa-2x text-primary me-3"></i>
                <div>
                    <h6 class="fw-bold"> Flexible Scheduling</h6>
                    <p class="text-muted"> Learn at your pace, anytime.</p>
                </div>
            </div>
            <div class="d-flex align-items-start mb-3">
                <i class="fas fa-user-check fa-2x text-primary me-3"></i>
                <div>
                    <h6 class="fw-bold"> Verified Tutors</h6>
                    <p class="text-muted"> Ensuring high-quality education.</p>
                </div>
            </div>

        </div>
    </div>
</section>


<div class="container py-5 mt-30">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h2 class="mb-4">Contact Us</h2>
            <p class="lead">We'd love to hear from you! Reach out to us via email or phone.</p><br>
            <div class="contact-info">
                <p><i class="fas fa-envelope"></i> Email: <a href="info@teachmeapp.africa">info@teachmeapp.africa</a></p><br>
                <p><i class="fas fa-phone-alt"></i> Phone: <a href="tel:+2771 336 4034">(+27)71 336 4034</a></p>
            </div>
        </div>
    </div>
</div>



</div>



    
    

    



    <?php $__currentLoopData = $homeSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $homeSection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$featured_classes and !empty($featureWebinars) and !$featureWebinars->isEmpty()): ?>
            <section class="home-sections home-sections-swiper container">
                <div class="px-20 px-md-0">
                    <h2 class="section-title"><?php echo e(trans('home.featured_classes')); ?></h2>
                    <p class="section-hint"><?php echo e(trans('home.featured_classes_hint')); ?></p>
                </div>

                <div class="feature-slider-container position-relative d-flex justify-content-center mt-10">
                    <div class="swiper-container features-swiper-container pb-25">
                        <div class="swiper-wrapper py-10">
                            <?php $__currentLoopData = $featureWebinars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">

                                    <a href="<?php echo e($feature->webinar->getUrl()); ?>">
                                        <div class="feature-slider d-flex h-100" style="background-image: url('<?php echo e($feature->webinar->getImage()); ?>')">
                                            <div class="mask"></div>
                                            <div class="p-5 p-md-25 feature-slider-card">
                                                <div class="d-flex flex-column feature-slider-body position-relative h-100">
                                                    <?php if($feature->webinar->bestTicket() < $feature->webinar->price): ?>
                                                        <span class="badge badge-danger mb-2 "><?php echo e(trans('public.offer',['off' => $feature->webinar->bestTicket(true)['percent']])); ?></span>
                                                    <?php endif; ?>
                                                    <a href="<?php echo e($feature->webinar->getUrl()); ?>">
                                                        <h3 class="card-title mt-1"><?php echo e($feature->webinar->title); ?></h3>
                                                    </a>

                                                    <div class="user-inline-avatar mt-15 d-flex align-items-center">
                                                        <div class="avatar bg-gray200">
                                                            <img src="<?php echo e($feature->webinar->teacher->getAvatar()); ?>" class="img-cover" alt="<?php echo e($feature->webinar->teacher->full_naem); ?>">
                                                        </div>
                                                        <a href="<?php echo e($feature->webinar->teacher->getProfileUrl()); ?>" target="_blank" class="user-name font-14 ml-5"><?php echo e($feature->webinar->teacher->full_name); ?></a>
                                                    </div>

                                                    <p class="mt-25 feature-desc text-gray"><?php echo e($feature->description); ?></p>

                                                    <?php echo $__env->make('web.default.includes.webinar.rate',['rate' => $feature->webinar->getRate()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                                    <div class="feature-footer mt-auto d-flex align-items-center justify-content-between">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <i data-feather="clock" width="20" height="20" class="webinar-icon"></i>
                                                                <span class="duration ml-5 text-dark-blue font-14"><?php echo e(convertMinutesToHourAndMinute($feature->webinar->duration)); ?> <?php echo e(trans('home.hours')); ?></span>
                                                            </div>

                                                            <div class="vertical-line mx-10"></div>

                                                            <div class="d-flex align-items-center">
                                                                <i data-feather="calendar" width="20" height="20" class="webinar-icon"></i>
                                                                <span class="date-published ml-5 text-dark-blue font-14"><?php echo e(dateTimeFormat(!empty($feature->webinar->start_date) ? $feature->webinar->start_date : $feature->webinar->created_at,'j M Y')); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="feature-price-box">
                                                            <?php if(!empty($feature->webinar->price ) and $feature->webinar->price > 0): ?>
                                                                <?php if($feature->webinar->bestTicket() < $feature->webinar->price): ?>
                                                                    <span class="real"><?php echo e(handlePrice($feature->webinar->bestTicket(), true, true, false, null, true)); ?></span>
                                                                <?php else: ?>
                                                                    <?php echo e(handlePrice($feature->webinar->price, true, true, false, null, true)); ?>

                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <?php echo e(trans('public.free')); ?>

                                                            <?php endif; ?>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="swiper-pagination features-swiper-pagination"></div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$latest_bundles and !empty($latestBundles) and !$latestBundles->isEmpty()): ?>
            <section class="home-sections home-sections-swiper container">
                <div class="d-flex justify-content-between ">
                    <div>
                        <h2 class="section-title"><?php echo e(trans('update.latest_bundles')); ?></h2>
                        <p class="section-hint"><?php echo e(trans('update.latest_bundles_hint')); ?></p>
                    </div>

                    <a href="/classes?type[]=bundle" class="btn btn-border-white"><?php echo e(trans('home.view_all')); ?></a>
                </div>

                <div class="mt-10 position-relative">
                    <div class="swiper-container latest-bundle-swiper px-12">
                        <div class="swiper-wrapper py-20">
                            <?php $__currentLoopData = $latestBundles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $latestBundle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">
                                    <?php echo $__env->make('web.default.includes.webinar.grid-card',['webinar' => $latestBundle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination bundle-webinars-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        
        <?php if($homeSection->name == \App\Models\HomeSection::$upcoming_courses and !empty($upcomingCourses) and !$upcomingCourses->isEmpty()): ?>
            <section class="home-sections home-sections-swiper container">
                <div class="d-flex justify-content-between ">
                    <div>
                        <h2 class="section-title"><?php echo e(trans('update.upcoming_courses')); ?></h2>
                        <p class="section-hint"><?php echo e(trans('update.upcoming_courses_home_section_hint')); ?></p>
                    </div>

                    <a href="/upcoming_courses?sort=newest" class="btn btn-border-white"><?php echo e(trans('home.view_all')); ?></a>
                </div>

                <div class="mt-10 position-relative">
                    <div class="swiper-container upcoming-courses-swiper px-12">
                        <div class="swiper-wrapper py-20">
                            <?php $__currentLoopData = $upcomingCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $upcomingCourse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">
                                    <?php echo $__env->make('web.default.includes.webinar.upcoming_course_grid_card',['upcomingCourse' => $upcomingCourse], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination upcoming-courses-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$latest_classes and !empty($latestWebinars) and !$latestWebinars->isEmpty()): ?>
            <section class="home-sections home-sections-swiper container">
                <div class="d-flex justify-content-between ">
                    <div>
                        <h2 class="section-title"><?php echo e(trans('home.latest_classes')); ?></h2>
                        <p class="section-hint"><?php echo e(trans('home.latest_webinars_hint')); ?></p>
                    </div>

                    <a href="/classes?sort=newest" class="btn btn-border-white"><?php echo e(trans('home.view_all')); ?></a>
                </div>

                <div class="mt-10 position-relative">
                    <div class="swiper-container latest-webinars-swiper px-12">
                        <div class="swiper-wrapper py-20">
                            <?php $__currentLoopData = $latestWebinars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $latestWebinar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">
                                    <?php echo $__env->make('web.default.includes.webinar.grid-card',['webinar' => $latestWebinar], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination latest-webinars-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$best_rates and !empty($bestRateWebinars) and !$bestRateWebinars->isEmpty()): ?>
            <section class="home-sections home-sections-swiper container">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="section-title"><?php echo e(trans('home.best_rates')); ?></h2>
                        <p class="section-hint"><?php echo e(trans('home.best_rates_hint')); ?></p>
                    </div>

                    <a href="/classes?sort=best_rates" class="btn btn-border-white"><?php echo e(trans('home.view_all')); ?></a>
                </div>

                <div class="mt-10 position-relative">
                    <div class="swiper-container best-rates-webinars-swiper px-12">
                        <div class="swiper-wrapper py-20">
                            <?php $__currentLoopData = $bestRateWebinars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bestRateWebinar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">
                                    <?php echo $__env->make('web.default.includes.webinar.grid-card',['webinar' => $bestRateWebinar], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination best-rates-webinars-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$trend_categories and !empty($trendCategories) and !$trendCategories->isEmpty()): ?>
            <section class="home-sections home-sections-swiper container">
                <h2 class="section-title"><?php echo e(trans('home.trending_categories')); ?></h2>
                <p class="section-hint"><?php echo e(trans('home.trending_categories_hint')); ?></p>


                <div class="swiper-container trend-categories-swiper px-12 mt-40">
                    <div class="swiper-wrapper py-20">
                        <?php $__currentLoopData = $trendCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="swiper-slide">
                                <a href="<?php echo e($trend->category->getUrl()); ?>">
                                    <div class="trending-card d-flex flex-column align-items-center w-100">
                                        <div class="trending-image d-flex align-items-center justify-content-center w-100" style="background-color: <?php echo e($trend->color); ?>">
                                            <div class="icon mb-3">
                                                <img src="<?php echo e($trend->getIcon()); ?>" width="10" class="img-cover" alt="<?php echo e($trend->category->title); ?>">
                                            </div>
                                        </div>

                                        <div class="item-count px-10 px-lg-20 py-5 py-lg-10"><?php echo e($trend->category->webinars_count); ?> <?php echo e(trans('product.course')); ?></div>

                                        <h3><?php echo e($trend->category->title); ?></h3>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <div class="swiper-pagination trend-categories-swiper-pagination"></div>
                </div>
            </section>
        <?php endif; ?>

        
        <?php if($homeSection->name == \App\Models\HomeSection::$full_advertising_banner and !empty($advertisingBanners1) and count($advertisingBanners1)): ?>
            <div class="home-sections container">
                <div class="row">
                    <?php $__currentLoopData = $advertisingBanners1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-<?php echo e($banner1->size); ?>">
                            <a href="<?php echo e($banner1->link); ?>">
                                <img src="<?php echo e($banner1->image); ?>" class="img-cover rounded-sm" alt="<?php echo e($banner1->title); ?>">
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
        

        <?php if($homeSection->name == \App\Models\HomeSection::$best_sellers and !empty($bestSaleWebinars) and !$bestSaleWebinars->isEmpty()): ?>
            <section class="home-sections container">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="section-title"><?php echo e(trans('home.best_sellers')); ?></h2>
                        <p class="section-hint"><?php echo e(trans('home.best_sellers_hint')); ?></p>
                    </div>

                    <a href="/classes?sort=bestsellers" class="btn btn-border-white"><?php echo e(trans('home.view_all')); ?></a>
                </div>

                <div class="mt-10 position-relative">
                    <div class="swiper-container best-sales-webinars-swiper px-12">
                        <div class="swiper-wrapper py-20">
                            <?php $__currentLoopData = $bestSaleWebinars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bestSaleWebinar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">
                                    <?php echo $__env->make('web.default.includes.webinar.grid-card',['webinar' => $bestSaleWebinar], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination best-sales-webinars-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$discount_classes and !empty($hasDiscountWebinars) and !$hasDiscountWebinars->isEmpty()): ?>
            <section class="home-sections container">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="section-title"><?php echo e(trans('home.discount_classes')); ?></h2>
                        <p class="section-hint"><?php echo e(trans('home.discount_classes_hint')); ?></p>
                    </div>

                    <a href="/classes?discount=on" class="btn btn-border-white"><?php echo e(trans('home.view_all')); ?></a>
                </div>

                <div class="mt-10 position-relative">
                    <div class="swiper-container has-discount-webinars-swiper px-12">
                        <div class="swiper-wrapper py-20">
                            <?php $__currentLoopData = $hasDiscountWebinars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hasDiscountWebinar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">
                                    <?php echo $__env->make('web.default.includes.webinar.grid-card',['webinar' => $hasDiscountWebinar], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination has-discount-webinars-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$free_classes and !empty($freeWebinars) and !$freeWebinars->isEmpty()): ?>
            <section class="home-sections home-sections-swiper container">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="section-title"><?php echo e(trans('home.free_classes')); ?></h2>
                        <p class="section-hint"><?php echo e(trans('home.free_classes_hint')); ?></p>
                    </div>

                    <a href="/classes?free=on" class="btn btn-border-white"><?php echo e(trans('home.view_all')); ?></a>
                </div>

                <div class="mt-10 position-relative">
                    <div class="swiper-container free-webinars-swiper px-12">
                        <div class="swiper-wrapper py-20">

                            <?php $__currentLoopData = $freeWebinars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $freeWebinar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">
                                    <?php echo $__env->make('web.default.includes.webinar.grid-card',['webinar' => $freeWebinar], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination free-webinars-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$store_products and !empty($newProducts) and !$newProducts->isEmpty()): ?>
            <section class="home-sections home-sections-swiper container">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="section-title"><?php echo e(trans('update.store_products')); ?></h2>
                        <p class="section-hint"><?php echo e(trans('update.store_products_hint')); ?></p>
                    </div>

                    <a href="/products" class="btn btn-border-white"><?php echo e(trans('update.all_products')); ?></a>
                </div>

                <div class="mt-10 position-relative">
                    <div class="swiper-container new-products-swiper px-12">
                        <div class="swiper-wrapper py-20">

                            <?php $__currentLoopData = $newProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">
                                    <?php echo $__env->make('web.default.products.includes.card',['product' => $newProduct], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination new-products-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$testimonials and !empty($testimonials) and !$testimonials->isEmpty()): ?>
            <div class="position-relative home-sections testimonials-container">

                <div id="parallax1" class="ltr">
                    <div data-depth="0.2" class="gradient-box left-gradient-box"></div>
                </div>

                <section class="container home-sections home-sections-swiper">
                    <div class="text-center">
                        <h2 class="section-title"><?php echo e(trans('home.testimonials')); ?></h2>
                        <p class="section-hint"><?php echo e(trans('home.testimonials_hint')); ?></p>
                    </div>

                    <div class="position-relative">
                        <div class="swiper-container testimonials-swiper px-12">
                            <div class="swiper-wrapper">

                                <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="swiper-slide">
                                        <div class="testimonials-card position-relative py-15 py-lg-30 px-10 px-lg-20 rounded-sm shadow bg-white text-center">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="testimonials-user-avatar">
                                                    <img src="<?php echo e($testimonial->user_avatar); ?>" alt="<?php echo e($testimonial->user_name); ?>" class="img-cover rounded-circle">
                                                </div>
                                                <h4 class="font-16 font-weight-bold text-secondary mt-30"><?php echo e($testimonial->user_name); ?></h4>
                                                <span class="d-block font-14 text-gray"><?php echo e($testimonial->user_bio); ?></span>
                                                <?php echo $__env->make('web.default.includes.webinar.rate',['rate' => $testimonial->rate, 'dontShowRate' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </div>

                                            <p class="mt-25 text-gray font-14"><?php echo nl2br($testimonial->comment); ?></p>

                                            <div class="bottom-gradient"></div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="swiper-pagination testimonials-swiper-pagination"></div>
                        </div>
                    </div>
                </section>

                <div id="parallax2" class="ltr">
                    <div data-depth="0.4" class="gradient-box right-gradient-box"></div>
                </div>

                <div id="parallax3" class="ltr">
                    <div data-depth="0.8" class="gradient-box bottom-gradient-box"></div>
                </div>
            </div>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$subscribes and !empty($subscribes) and !$subscribes->isEmpty()): ?>
            <div class="home-sections position-relative subscribes-container pe-none user-select-none">
                <div id="parallax4" class="ltr d-none d-md-block">
                    <div data-depth="0.2" class="gradient-box left-gradient-box"></div>
                </div>

                <section class="container home-sections home-sections-swiper">
                    <div class="text-center">
                        <h2 class="section-title"><?php echo e(trans('home.subscribe_now')); ?></h2>
                        <p class="section-hint"><?php echo e(trans('home.subscribe_now_hint')); ?></p>
                    </div>

                    <div class="position-relative mt-30">
                        <div class="swiper-container subscribes-swiper px-12">
                            <div class="swiper-wrapper py-20">

                                <?php $__currentLoopData = $subscribes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscribe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $subscribeSpecialOffer = $subscribe->activeSpecialOffer();
                                    ?>

                                    <div class="swiper-slide">
                                        <div class="subscribe-plan position-relative bg-white d-flex flex-column align-items-center rounded-sm shadow pt-50 pb-20 px-20">
                                            <?php if($subscribe->is_popular): ?>
                                                <span class="badge badge-primary badge-popular px-15 py-5"><?php echo e(trans('panel.popular')); ?></span>
                                            <?php elseif(!empty($subscribeSpecialOffer)): ?>
                                                <span class="badge badge-danger badge-popular px-15 py-5"><?php echo e(trans('update.percent_off', ['percent' => $subscribeSpecialOffer->percent])); ?></span>
                                            <?php endif; ?>

                                            <div class="plan-icon">
                                                <img src="<?php echo e($subscribe->icon); ?>" class="img-cover" alt="">
                                            </div>

                                            <h3 class="mt-20 font-30 text-secondary"><?php echo e($subscribe->title); ?></h3>
                                            <p class="font-weight-500 text-gray mt-10"><?php echo e($subscribe->description); ?></p>

                                            <div class="d-flex align-items-start mt-30">
                                                <?php if(!empty($subscribe->price) and $subscribe->price > 0): ?>
                                                    <?php if(!empty($subscribeSpecialOffer)): ?>
                                                        <div class="d-flex align-items-end line-height-1">
                                                            <span class="font-36 text-primary"><?php echo e(handlePrice($subscribe->getPrice(), true, true, false, null, true)); ?></span>
                                                            <span class="font-14 text-gray ml-5 text-decoration-line-through"><?php echo e(handlePrice($subscribe->price, true, true, false, null, true)); ?></span>
                                                        </div>
                                                    <?php else: ?>
                                                        <span class="font-36 text-primary line-height-1"><?php echo e(handlePrice($subscribe->price, true, true, false, null, true)); ?></span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="font-36 text-primary line-height-1"><?php echo e(trans('public.free')); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <ul class="mt-20 plan-feature">
                                                <li class="mt-10"><?php echo e($subscribe->days); ?> <?php echo e(trans('financial.days_of_subscription')); ?></li>
                                                <li class="mt-10">
                                                    <?php if($subscribe->infinite_use): ?>
                                                        <?php echo e(trans('update.unlimited')); ?>

                                                    <?php else: ?>
                                                        <?php echo e($subscribe->usable_count); ?>

                                                    <?php endif; ?>
                                                    <span class="ml-5"><?php echo e(trans('update.subscribes')); ?></span>
                                                </li>
                                            </ul>

                                            <?php if(auth()->check()): ?>
                                                <form action="/panel/financial/pay-subscribes" method="post" class="w-100">
                                                    <?php echo e(csrf_field()); ?>

                                                    <input name="amount" value="<?php echo e($subscribe->price); ?>" type="hidden">
                                                    <input name="id" value="<?php echo e($subscribe->id); ?>" type="hidden">

                                                    <div class="d-flex align-items-center mt-50 w-100">
                                                        <button type="submit" class="btn btn-primary <?php echo e(!empty($subscribe->has_installment) ? '' : 'btn-block'); ?>"><?php echo e(trans('update.purchase')); ?></button>

                                                        <?php if(!empty($subscribe->has_installment)): ?>
                                                            <a href="/panel/financial/subscribes/<?php echo e($subscribe->id); ?>/installments" class="btn btn-outline-primary flex-grow-1 ml-10"><?php echo e(trans('update.installments')); ?></a>
                                                        <?php endif; ?>
                                                    </div>
                                                </form>
                                            <?php else: ?>
                                                <a href="/login" class="btn btn-primary btn-block mt-50"><?php echo e(trans('update.purchase')); ?></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="swiper-pagination subscribes-swiper-pagination"></div>
                        </div>

                    </div>
                </section>

                <div id="parallax5" class="ltr d-none d-md-block">
                    <div data-depth="0.4" class="gradient-box right-gradient-box"></div>
                </div>

                <div id="parallax6" class="ltr d-none d-md-block">
                    <div data-depth="0.6" class="gradient-box bottom-gradient-box"></div>
                </div>
            </div>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$find_instructors and !empty($findInstructorSection)): ?>
            <section class="home-sections home-sections-swiper container find-instructor-section position-relative">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6">
                        <div class="">
                            <h2 class="font-36 font-weight-bold text-dark"><?php echo e($findInstructorSection['title'] ?? ''); ?></h2>
                            <p class="font-16 font-weight-normal text-gray mt-10"><?php echo e($findInstructorSection['description'] ?? ''); ?></p>

                            <div class="mt-35 d-flex align-items-center">
                                <?php if(!empty($findInstructorSection['button1']) and !empty($findInstructorSection['button1']['title']) and !empty($findInstructorSection['button1']['link'])): ?>
                                    <a href="<?php echo e($findInstructorSection['button1']['link']); ?>" class="btn btn-primary mr-15"><?php echo e($findInstructorSection['button1']['title']); ?></a>
                                <?php endif; ?>

                                <?php if(!empty($findInstructorSection['button2']) and !empty($findInstructorSection['button2']['title']) and !empty($findInstructorSection['button2']['link'])): ?>
                                    <a href="<?php echo e($findInstructorSection['button2']['link']); ?>" class="btn btn-outline-primary"><?php echo e($findInstructorSection['button2']['title']); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                        <div class="position-relative ">
                            <img src="<?php echo e($findInstructorSection['image']); ?>" class="find-instructor-section-hero" alt="<?php echo e($findInstructorSection['title']); ?>">
                            <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" alt="circle">
                            <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots">

                            <div class="example-instructor-card bg-white rounded-sm shadow-lg  p-5 p-md-15 d-flex align-items-center">
                                <div class="example-instructor-card-avatar">
                                    <img src="/assets/default/img/home/toutor_finder.svg" class="img-cover rounded-circle" alt="user name">
                                </div>

                                <div class="flex-grow-1 ml-15">
                                    <span class="font-14 font-weight-bold text-secondary d-block"><?php echo e(trans('update.looking_for_an_instructor')); ?></span>
                                    <span class="text-gray font-12 font-weight-500"><?php echo e(trans('update.find_the_best_instructor_now')); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$reward_program and !empty($rewardProgramSection)): ?>
            <section class="home-sections home-sections-swiper container reward-program-section position-relative">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6">
                        <div class="position-relative reward-program-section-hero-card">
                            <img src="<?php echo e($rewardProgramSection['image']); ?>" class="reward-program-section-hero" alt="<?php echo e($rewardProgramSection['title']); ?>">

                            <div class="example-reward-card bg-white rounded-sm shadow-lg p-5 p-md-15 d-flex align-items-center">
                                <div class="example-reward-card-medal">
                                    <img src="/assets/default/img/rewards/medal.png" class="img-cover rounded-circle" alt="medal">
                                </div>

                                <div class="flex-grow-1 ml-15">
                                    <span class="font-14 font-weight-bold text-secondary d-block"><?php echo e(trans('update.you_got_50_points')); ?></span>
                                    <span class="text-gray font-12 font-weight-500"><?php echo e(trans('update.for_completing_the_course')); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                        <div class="">
                            <h2 class="font-36 font-weight-bold text-dark"><?php echo e($rewardProgramSection['title'] ?? ''); ?></h2>
                            <p class="font-16 font-weight-normal text-gray mt-10"><?php echo e($rewardProgramSection['description'] ?? ''); ?></p>

                            <div class="mt-35 d-flex align-items-center">
                                <?php if(!empty($rewardProgramSection['button1']) and !empty($rewardProgramSection['button1']['title']) and !empty($rewardProgramSection['button1']['link'])): ?>
                                    <a href="<?php echo e($rewardProgramSection['button1']['link']); ?>" class="btn btn-primary mr-15"><?php echo e($rewardProgramSection['button1']['title']); ?></a>
                                <?php endif; ?>

                                <?php if(!empty($rewardProgramSection['button2']) and !empty($rewardProgramSection['button2']['title']) and !empty($rewardProgramSection['button2']['link'])): ?>
                                    <a href="<?php echo e($rewardProgramSection['button2']['link']); ?>" class="btn btn-outline-primary"><?php echo e($rewardProgramSection['button2']['title']); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$become_instructor and !empty($becomeInstructorSection)): ?>
            <section class="home-sections home-sections-swiper container find-instructor-section position-relative">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6">
                        <div class="">
                            <h2 class="font-28 font-weight-bold text-dark">Ready to take your studies to the next level?</h2>
                            <p>Join TeachMe App today and connect with skilled peer tutors who can help you excel in your studies.</p><br>
                            <a href="/register" class="btn btn-primary mb-3">Sign up</a><br>
                        </div>
                        <div class="">
                            <h2 class="font-28 font-weight-bold text-dark"><?php echo e($becomeInstructorSection['title'] ?? ''); ?></h2>
                            <p class="font-16 font-weight-normal text-gray mt-10"><?php echo e($becomeInstructorSection['description'] ?? ''); ?></p>

                            <div class="mt-10 d-flex align-items-center">
                                <a href="/become-instructor" class="btn btn-primary mr-15"><?php echo e($becomeInstructorSection['button1']['title']); ?></a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                        <div class="position-relative ">
                            <img src="<?php echo e($becomeInstructorSection['image']); ?>" class="find-instructor-section-hero" alt="<?php echo e($becomeInstructorSection['title']); ?>">
                            <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" alt="circle">
                            <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots">

                            <div class="example-instructor-card bg-white rounded-sm shadow-lg border p-5 p-md-15 d-flex align-items-center">
                                <div class="example-instructor-card-avatar">
                                    <img src="/assets/default/img/home/become_instructor.svg" class="img-cover rounded-circle" alt="user name">
                                </div>

                                <div class="flex-grow-1 ml-15">
                                    <span class="font-14 font-weight-bold text-secondary d-block"><?php echo e(trans('update.become_an_instructor')); ?></span>
                                    <span class="text-gray font-12 font-weight-500"><?php echo e(trans('update.become_instructor_tagline')); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$forum_section and !empty($forumSection)): ?>
            <section class="home-sections home-sections-swiper container find-instructor-section position-relative">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                        <div class="position-relative ">
                            <img src="<?php echo e($forumSection['image']); ?>" class="find-instructor-section-hero" alt="<?php echo e($forumSection['title']); ?>">
                            <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle" alt="circle">
                            <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots">
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="">
                            <h2 class="font-36 font-weight-bold text-dark"><?php echo e($forumSection['title'] ?? ''); ?></h2>
                            <p class="font-16 font-weight-normal text-gray mt-10"><?php echo e($forumSection['description'] ?? ''); ?></p>

                            <div class="mt-35 d-flex align-items-center">
                                <?php if(!empty($forumSection['button1']) and !empty($forumSection['button1']['title']) and !empty($forumSection['button1']['link'])): ?>
                                    <a href="<?php echo e($forumSection['button1']['link']); ?>" class="btn btn-primary mr-15"><?php echo e($forumSection['button1']['title']); ?></a>
                                <?php endif; ?>

                                <?php if(!empty($forumSection['button2']) and !empty($forumSection['button2']['title']) and !empty($forumSection['button2']['link'])): ?>
                                    <a href="<?php echo e($forumSection['button2']['link']); ?>" class="btn btn-outline-primary"><?php echo e($forumSection['button2']['title']); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$video_or_image_section and !empty($boxVideoOrImage)): ?>
            <section class="home-sections home-sections-swiper position-relative">
                <div class="home-video-mask"></div>
                <div class="container home-video-container d-flex flex-column align-items-center justify-content-center position-relative" style="background-image: url('<?php echo e($boxVideoOrImage['background'] ?? ''); ?>')">
                    <a href="<?php echo e($boxVideoOrImage['link'] ?? ''); ?>" class="home-video-play-button d-flex align-items-center justify-content-center position-relative">
                        <i data-feather="play" width="36" height="36" class=""></i>
                    </a>

                    <div class="mt-50 pt-10 text-center">
                        <h2 class="home-video-title"><?php echo e($boxVideoOrImage['title'] ?? ''); ?></h2>
                        <p class="home-video-hint mt-10"><?php echo e($boxVideoOrImage['description'] ?? ''); ?></p>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$instructors and !empty($instructors) and !$instructors->isEmpty()): ?>
            <section class="home-sections container">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="section-title"><?php echo e(trans('home.instructors')); ?></h2>
                        <p class="section-hint"><?php echo e(trans('home.instructors_hint')); ?></p>
                    </div>

                    <a href="/instructors" class="btn btn-border-white"><?php echo e(trans('home.all_instructors')); ?></a>
                </div>

                <div class="position-relative mt-20 ltr">
                    <div class="owl-carousel customers-testimonials instructors-swiper-container">

                        <?php $__currentLoopData = $instructors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $instructor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="item">
                                <div class="shadow-effect">
                                    <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                                        <div class="instructors-card-avatar">
                                            <img src="<?php echo e($instructor->getAvatar(108)); ?>" alt="<?php echo e($instructor->full_name); ?>" class="rounded-circle img-cover">
                                        </div>
                                        <div class="instructors-card-info mt-10 text-center">
                                            <a href="<?php echo e($instructor->getProfileUrl()); ?>" target="_blank">
                                                <h3 class="font-16 font-weight-bold text-dark-blue"><?php echo e($instructor->full_name); ?></h3>
                                            </a>

                                            <p class="font-14 text-gray mt-5"><?php echo e($instructor->bio); ?></p>
                                            <div class="stars-card d-flex align-items-center justify-content-center mt-10">
                                                <?php
                                                    $i = 5;
                                                ?>
                                                <?php while(--$i >= 5 - $instructor->rates()): ?>
                                                    <i data-feather="star" width="20" height="20" class="active"></i>
                                                <?php endwhile; ?>
                                                <?php while($i-- >= 0): ?>
                                                    <i data-feather="star" width="20" height="20" class=""></i>
                                                <?php endwhile; ?>
                                            </div>

                                            <?php if(!empty($instructor->hasMeeting())): ?>
                                                <a href="<?php echo e($instructor->getProfileUrl()); ?>?tab=appointments" class="btn btn-primary btn-sm rounded-pill mt-15"><?php echo e(trans('home.reserve_a_live_class')); ?></a>
                                            <?php else: ?>
                                                <a href="<?php echo e($instructor->getProfileUrl()); ?>" class="btn btn-primary btn-sm rounded-pill mt-15"><?php echo e(trans('public.profile')); ?></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>
            </section>
        <?php endif; ?>

        
        <?php if($homeSection->name == \App\Models\HomeSection::$half_advertising_banner and !empty($advertisingBanners2) and count($advertisingBanners2)): ?>
            <div class="home-sections container">
                <div class="row">
                    <?php $__currentLoopData = $advertisingBanners2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-<?php echo e($banner2->size); ?>">
                            <a href="<?php echo e($banner2->link); ?>">
                                <img src="<?php echo e($banner2->image); ?>" class="img-cover rounded-sm" alt="<?php echo e($banner2->title); ?>">
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
        

        <?php if($homeSection->name == \App\Models\HomeSection::$organizations and !empty($organizations) and !$organizations->isEmpty()): ?>
            <section class="home-sections home-sections-swiper container">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="section-title"><?php echo e(trans('home.organizations')); ?></h2>
                        <p class="section-hint"><?php echo e(trans('home.organizations_hint')); ?></p>
                    </div>

                    <a href="/organizations" class="btn btn-border-white"><?php echo e(trans('home.all_organizations')); ?></a>
                </div>

                <div class="position-relative mt-20">
                    <div class="swiper-container organization-swiper-container px-12">
                        <div class="swiper-wrapper py-20">

                            <?php $__currentLoopData = $organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">
                                    <div class="home-organizations-card d-flex flex-column align-items-center justify-content-center">
                                        <div class="home-organizations-avatar">
                                            <img src="<?php echo e($organization->getAvatar(120)); ?>" class="img-cover rounded-circle" alt="<?php echo e($organization->full_name); ?>">
                                        </div>
                                        <a href="<?php echo e($organization->getProfileUrl()); ?>" class="mt-25 d-flex flex-column align-items-center justify-content-center">
                                            <h3 class="home-organizations-title"><?php echo e($organization->full_name); ?></h3>
                                            <p class="home-organizations-desc mt-10"><?php echo e($organization->bio); ?></p>
                                            <span class="home-organizations-badge badge mt-15"><?php echo e($organization->webinars_count); ?> <?php echo e(trans('panel.classes')); ?></span>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination organization-swiper-pagination"></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($homeSection->name == \App\Models\HomeSection::$blog and !empty($blog) and !$blog->isEmpty()): ?>
            <section class="home-sections container">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="section-title"><?php echo e(trans('home.blog')); ?></h2>
                        <p class="section-hint"><?php echo e(trans('home.blog_hint')); ?></p>
                    </div>

                    <a href="/blog" class="btn btn-border-white"><?php echo e(trans('home.all_blog')); ?></a>
                </div>

                <div class="row mt-35">

                    <?php $__currentLoopData = $blog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-12 col-md-4 col-lg-4 mt-20 mt-lg-0">
                            <?php echo $__env->make('web.default.blog.grid-list',['post' =>$post], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </section>
        <?php endif; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



<!-- Find Tutor Modal -->
<div class="modal fade" id="findTutorModal" tabindex="-1" aria-labelledby="findTutorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="findTutorModalLabel">Find a Tutor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/search" method="get">
                    <div class="mb-3">
                        <label for="search" class="form-label">Search for tutors by name, course or subject:</label>
                        <input type="text" name="search" class="form-control" id="search" placeholder="e.g., Mathematics, Science">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (Ensure this is included) -->


<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts_bottom'); ?>
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/vendors/owl-carousel2/owl.carousel.min.js"></script>
    <script src="/assets/default/vendors/parallax/parallax.min.js"></script>
    <script src="/assets/default/js/parts/home.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FontAwesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <!-- Include Font Awesome CDN -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(getTemplate().'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\teachme\public_html\resources\views/web/default/pages/home.blade.php ENDPATH**/ ?>