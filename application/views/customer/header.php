<?php
$TYPE = $_SESSION['type'];
$logged_in = FALSE;
if($this->session->userdata($TYPE)){
    $session_obj = $this->session->userdata($TYPE);
	//echo "<pre>"; print_r($session_obj); echo "</pre>";
	$logged_in = $session_obj['logged_in'];
	$name      = $session_obj['fname'];
  $image     = isset($session_obj['image']) ? $session_obj['image'] : '';
}

$controller = $this->router->fetch_class();
$model = $this->router->fetch_method();

//echo $session_id = $_SESSION['__ci_last_regenerate']; 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Klentano Shop</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="/assets/frontend/css/bootstrap-4.3.1.css">
        <link rel="stylesheet" href="/assets/frontend/css/font-awesome.min.css">
        <link rel="stylesheet" href="/assets/frontend/css/slick.css">
        <link rel="stylesheet" href="/assets/frontend/css/slick-theme.css">
        <link rel="stylesheet" href="/assets/frontend/css/style.css">
		    <link rel="stylesheet" href="/assets/frontend/css/custom_style.css">
        <link rel="stylesheet" href="/assets/plugins/parsley/parsley.css" />
        <script src="/assets/frontend/js/jquery.min.js"></script>
        <script src="/assets/frontend/js/popper.min.js"></script>
        <script src="/assets/frontend/js/bootstrap-4.3.1.js"></script>
        <script src="/assets/plugins/sweetalert/sweetalert.min.js"></script>
        <script src="/assets/plugins/parsley/parsley.min.js"></script>
        <script src="/assets/frontend/js/slick.js"></script>
        <script src="/assets/frontend/js/app.js"></script>
    </head>
    <body>
        <header>
            <div id="sidebar">
            <div class="widget-title">
             <h4>categories<a href="#" class="mob-menu mob-menu-icon "><i class="fa fa-times"></i></a></h4>
        </div>
          <div class="widget-content">
             <ul id="accordion" class="CategoryList">
             </ul>
          </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-3 logo">
                      <a class="mob-menu" href="#"><i class="fa fa-bars fa-2x"></i></a>
                      <a href="<?php echo base_url(); ?>" alt="logo"><img src="/assets/frontend/images/logo.png" alt="" class="img-fluid l1"></a>
                      <a href="<?php echo base_url(); ?>" alt="logo"><img src="/assets/frontend/images/logo-2.png" alt="" class="img-fluid l2"></a>
                    </div>
                    <div class="col-md-9">
                        <div class="top-menu">
                            <a href="<?=base_url();?>page/about"><span>About</span></a>
                            <a href="<?=base_url();?>page/blog"><span>Blog</span></a>
                            <a href="<?=base_url();?>page/contact-us"><span>Contact</span></a>
                            <a href="<?=base_url();?>page/help--faqs"><span>Help & FAQs</span></a>
							<?php 
                            $default_currency = default_currency();
                            $currency =get_currency();
							?>
							<select name="currencies" id="currencies_combo">
								<?php foreach($currency as $k=>$v){ 
                                    $selected = ($v->currency_id == $default_currency) ? 'selected' : '';
                                ?>
									<option value="<?php echo $v->currency_id; ?>" <?= $selected ?>><?php echo $v->iso_code; ?></option>	
								<?php } ?>
                            </select>
							<?php 
                            $default_language = default_language();
							$language =get_language();
							?>
                           <select name="language" id="language_combo">
                               <?php foreach($language as $k=>$v){
                                    $selected = ($v->language_id == $default_language) ? 'selected' : '';
                                 ?>
									<option value="<?php echo $v->language_id; ?>" <?= $selected ?>><?php echo $v->name; ?></option>	
								<?php } ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-10 search">
                                <input type="text" name="" placeholder="Search product ...">
                                <img src="/assets/frontend/images/search.png" class="" alt="">
                            </div>
                            <div class="col-md-2 help-menu">
                                <!--<a href="#" class="phone"><img src="/assets/frontend/images/phone.png"><span>CALL US NOW<br><strong>+123 5678 890</strong></span></a>-->

                                <?php if($logged_in){ ?>
                                <a class="dropdown-toggle acc" data-toggle="dropdown" href="#"><img src="/assets/frontend/images/account.png"><br>
                                    <span class="nm" id="login_out">Hi, <?= $name; ?></span>
                                    <ul class="dropdown-menu">
                                        <li><a href="/<?= $TYPE?>/profile"><i class="fa fa-user"></i> My Accunt</a></li>
                                        <li><a href="/<?= $TYPE?>/auth/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
                                    </ul>
                                </a>
                                <?php }else{ ?>
                                <a class="dropdown-toggle acc" data-toggle="dropdown" href="#"><img src="/assets/frontend/images/account.png"><br>
                                    <span class="nm" id="login">LogIn</span>
                                    <ul class="dropdown-menu">
                                        <li><a href="/<?= $TYPE?>/auth/register"><i class="fa fa-user"></i> Register</a></li>
                                        <li><a href="/<?= $TYPE?>/auth/login"><i class="fa fa-user"></i> LogIn</a></li>
                                    </ul>
                                </a>
                                <?php }
								
								?>
                                <!--<a href="#"><img src="/assets/frontend/images/short.png"><br><span>Wishlist</spsn></a>-->
                                <a href="/cart"><img src="/assets/frontend/images/cart.png"><br><span><sup id="cart_count"><?= cart_item_count(); ?></sup>Cart</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
