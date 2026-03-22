
<!-- PHP INCLUDES -->

<?php

    include "connect.php";
    include "Includes/templates/header.php";
    include "Includes/templates/navbar.php";

?>

    <!-- HOME SECTION -->

    <section class="home-section" id="home-section">
	    <div class="home-section-content">
		    <div id="home-section-carousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#home-section-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#home-section-carousel" data-slide-to="1"></li>
                    <li data-target="#home-section-carousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <!-- FIRST SLIDE -->
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="Design/images/barbershop_image_1.jpg" alt="First slide">
                        <div class="carousel-caption d-md-block">
                            <h3>It's Not Just a Haircut, It's an Experience.</h3>
                            <p>
                                Our barbershop is the territory created purely for males who appreciate
                                <br>
                                 premium quality, time and flawless look.
                            </p>
                        </div>
                    </div>
                    <!-- SECOND SLIDE -->
                    <div class="carousel-item">
                        <img class="d-block w-100" src="Design/images/barbershop_image_2.jpg" alt="Second slide">
                        <div class="carousel-caption d-md-block">
                            <h3>It's Not Just a Haircut, It's an Experience.</h3>
                            <p>
                                Our barbershop is the territory created purely for males who appreciate
                                <br>
                                premium quality, time and flawless look.
                            </p>
                        </div>
                    </div>
                    <!-- THIRD SLIDE -->
                    <div class="carousel-item">
                        <img class="d-block w-100" src="Design/images/barbershop_image_3.jpg" alt="Third slide">
                        <div class="carousel-caption d-md-block">
                            <h3>It's Not Just a Haircut, It's an Experience.</h3>
                            <p>
                                Our barbershop is the territory created purely for males who appreciate
                                <br>
                                premium quality, time and flawless look.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- PREVIOUS & NEXT -->
                <a class="carousel-control-prev" href="#home-section-carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#home-section-carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
		</div>
	</section>

    <!-- ABOUT SECTION -->

    <section id="about" class="about_section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="about_content" style="text-align: center;">
                        <h3>Introducing</h3>
                        <h2>The Trendz-Cut <br>Since 2014</h2>
                        <img src="Design/images/about-logo.png" alt="logo">
                        <p style="color: #777">
                            Barber is a person whose occupation is mainly to cut dress groom style and shave men's and boys' hair. A barber's place of work is known as a "barbershop" or a "barber's". Barbershops are also places of social interaction and public discourse. In some instances, barbershops are also public forums.
                        </p>
                        <a href="#" class="default_btn" style="opacity: 1;">More about us</a>
                    </div>
                </div>
                <div class="col-md-6  d-none d-md-block">
                    <div class="about_img" style = "overflow:hidden">
                        <img class="about_img_1" src="Design/images/log1.jpg" alt="about-1">
                        <img class="about_img_2" src="Design/images/log.jpg" alt="about-2">
                        <img class="about_img_3" src="Design/images/boy.jpg" alt="about-3">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES SECTION -->

    <section class="services_section" id="services">
        <div class="container">
            <div class="section_heading">
                <h3>Trendz-Cut for Men & Women</h3>
                <h2>Our Services</h2>
                <div class="heading-line"></div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 padd_col_res">
                    <div class="service_box">
                        <i class="bs bs-scissors-1"></i>
                        <h3>Haircut Styles</h3>
                        <p>Barber is a person whose occupation is mainly to cut dress style.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 padd_col_res">
                    <div class="service_box">
                        <i class="bs bs-razor-2"></i>
                        <h3>Salon</h3>
                        <p>Barber is a person whose occupation is mainly to cut dress style.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 padd_col_res" >
                    <div class="service_box">
                        <i class="bs bs-brush"></i>
                        <h3>Eyebrow</h3>
                        <p>Barber is a person whose occupation is mainly to cut dress style.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 padd_col_res">
                    <div class="service_box">
                        <i class="bs bs-hairbrush-1"></i>
                        <h3>Nail Care</h3>
                        <p>Barber is a person whose occupation is mainly to cut dress style.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 padd_col_res">
                    <div class="service_box">
                        <i class="fas fa-camera"></i>
                        <h3>AI Face Analysis</h3>
                        <p>Get personalized haircut recommendations based on your face shape using AI technology.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 padd_col_res">
                    <div class="service_box">
                        <i class="fas fa-robot"></i>
                        <h3>AI Chat Assistant</h3>
                        <p>Chat with our AI assistant for instant haircut advice and styling tips.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BOOKING SECTION -->

    <section class="book_section" id="booking">
        <div class="book_bg"></div>
        <div class="map_pattern"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <form action="appointment.php" method="post" id="appointment_form" class="form-horizontal appointment_form">
                        <div class="book_content">
                            <h2 style="color: white;">Make an appointment</h2>
                            <p style="color: #999;">
                                Barber is a person whose occupation is mainly to cut dress groom <br>style and shave men's and boys hair.
                            </p>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 padding-10">  
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-6 padding-10">
                                <input type="time" class="form-control">
                            </div>
                        </div>

                        <!-- SUBMIT BUTTON -->

                        <button id="app_submit" class="default_btn" type="submit">
                            Make Appointment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- GALLERY SECTION -->

    <section class="gallery-section" id="gallery">

    <div class="section_heading">
        <h3>Trendy-Cut for Men & women</h3>
        <h2>Barbers Gallery</h2>
        <div class="heading-line"></div>
    </div>

    <div class="container">
        <div class="row">

        <?php
        $stmt = $con->prepare("SELECT * FROM gallery ORDER BY id DESC");
        $stmt->execute();
        $images = $stmt->fetchAll();

        foreach($images as $row)
        {
        ?>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">

                <div class="gallery-box">

                    <img src="barber-admin/uploads/<?php echo $row['image']; ?>" 
                         class="gallery-img"
                         alt="Gallery Image">

                </div>

            </div>

        <?php
        }
        ?>

        </div>
    </div>

</section>
    <!-- TEAM SECTION -->

    <section id="team" class="team_section">
        <div class="container">
            <div class="section_heading ">
                <h3>Trendz-Cut for Men & Women</h3>
                <h2>Our Barbers</h2>
                <div class="heading-line"></div>
            </div>
            <ul class="team_members row"> 
                <li class="col-lg-3 col-md-6 padd_col_res">
                    <div class="team_member">
                        <img src="Design/images/team-1.jpg" alt="Team Member">
                    </div>
                </li>
                <li class="col-lg-3 col-md-6 padd_col_res">
                    <div class="team_member">
                        <img src="Design/images/team-2.jpg" alt="Team Member">
                    </div>
                </li>
                <li class="col-lg-3 col-md-6 padd_col_res">
                    <div class="team_member">
                        <img src="Design/images/team-3.jpg" alt="Team Member">
                    </div>
                </li>
                <li class="col-lg-3 col-md-6 padd_col_res">
                    <div class="team_member">
                        <img src="Design/images/team-4.jpg" alt="Team Member">
                    </div>
                </li>
            </ul>
        </div>
    </section>

    <!-- REVIEWS SECTION -->

    <section id="reviews" class="testimonial_section">
        <div class="container">
            <div id="reviews-carousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#reviews-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#reviews-carousel" data-slide-to="1"></li>
                    <li data-target="#reviews-carousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <!-- REVIEW 1 -->
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="Design/images/barbershop_image_1.jpg" alt="First slide" style="visibility: hidden;">
                        <div class="carousel-caption d-md-block">
                            <h3>Its Not Just a Haircut, Its an Experience.</h3>
                            <p>
                                Our barbershop is the territory created purely for males who appreciate
                                <br>
                                premium quality, time and flawless look.
                            </p>
                        </div>
                    </div>
                    <!-- REVIEW 2 -->
                    <div class="carousel-item">
                        <img class="d-block w-100" src="Design/images/barbershop_image_1.jpg" alt="First slide"  style="visibility: hidden;">
                        <div class="carousel-caption d-md-block">
                            <h3>Its Not Just a Haircut, Its an Experience.</h3>
                            <p>
                                Our barbershop is the territory created purely for males who appreciate
                                <br>
                                premium quality, time and flawless look.
                            </p>
                        </div>
                    </div>
                    <!-- REVIEW 3 -->
                    <div class="carousel-item">
                        <img class="d-block w-100" src="Design/images/barbershop_image_1.jpg" alt="First slide"  style="visibility: hidden;">
                        <div class="carousel-caption d-md-block">
                            <h3>Its Not Just a Haircut, Its an Experience.</h3>
                            <p>
                                Our barbershop is the territory created purely for males who appreciate
                                <br>
                                premium quality, time and flawless look.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- PREVIOUS & NEXT -->
                <a class="carousel-control-prev" href="#reviews-carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#reviews-carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </section>

    <!-- PRICING SECTION  -->

    <section class="pricing_section" id="pricing">

        <!-- START GET CATEGORIES  PRICES FROM DATABASE -->

            <?php

                $stmt = $con->prepare("Select * from service_categories");
                $stmt->execute();
                $categories = $stmt->fetchAll();

            ?>

        <!-- END -->

        <div class="container">
            <div class="section_heading">
                <h3>Barber and SALON</h3>
                <h2>Our Barber Pricing</h2>
                <div class="heading-line"></div>
            </div>
            <div class="row">
                <?php

                    foreach($categories as $category)
                    {
                        $stmt = $con->prepare("Select * from services where category_id = ?");
                        $stmt->execute(array($category['category_id']));
                        $totalServices =  $stmt->rowCount();
                        $services = $stmt->fetchAll();

                        if($totalServices > 0)
                        {
                        ?>

                            <div class="col-lg-4 col-md-6 sm-padding">
                                <div class="price_wrap">
                                    <h3><?php echo $category['category_name'] ?></h3>
                                    <ul class="price_list">
                                        <?php

                                            foreach($services as $service)
                                            {
                                                ?>

                                                    <li>
                                                        <h4><?php echo $service['service_name'] ?></h4>
                                                        <p><?php echo $service['service_description'] ?></p>
                                                        <span class="price">₱<?php echo $service['service_price'] ?></span>
                                                    </li>

                                                <?php
                                            }

                                        ?>
                                        
                                    </ul>
                                </div>
                            </div>

                        <?php
                        }
                    }

                ?>
                
            </div>
        </div>
    </section>

    <!-- CONTACT SECTION -->

    <section class="contact-section" id="contact-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 sm-padding">
                    <div class="contact-info">
                        <h2>
                            Get in touch with us & 
                            <br>send us message today!
                        </h2>
                        <p>
                            Saasbiz is a different kind of architecture practice. Founded by Renz in 2014, we’re an employee-owned firm pursuing a democratic design process that values everyone’s input.
                        </p>
                        <h3>
                            Tambac, Malasiqui, Pangasinan
                            <br>
                            Paradahan ng Dagupan Bus
                        </h3>
                        <h4>
                            <span style = "font-weight: bold">Email:</span> 
                            cuttrendz@gmail.com
                            <br> 
                            <span style = "font-weight: bold">Phone:</span> 
                            0950 110 3654
                            <br> 
                        </h4>
                    </div>
                </div>
                <div class="col-lg-6 sm-padding">
                    <div class="contact-form">
                        <form action="contact_process.php" method="POST" class="contactForm">
                            <div class="form-group colum-row row">
                                <div class="col-sm-6">
                                    <input type="text" id="contact_name" name="name" class="form-control" placeholder="Name">
                                </div>
                                <div class="col-sm-6">
                                    <input type="email" id="contact_email" name="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="text" id="contact_subject" name="subject" class="form-control" placeholder="Subject">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <textarea id="contact_message" name="message" cols="30" rows="5" class="form-control message" placeholder="Message"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="submit" class="default_btn">Send Message</button>
                                </div>
                            </div>
                            <img src="Design/images/ajax_loader_gif.gif" id = "contact_ajax_loader" style="display: none">
                            <div id="contact_status_message"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FLOATING ACTION BUTTONS FOR AI FEATURES -->
    <div class="floating-buttons">
        <button class="floating-btn ai-analysis-btn" onclick="openAnalysisModal()" title="AI Face Analysis">
            <i class="fas fa-camera"></i>
        </button>
        <button class="floating-btn chatbot-btn" onclick="toggleChatbox()" title="AI Chat Assistant">
            <i class="fas fa-comments"></i>
        </button>
    </div>

    <!-- AI FACE ANALYSIS MODAL -->
    <div id="analysisModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <button class="close-btn" onclick="closePopup('analysisModal')">&times;</button>
            <div class="modal-header">
                <h2><i class="fas fa-camera"></i> AI Face Shape Analysis</h2>
                <p>Discover your face shape and get personalized haircut recommendations</p>
            </div>
            <div class="modal-body">
                <div class="info-message">
                    <strong>📸 How it works:</strong>
                    First select your gender, then position your face in the frame and click "Start Analysis" when ready. Our AI will detect your face shape and recommend the best haircuts for you.
                    <br><br>
                    <strong>⚠️ Important:</strong> Use your real face in good lighting - not illustrations, photos on screens, or cartoons for accurate results.
                </div>

                <div class="gender-selection" id="genderSelectionBlock">
                    <h5><i class="fas fa-user"></i> Select Gender</h5>
                    <div class="gender-options">
                        <label class="gender-option" for="genderMale">
                            <input type="radio" id="genderMale" name="analysis_gender" value="male">
                            <span>Male</span>
                        </label>
                        <label class="gender-option" for="genderFemale">
                            <input type="radio" id="genderFemale" name="analysis_gender" value="female">
                            <span>Female</span>
                        </label>
                    </div>
                </div>
                
                <div class="video-container">
                    <video id="video" width="480" height="360" autoplay></video>
                    <canvas id="overlay" width="480" height="360"></canvas>
                </div>
                
                <button id="startAnalysis" class="analysis-btn" disabled>Select Gender First</button>
                
                <div id="analysisResults" class="results-section">
                    <h3>Your Results:</h3>
                    <div id="faceShapeResult"></div>
                    <h4 style="margin-top: 25px;">Recommended Haircuts:</h4>
                    <div id="recommendations"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- AI CHATBOT WIDGET -->
    <div id="chatbotWidget" class="chatbot-widget">
        <div class="chatbot-header">
            <i class="fas fa-comments"></i>
            <span onclick="toggleChatbox()">AI Assistant</span>
            <button class="minimize-btn" onclick="toggleChatbox(); event.stopPropagation();">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
        <div class="chatbot-body">
            <div id="chatMessages" class="chat-messages">
                <div class="bot-message">
                    <p>Hello! 👋 I'm your AI haircut assistant. I can help you with:<br>
                    • Face shape analysis<br>
                    • Haircut recommendations<br>
                    • Style maintenance tips<br>
                    • Pricing information<br><br>
                    What would you like to know?</p>
                </div>
            </div>
            <div class="chat-input-container">
                <input type="text" id="chatInput" placeholder="Type your message..." onkeypress="handleChatEnter(event)">
                <button class="send-btn" onclick="sendMessage()">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- WIDGET SECTION / FOOTER -->

    <section class="widget_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer_widget">
                        <img src="Design/images/sana.png" alt="Brand">
                        <p>
                            Our barbershop is the created for men who appreciate premium quality, time and flawless look.
                        </p>
                        <ul class="widget_social">
                            <li><a href="#" data-toggle="tooltip" title="Facebook"><i class="fab fa-facebook-f fa-2x"></i></a></li>
                            <li><a href="#" data-toggle="tooltip" title="Twitter"><i class="fab fa-twitter fa-2x"></i></a></li>
                            <li><a href="#" data-toggle="tooltip" title="Instagram"><i class="fab fa-instagram fa-2x"></i></a></li>
                            <li><a href="#" data-toggle="tooltip" title="LinkedIn"><i class="fab fa-linkedin fa-2x"></i></a></li>
                            <li><a href="#" data-toggle="tooltip" title="Google+"><i class="fab fa-google-plus-g fa-2x"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                     <div class="footer_widget">
                        <h3>Locations</h3>
                        <p>
                            Tambac, Malasiqui, Pangasinan
                            <br>
                            Paradahan ng Dagupan Bus
                        </p>
                        <p>
                            cuttrendz@gmail.com
                            <br>
                            0950 110 3654  
                        </p>
                     </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer_widget">
                        <h3>
                            Opening Hours
                        </h3>
                        <ul class="opening_time">
                            <li>Monday - Friday 11:30am - 2:008pm</li>
                            <li>Monday - Friday 11:30am - 2:008pm</li>
                            <li>Monday - Friday 11:30am - 2:008pm</li>
                            <li>Monday - Friday 11:30am - 2:008pm</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER  -->

    <?php include "Includes/templates/footer.php"; ?>