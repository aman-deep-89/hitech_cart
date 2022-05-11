<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($store_info->store_username).' | '.$store_info->seo_title; ?></title>

    <link href="<?php echo site_url('public/assets/css/css2.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('public/assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo site_url('public/assets/css/bootstrap-icons.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('public/assets/css/style.css'); ?>">
    <meta name="description" content="<?php echo $store_info->seo_description ?>">
    <meta name="keywords" content="<?php echo $store_info->seo_keywords ?>">    
</head>

<body>
    <div id="loader"></div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom justify-items-start shadow-sm sticky-top">
        <div class="container">
            <button class="btn btn-sm btn-primary">Download Hitech App</button>
            <div class="fw-500 ms-4 header-text">Most simple and powerfull billing software</div>
            <div class="ms-auto d-flex align-items-center">
                <div>
                    <div class="small font-11">Powered by</div>
                    <img src="<?php echo site_url('public/uploads/'.$store_info->logo); ?>" alt="" width="80">
                </div>
            </div>
        </div>
    </nav>
    <!-- Shop Card Banner shows when scroll bottom -->
    <div class="customer-banner"></div>

    <div class="header-section">
    <img src="<?php echo site_url('public/uploads/'.$store_info->banner); ?>" alt="" srcset="">
    </div>
    <div class="card-header bg-white">
        <div class="comp-info container">
            <div class="header-banner">
                <div class="logo-avatar shadow">
                    <img src="<?php echo site_url('public/uploads/'.$store_info->logo_sm); ?>" alt="">
                </div>
                <div class="banner-text">
                    <h4 class="mb-2"><?= $store_info->store_name ?></h4>
                    <div class="d-md-flex">
                        <div class="text-muted pe-3">GST NO. <b><?= $store_info->gst_tin ?></b></div> <span class="line"> |</span>
                        <div class="text-dark ps-md-3"><i class="bi-geo-alt-fill"></i> <?= $store_info->address.' '.$store_info->pin_code ?></div>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center flex-wrap cart-parent">
                <div class="m-w-50">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="bi-telephone"></i></span>
                        <input type="text" class="form-control form-control-sm" disabled="" value="+91 8569542359"
                            aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="m-d-block d-md-none m-ms-auto">
                    <button class="btn btn-sm btn-outline-primary"><i class="bi-share-fill me-2"></i>Share
                        Profile</button>
                </div>
                <div class="ms-auto d-flex align-items-center cart-header cart-wrapper">
                    <div class="me-3 m-d-none">
                        <button class="btn btn-sm btn-outline-primary"><i class="bi-share-fill me-2"></i>Share
                            Profile</button>
                    </div>
                    <a href="mailto:<?php echo $store_info->email_id; ?>" class="ms-3 text-muted">
                        <i class="bi-envelope font-22"></i>
                    </a>
                    <a href="<?php echo $store_info->fb_link; ?>" class="ms-3 facebook">
                        <i class="bi-facebook font-22"></i>
                    </a>
                    <a href="<?php echo $store_info->twitter_link; ?>" class="ms-3 twitter">
                        <i class="bi-twitter font-22"></i>
                    </a>
                    <a href="<?php echo $store_info->pinterest_link; ?>" class="ms-3 pintrest">
                        <i class="bi-pintrest font-22"></i>
                    </a>
                    <a href="<?php echo site_url($store_info->store_username.'/cart'); ?>" class="text-dark text-decoration-none home-cart-btn">
                        <div class="d-flex align-items-center ps-3 mr-2">
                            <div class="cart position-relative">
                                <i class="bi-cart4"></i>
                                <div class="badge bg-danger" id="total_qty"><?= $data['total_qty']; ?></div>
                            </div>
                            <div class="ms-3">
                                <small class="text-muted">My Cart</small>
                                <h6>₹ <span id="total_price"><?= $data['total_price']; ?></span></h6>
                            </div>
                        </div>
                    </a>
                    <?php if(logged_in()) { ?>
                        <a href="<?= base_url('User')  ?>" class="d-flex align-items-center text-decoration-none text-dark lh-1 ms-4">
                            <i class="bi-person-circle me-2 font-20"></i> Account
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
		<div class="container">            
            <?php $last_id=5; $this->renderSection('main') ?>
		</div>
		<footer>
        <div class="footer-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <h5 class="mb-4 text-uppercase footer-heading">Store Details</h5>
                        <ul class="ps-0">
                            <li class="d-flex mb-2">
                                <div>
                                    <div class="footer-icon">
                                        <i class="bi-geo-alt-fill"></i>
                                    </div>
                                </div>

                                <div class="font-15">
                                   <?= $store_info->full_address ?>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <div>
                                    <div class="footer-icon">
                                        <i class="bi-telephone-fill"></i>
                                    </div>
                                </div>
                                <div class="font-15">
                                <?= $store_info->phone_number ?>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <div>
                                    <div class="footer-icon">
                                        <i class="bi-envelope-fill"></i>
                                    </div>
                                </div>
                                <div class="font-15">
                                    <?= $store_info->email_id ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3 offset-sm-1">
                        <h5 class="mb-4 text-uppercase footer-heading newsletter-heading">Social Contact</h5>
                        <ul class="list-unstyled">                        
                            <li class="mb-3">
                                <a href="<?php echo $store_info->instal_link; ?>" class="text-dark text-decoration-none">
                                    <i class="bi-instagram me-2"></i> Instagram
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="<?php echo $store_info->twitter_link; ?>" class="text-dark text-decoration-none">
                                    <i class="bi-twitter me-2"></i> Twitter
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="<?php echo $store_info->fb_link; ?>" class="text-dark text-decoration-none">
                                    <i class="bi-facebook me-2"></i> Facebook
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="mailto:<?php echo $store_info->email_id; ?>" class="text-dark text-decoration-none">
                                    <i class="bi-envelope me-2"></i> Email
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-5 col-12">
                        <h5 class="mb-4 text-uppercase newsletter-heading footer-heading">About Us</h5>
                        <p><?= $store_info->about_us ?> </p>

                    </div>
                </div>
            </div>
            <hr>
            <div class="copyright-footer">
                <div class="container">
                    <div class="d-md-flex align-items-center">
                        <p class="mb-md-0 me-4 m-mb-2">
                            <a href="">Sell on Hitech</a> |
                            <a href="">Download the app</a>
                        </p>
                        <!-- <a href="" class="me-2"><img src="<?php echo site_url('public/assets/images/appstore.png"'); ?> height="30"></a>
                        <a href=""><img src="<?php echo site_url('public/assets/images/playmarket.png"'); ?> height="30"></a> -->
                        <div class="ms-auto m-mt-2">
                            &copy; <?php date('Y'); ?>, Powered by Hitech.
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="app_name" value="<?= $store_info->store_name; ?>" />
            <input type="hidden" id="store_name" value="<?= $store_info->store_username; ?>" />
            <input type="hidden" id="gst_no" value="<?= $store_info->gst_tin; ?>" />
            <input type="hidden" id="address" value="<?= $store_info->address; ?>" />
            <input type="hidden" id="phone" value="<?= $store_info->phone_number; ?>" />
            <input type="hidden" id="pin_code" value="<?= $store_info->pin_code; ?>" />
            <input type="hidden" id="logo" value="<?php echo site_url('public/uploads/'.$store_info->logo_sm); ?>" />
            <input type="hidden" id="base_url" value="<?php echo site_url(); ?>" />
            <input type="hidden" id="csrfTokenName" value="<?= csrf_token() ?>" />
            <input type="hidden" id="csrfTokenValue" value="<?= csrf_hash() ?>" />
    </footer>
    <script src="<?php echo site_url('public/assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo site_url('public/assets/js/jquery-3.5.1.min.js'); ?>"></script>
    <script src="<?php echo site_url('public/assets/js/script.js'); ?>"></script>
    <script>
        $(function() {
            $('#grid').hide();
        });
        function toggle() {
            var list = document.getElementById('grid');
            var grid = document.getElementById('list');
            document.getElementById("icon").classList.toggle('bi-list-ul');
            if (list.style.display == 'block' && grid.style.display == 'none') {
                list.style.display = 'none';
                grid.style.display = 'block';
            }
            else {
                grid.style.display = 'none';
                list.style.display = 'block';
            }
        }
    </script>
    <?php $this->renderSection('pageScripts'); ?>
</body>


</html>