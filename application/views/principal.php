<!DOCTYPE html>
<html> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>MbanguPay</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="favicon.ico">

        <link rel="stylesheet" href="<?php echo base_url().'bcspage/assets/css/slick.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url().'bcspage/assets/css/slick-theme.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url().'bcspage/assets/css/animate.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url().'bcspage/assets/css/fonticons.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url().'bcspage/assets/css/font-awesome.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url().'bcspage/assets/css/bootstrap.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url().'bcspage/assets/css/magnific-popup.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url().'bcspage/assets/css/bootsnav.css'; ?>">

        <link rel="stylesheet" href="<?php echo base_url().'bcspage/assets/css/style.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url().'bcspage/assets/css/responsive.css'; ?>" />
        <script src="<?php echo base_url().'bcspage/assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js'; ?>"></script>
    </head>
    <body data-spy="scroll" data-target=".navbar-collapse">
        <!-- Preloader -->
        <div id="loading">
            <div id="loading-center">
                <div id="loading-center-absolute">
                    <div class="object" id="object_one"></div>
                    <div class="object" id="object_two"></div>
                    <div class="object" id="object_three"></div>
                    <div class="object" id="object_four"></div>
                </div>
            </div>
        </div><!--End off Preloader -->
        <div class="culmn">
            <!--Home page style-->
            <nav class="navbar navbar-default navbar-fixed white no-background bootsnav">
                <!-- Start Top Search -->
                <div class="top-search">
                    <div class="container">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
                        </div>
                    </div>
                </div>
                
                <!-- End Top Search -->
                <div class="container">    
                    <!-- Start Atribute Navigation -->
                    <!-- <div class="attr-nav">
                        <ul>
                            <li class="dropdown">
                            <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                            <li class="side-menu"><a href="#"><i class="fa fa-bars"></i></a></li>
                        </ul>
                    </div>         -->
                    <!-- End Atribute Navigation -->
                    <!-- Start Header Navigation -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <!-- End Header Navigation -->
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                            <li><a href="<?php echo site_url('AdminCredential/'); ?>">Ecole</a></li>                    
                            <li><a href="AdminCredential/loginBanque">Banque</a></li>                    
                            <li><a href="AdminCredential/loginAdmin">Autres</a></li>                     
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div>  
            </nav>
            <!--Home Sections-->
            <section id="hello" class="home bg-mega">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row">
                        <div class="main_home">
                            <div class="home_text">
                                <h1 class="text-white">MBANGUPAY</h1>
                            </div>
                            <div class="home_btns m-top-40">
                                <a href="" class="btn btn-primary m-top-20">GET STARTED</a>
                                <a href="" class="btn btn-default m-top-20">DOWNLOAD NOW</a>
                            </div>
                        </div>
                    </div><!--End off row-->
                </div><!--End off container -->
            </section> <!--End off Home Sections-->
            <footer id="footer" class="footer bg-black">
                <div class="container">
                    <div class="row">
                        <div class="main_footer text-center p-top-40 p-bottom-30">
                            <p class="wow fadeInRight" data-wow-duration="1s">
                                Made with 
                                <i></i>
                                by 
                                <a target="_blank" href="http://bcs-it.cd">business computer services</a> 
                                BCS
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
            <!-- JS includes -->
            <script src="<?php echo base_url().'bcspage/assets/js/vendor/jquery-1.11.2.min.js'; ?>"></script>
            <script src="<?php echo base_url().'bcspage/assets/js/vendor/bootstrap.min.js'; ?>"></script>
            <script src="<?php echo base_url().'bcspage/assets/js/jquery.magnific-popup.js'; ?>"></script>
            <script src="<?php echo base_url().'bcspage/assets/js/jquery.easing.1.3.js'; ?>"></script>
            <script src="<?php echo base_url().'bcspage/assets/js/slick.min.js'; ?>"></script>
            <script src="<?php echo base_url().'bcspage/assets/js/jquery.collapse.js'; ?>"></script>
            <script src="<?php echo base_url().'bcspage/assets/js/bootsnav.js'; ?>"></script>
            <!-- paradise slider js -->
            <script src="<?php echo base_url().'bcspage/assets/js/gmaps.min.js'; ?>"></script>

            <script>
                            function showmap() {
                                var mapOptions = {
                                    zoom: 8,
                                    scrollwheel: false,
                                    center: new google.maps.LatLng(-34.397, 150.644),
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                };
                                var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
                                $('.mapheight').css('height', '350');
                                $('.maps_text h3').hide();
                            }
            </script>
            <script src="<?php echo base_url().'bcspage/assets/js/plugins.js'; ?>"></script>
            <script src="<?php echo base_url().'bcspage/assets/js/main.js'; ?>"></script>
    </body>
</html>
