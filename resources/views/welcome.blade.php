<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Doctor appointment web application</title>
    <!-- Favicons -->
    <link href="{{ asset('welcome/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('welcome/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('welcome/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('welcome/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('welcome/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('welcome/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('welcome/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('welcome/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page">
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">
            <a href="{{ route('welcome') }}" class="logo d-flex align-items-center me-auto">
                <h1 class="sitename">DOCTOR APPOINTMENT</h1>
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#doctor">Doctor</a></li>
                    <li><a href="#services">Services</a></li>
                    <li class="dropdown"><a href="#"><span>Login</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="{{ route('patient.login') }}">
                                    Login As Patient</a></li>
                            <li><a href="{{ route('doctor.login') }}">Login As Doctor</a></li>
                            <li><a href="{{ route('admin.login') }}">
                                    Login As Admin</a></li>
                        </ul>
                    </li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </header>
    <main class="main">
        <!--/Hero Section-->
        <section id="hero" class="hero section dark-background">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center"
                        data-aos="zoom-out">
                        <h1>Better Solutions For Your Health</h1>
                        <p>Welcome to DOCTOR APPOINTMENT, where your health and well-being are our top priority. We are committed
                            to
                            providing exceptional care with compassion and expertise</p>
                        <div class="d-flex">
                            <a href="{{ route('patient.create') }}" class="btn-get-started">Register</a>
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                        <img src="{{ asset('welcome/img/building.png') }}" class="img-fruid animated w-100"
                            alt="">
                    </div>
                </div>
            </div>
        </section><!-- /Hero Section -->
        <!-- About Section -->
        <section id="about" class="about section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>About Us</h2>
            </div><!-- End Section Title -->
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                        <ul>
                            <li><i class="bi bi-check2-circle"></i> <span>To provide compassionate, high-quality
                                    healthcare services that prioritize patient safety and well-being. Our dedicated
                                    team works tirelessly to meet the health needs of our community with professionalism
                                    and integrity</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>With a highly qualified team of doctors,
                                    nurses, and support staff, we specialize in a wide range of medical services, from
                                    emergency care to advanced surgeries.</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Our DOCTOR APPOINTMENT is equipped with
                                    state-of-the-art
                                    technology to ensure accurate diagnoses and effective treatments.</span></li>
                        </ul>
                    </div>
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <ul>
                            <li><i class="bi bi-check2-circle"></i> <span>We are committed to continuous improvement in
                                    medical care and patient satisfaction.</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Through innovation, research, and community
                                    programs, we strive to make healthcare accessible and effective for everyone.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->
        <!-- Why Us Section -->
        <section id="why-us" class="section why-us light-background" data-builder="section">
            <div class="container-fluid">
                <div class="row gy-4">
                    <div class="col-lg-7 d-flex flex-column justify-content-center order-2 order-lg-1">
                        <div class="content px-xl-5" data-aos="fade-up" data-aos-delay="100">
                            <h3><strong>Frequently Asked Questions</strong></h3>
                        </div>
                        <div class="faq-container px-xl-5" data-aos="fade-up" data-aos-delay="200">
                            <div class="faq-item faq-active">
                                <h3><span>01</span>What makes our DOCTOR APPOINTMENT unique?</h3>
                                <div class="faq-content">
                                    <p>We combine advanced medical technology with a compassionate, patient-centered
                                        approach. Our multidisciplinary teams work collaboratively to deliver
                                        personalized care tailored to each patient’s needs, ensuring a comfortable and
                                        supportive healing environment</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->
                            <div class="faq-item">
                                <h3><span>02</span>What measures does the hospital take to ensure patient safety?
                                </h3>
                                <div class="faq-content">
                                    <p>Patient safety is our top priority. We adhere to strict infection control
                                        protocols, conduct regular staff training, and use advanced technology to
                                        monitor patient health. Our hospital follows national and international
                                        standards to create a safe and secure environment for all patients.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->
                            <div class="faq-item">
                                <h3><span>03</span>What resources are available for international patients?</h3>
                                <div class="faq-content">
                                    <p>We offer specialized services for international patients, including assistance
                                        with travel arrangements, language interpretation, and coordination of care with
                                        international insurance providers. Our International Patient Services team is
                                        here to help with every aspect of the patient journey, making it as comfortable
                                        and seamless as possible.
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->
                        </div>
                    </div>
                    <div class="col-lg-5 order-1 order-lg-2 why-us-img">
                        <img src="{{ asset('welcome/img/why-us.png') }}" class="img-fluid" alt=""
                            data-aos="zoom-in" data-aos-delay="100">
                    </div>
                </div>
            </div>
        </section>
        <section id="doctor" class="team section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Doctors</h2>
            </div>
            <div class="container">
                <div class="row gy-4">
                    @if ($doctors->count() > 0)
                        @foreach ($doctors as $doctor)
                            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="team-member d-flex align-items-start">
                                    <div class="pic">
                                        <img id="profileImagePreview"
                                            src="{{ $doctor->image ? asset('storage/' . $doctor->image) : asset('img/profile/profile.png') }}"
                                            alt="Profile Picture" class="rounded-circle" width="120"
                                            height="120">
                                    </div>
                                    <div class="member-info">
                                        <h4>{{ $doctor->name }}</h4>
                                        <span>{{ $doctor->department->name }}</span>
                                        <p>{{ $doctor->licence_number }}</p>
                                        <div class="social">
                                            <a href="mailto:{{ $doctor->email }}"><i class="bi bi-envelope"></i></a>
                                            <a href="tel:{{ $doctor->phone }}"><i class="bi bi-telephone"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="container section-title" data-aos="fade-up">
                            <p>There are no doctors.</p>
                        </div>
                    @endif

                </div>
            </div>
        </section><!-- /Doctor Section -->
        <section id="services" class="services section light-background">
            <div class="container section-title" data-aos="fade-up">
                <h2>Services</h2>
            </div>
            <div class="container">
                <div class="row gy-4">
                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-activity icon"></i></div>
                            <h4 class="stretched-link">Emergency and Trauma Care</h4>
                            <p>Our Emergency Department provides 24/7 care for urgent medical needs, trauma cases, and
                                life-threatening conditions. Staffed with skilled physicians and nurses, we&apos;re
                                equipped
                                with state-of-the-art technology to ensure rapid diagnosis and treatment for patients in
                                critical situations.</p>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-bounding-box-circles icon"></i></div>
                            <h4 class="stretched-link">Surgical Services</h4>
                            <p>We offer a comprehensive range of surgical procedures, from routine operations to complex
                                surgeries. Our surgical team is equipped with advanced technology and minimally invasive
                                techniques to ensure patient safety, faster recovery times, and effective outcomes.</p>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-calendar4-week icon"></i></div>
                            <h4 class="stretched-link">Maternity and Neonatal Care</h4>
                            <p>Our Maternity Department provides compassionate care for expecting mothers and newborns,
                                including prenatal, delivery, and postpartum services. Our neonatal unit offers
                                specialized care for premature or critically ill infants, supported by expert
                                neonatologists and nurses.</p>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-broadcast icon"></i></div>
                            <h4 class="stretched-link">Diagnostic and Imaging Services</h4>
                            <p>Our Diagnostic Center provides accurate and timely diagnostic services, including MRI, CT
                                scans, X-rays, ultrasound, and laboratory testing. Our team of radiologists and lab
                                technicians ensures precise imaging and test results, essential for effective diagnosis
                                and treatmen</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="call-to-action" class="call-to-action section dark-background">
            <img src="{{ asset('welcome/img/cta-bg.jpg') }}" alt="">
            <div class="container">
                <div class="row" data-aos="zoom-in" data-aos-delay="100">
                    <div class="col-xl-9 text-center text-xl-start">
                        <h3>Dr. Tin Mg Swe</h3>
                        <p>"An ounce of prevention is worth a pound of cure. Regular check-ups and
                            proactive healthcare can make all the difference. Take care of your health before symptoms
                            appear."</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer id="footer" class="footer">
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-4 footer-about">
                    <a href="index.html" class="d-flex align-items-center">
                        <span class="sitename">DOCTOR APPOINTMENT</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>DOCTOR APPOINTMENT</p>
                        <p>Mandalay, Chanmyathazi Township</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+959 23343431 | +959 24532432</span></p>
                        <p><strong>Email:</strong> <span>info@DOCTOR APPOINTMENT.com</span></p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#why-us">FAQs</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#doctor">Doctors</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#about">About us</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#services">Services</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i>Emergency & Trauma Care</li>
                        <li><i class="bi bi-chevron-right"></i>Surgical Services</li>
                        <li><i class="bi bi-chevron-right"></i>Maternity & Neonatal Care</li>
                        <li><i class="bi bi-chevron-right"></i>Diagnostic and Imaging Services</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">DOCTOR APPOINTMENT</strong> <span>All Rights
                    Reserved</span>
            </p>
            <div class="credits">
                Designed by DOCTOR APPOINTMENT GROUP
            </div>
        </div>
    </footer>
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>
    <!-- Vendor JS Files -->
    <script src="{{ asset('welcome/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('welcome/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('welcome/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('welcome/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('welcome/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('welcome/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('welcome/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('welcome/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <!-- Main JS File -->
    <script src="{{ asset('welcome/js/main.js') }}"></script>
</body>
