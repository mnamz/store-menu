<?php

include_once 'templates_menu/shop-header.php';
include_once 'db.php';

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<main id="MainContent" class="content-for-layout">
    <div class="about-page">
        <!-- about hero start -->
        <div class="about-hero mt-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="about-hero-content">
                            <h2 class="about-hero-title">Welcome to Dronecare
                            </h2>
                            <p class="about-hero-subtitle">Provide sample text here</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- about hero end -->

        <!-- about banner start -->
        <!-- <div class="about-banner mt-100 aos-init" data-aos="fade-up" data-aos-duration="700">
            <div class="container">
                <div class="about-banner-wrapper">
                    <div class="about-banner-content">
                        <p class="about-banner-text heading_48">Get in touch with us for your service related query</p>
                        <a href="#contact" class="about-banner-btn">CONTACT US</a>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- about banner end -->

        <!-- about promotion start -->
        <div class="promotional-area mt-100">
            <div class="row g-0 justify-content-center">

                <div class="col-lg-4 col-md-6 col-12 aos-init" data-aos="fade-up" data-aos-duration="700">
                    <div class="promotional-item overlay-black">
                        <img src="assets/img/about/p2.jpg" alt="img">
                        <div class="promotional-absolute">
                            <div class="promotional-content text-center">
                                <h2 class="promo-title">Dronecare Setapak
                                </h2>
                                <p class="promo-subtitle mb-3">(Retail) Monday - Saturday (12pm-8pm)
                                    Platinum Walk, Block E-65-1, No 2, Jalan Langkawi, 53300 Wilayah Persekutuan Kuala Lumpur, Malaysia</p>
                                <p style="font-size: 16px;" class="promo-subtitle mb-3">Park basement, find block E Lift, then level 1. Once get out from lift turn left then right</p>
                                <a href="https://waze.com/ul/hw2864xv89" target="_blank">
                                    <i style="color: #fff; font-size: 36px;" class="fas fa-map-marker-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 aos-init" data-aos="fade-up" data-aos-duration="1000">
                    <div class="promotional-item overlay-blue">
                        <img src="assets/img/about/p3.jpg" alt="img">
                        <div class="promotional-absolute">
                            <div class="promotional-content text-center">
                                <h2 class="promo-title">Dronecare Puchong</h2>
                                <p class="promo-subtitle mb-3">(Retail & Service Center) Monday - Saturday (11am-7pm)
                                    No 57A, Jalan PU 7/4, Taman Puchong Utama, 47100 Puchong, Selangor, Malaysia</p>
                                <a href="https://waze.com/ul/hw28302dft" target="_blank">
                                    <i style="color: #fff; font-size: 36px;" class="fas fa-map-marker-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- about promotion end -->



        <div class="contact-box mt-100">
            <div class="contact-box-wrapper">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="contact-item" id="contact">
                                <div class="contact-icon">
                                    <svg width="50" height="45" viewBox="0 0 50 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.5 0.25V28.25H7.5V37.1641L10.3438 34.8672L18.6016 28.25H35.5V0.25H0.5ZM4 3.75H32V24.75H17.3984L16.9062 25.1328L11 29.8359V24.75H4V3.75ZM39 7.25V10.75H46V31.75H39V36.8359L32.6016 31.75H19.4766L15.1016 35.25H31.3984L42.5 44.1641V35.25H49.5V7.25H39Z" fill="#00234D"></path>
                                    </svg>
                                </div>
                                <div class="contact-details">
                                    <h2 class="contact-title">Mail Address</h2>
                                    <a class="contact-info" href="mailto:info@example.com">info@example.com</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg width="46" height="47" viewBox="0 0 46 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.149 0.75C9.23299 0.75 8.33065 1.07812 7.5787 1.67969L7.46932 1.73438L7.41463 1.78906L1.94588 7.42188L2.00057 7.47656C0.312094 9.03516 -0.207437 11.3662 0.524009 13.3828C0.530844 13.3965 0.517173 13.4238 0.524009 13.4375C2.00741 17.6826 5.80135 25.8789 13.2115 33.2891C20.649 40.7266 28.9547 44.3701 33.0631 45.9766H33.1178C35.2437 46.6875 37.5474 46.1816 39.1881 44.7734L44.7115 39.25C46.1607 37.8008 46.1607 35.2852 44.7115 33.8359L37.6021 26.7266L37.5474 26.6172C36.0982 25.168 33.5279 25.168 32.0787 26.6172L28.5787 30.1172C27.314 29.5088 24.2994 27.9502 21.4146 25.1953C18.5504 22.4609 17.0875 19.3164 16.5474 18.0859L20.0474 14.5859C21.5172 13.1162 21.5445 10.6689 19.9928 9.22656L20.0474 9.17188L19.8834 9.00781L12.8834 1.78906L12.8287 1.73438L12.7193 1.67969C11.9674 1.07812 11.065 0.75 10.149 0.75ZM10.149 4.25C10.2789 4.25 10.4088 4.31152 10.5318 4.41406L17.5318 11.5781L17.6959 11.7422C17.6822 11.7285 17.7984 11.9131 17.5865 12.125L13.2115 16.5L12.3912 17.2656L12.774 18.3594C12.774 18.3594 14.7838 23.7393 19.0084 27.7656L19.3912 28.0938C23.4586 31.8057 28.2506 33.8359 28.2506 33.8359L29.3443 34.3281L34.5396 29.1328C34.8404 28.832 34.7857 28.832 35.0865 29.1328L42.2506 36.2969C42.5514 36.5977 42.5514 36.4883 42.2506 36.7891L36.8912 42.1484C36.0846 42.8389 35.2301 42.9824 34.2115 42.6406C30.2467 41.082 22.5426 37.6982 15.6724 30.8281C8.74764 23.9033 5.13143 16.0488 3.80526 12.2344C3.53866 11.5234 3.73006 10.4707 4.35213 9.9375L4.46151 9.82812L9.7662 4.41406C9.88924 4.31152 10.0191 4.25 10.149 4.25Z" fill="#00234D"></path>
                                    </svg>
                                </div>
                                <div class="contact-details">
                                    <h2 class="contact-title">Steven Liew</h2>
                                    <a class="contact-info" href="https://api.whatsapp.com/send?phone=601162303363">+601162303363 (WhatsApp)</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg width="46" height="47" viewBox="0 0 46 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.149 0.75C9.23299 0.75 8.33065 1.07812 7.5787 1.67969L7.46932 1.73438L7.41463 1.78906L1.94588 7.42188L2.00057 7.47656C0.312094 9.03516 -0.207437 11.3662 0.524009 13.3828C0.530844 13.3965 0.517173 13.4238 0.524009 13.4375C2.00741 17.6826 5.80135 25.8789 13.2115 33.2891C20.649 40.7266 28.9547 44.3701 33.0631 45.9766H33.1178C35.2437 46.6875 37.5474 46.1816 39.1881 44.7734L44.7115 39.25C46.1607 37.8008 46.1607 35.2852 44.7115 33.8359L37.6021 26.7266L37.5474 26.6172C36.0982 25.168 33.5279 25.168 32.0787 26.6172L28.5787 30.1172C27.314 29.5088 24.2994 27.9502 21.4146 25.1953C18.5504 22.4609 17.0875 19.3164 16.5474 18.0859L20.0474 14.5859C21.5172 13.1162 21.5445 10.6689 19.9928 9.22656L20.0474 9.17188L19.8834 9.00781L12.8834 1.78906L12.8287 1.73438L12.7193 1.67969C11.9674 1.07812 11.065 0.75 10.149 0.75ZM10.149 4.25C10.2789 4.25 10.4088 4.31152 10.5318 4.41406L17.5318 11.5781L17.6959 11.7422C17.6822 11.7285 17.7984 11.9131 17.5865 12.125L13.2115 16.5L12.3912 17.2656L12.774 18.3594C12.774 18.3594 14.7838 23.7393 19.0084 27.7656L19.3912 28.0938C23.4586 31.8057 28.2506 33.8359 28.2506 33.8359L29.3443 34.3281L34.5396 29.1328C34.8404 28.832 34.7857 28.832 35.0865 29.1328L42.2506 36.2969C42.5514 36.5977 42.5514 36.4883 42.2506 36.7891L36.8912 42.1484C36.0846 42.8389 35.2301 42.9824 34.2115 42.6406C30.2467 41.082 22.5426 37.6982 15.6724 30.8281C8.74764 23.9033 5.13143 16.0488 3.80526 12.2344C3.53866 11.5234 3.73006 10.4707 4.35213 9.9375L4.46151 9.82812L9.7662 4.41406C9.88924 4.31152 10.0191 4.25 10.149 4.25Z" fill="#00234D"></path>
                                    </svg>
                                </div>
                                <div class="contact-details">
                                    <h2 class="contact-title">Brandon Foo </h2>
                                    <a class="contact-info" href="https://api.whatsapp.com/send?phone=601115555520">+601115555520 (WhatsApp)</a>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>



    </div>
</main>

<?php

include_once 'templates_menu/footer.php';

?>