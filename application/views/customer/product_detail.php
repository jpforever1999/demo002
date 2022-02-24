<?php
    $TYPE = $_SESSION['type']; 
    $customer_id = '';
    $logged_in = FALSE;
    if($this->session->userdata($TYPE)){
        $session_obj = $this->session->userdata($TYPE);
        $logged_in   = $session_obj['logged_in'];
        $name        = $session_obj['fname'];
        $customer_id = $session_obj['login_id'];
        $image       = isset($session_obj['image']) ? $session_obj['image'] : '';
    }
    
    $controller = $this->router->fetch_class();
    $model = $this->router->fetch_method();
    //currency and rate
    $default_currency = default_currency();
    $currency =get_currency($default_currency);
    $rate = $currency->rate;
    $symbol = $currency->symbol;
    ?>
<section class="productdetail" id="post-<?php echo $detail->product_id;  ?>">
    <div class="container">
        <?= $breadcrumbs ?> 
        <hr>
        <div class="row mb-4">
            <div class="col-md-9">
                <!-- main slider carousel -->
                <div class="row pd-box">
                    <?php if(isset($product_gallery) && !empty($product_gallery)){ ?>
                    <div class="col-lg-5" id="slider">
                        <a class="wish" href='javascript:void(0);' data-data="<?=$detail->product_id; ?>" id="WishlistProduct" ><i class="fa fa-heart-o fa-2x"></i></a>
                        <div id="msg"></div>
                        <div id="carousel-bounding-box">
                            <div id="bannerCarousel" class="carousel slide">
                                <div class="carousel-inner">
                                    <!-- main slider carousel items -->
                                    <?php 
                                        foreach($product_gallery as $k=>$v){									
                                        ?> 
                                    <div class="item carousel-item <?php if($k==0) { echo "active"; } ?>" data-slide-number="<?php echo $k ?>">
                                        <img src="<?php echo $v->url; ?>" alt="<?php echo $v->file_name; ?>" class="img-fluid">
                                    </div>
                                    <?php } ?>
                                </div>
                                <a class="carousel-control left display-1" href="#bannerCarousel" data-slide="prev">←</a>
                                <a class="carousel-control right display-1" href="#bannerCarousel" data-slide="next">→</a>
                            </div>
                        </div>
                        <div class="hidden-lg-down-down hidden-xs-down" id="slider-thumbs">
                            <!-- thumb navigation carousel items -->
                            <ul class="list-inline d-flex mt-2">
                                <?php foreach($product_gallery as $k=>$thumb){?>
                                <li class="list-inline-item">
                                    <a id="carousel-selector-<?php echo $k; ?>" <?php if($k==0) echo 'class="selected"'; ?> href="javascript:void(0);">
                                    <img src="<?php echo $v->url; ?>" alt="<?php echo $thumb->file_name; ?>" height="101px"class="img-fluid"> 
                                    </a>
                                </li>
                                <?php } ?> 
                            </ul>
                        </div>
                    </div>
                    <?php } 
                        //die;?>
                    <div class="col-md-7">
                        <div class="pro-detail" id="post-<?php echo (isset($detail->product_id)) ? $detail->product_id : ''; ?>">
                            <?php if($detail){ ?>
                            <h1><?php echo (isset($detail->post_title)) ? $detail->post_title : ''; ?></h1>
                            <?php } ?>	
                            <div class="review">
                                <a href="#ReviewBox"> <i class="fa fa-commenting-o" aria-hidden="true"></i> Read reviews (1)</a>  
                                <a href="#tab_default_3" id="WriteReview"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Write a review</a>
                                <a href="#ReviewBox" id="CloseWriteReview"><i class="fa fa-times" aria-hidden="true"></i> Close Write a review form</a>    
                            </div>
                            <div id="subform">
                                <?php if (validation_errors()!='') { ?>
                                <div class="alert alert-danger"> <?php echo validation_errors();?> </div>
                                <?php } ?>
                                <form class="contact-form-box cart" id="addtocart" method="post">
                                    <div class="price">
                                        <p><?php echo $sale_price = (isset($detail->sale_price) && !empty($detail->sale_price)) ? $symbol.$rate*$detail->sale_price : ''; ?> 
                                            <?php if($sale_price) {?><del><?php } ?>	
                                            <?php echo $regular_price = (isset($detail->regular_price) && !empty($detail->regular_price) ) ? $symbol.$rate*$detail->regular_price : ''; ?><?php if($sale_price) {?></del><?php } ?>	
                                            <?php if(isset($sale_price) && !empty($regular_price) ){ ?>
                                            <span> Save <?php 
                                                $sum = (float)$detail->regular_price- (float)$detail->sale_price; 
                                                $total = $sum*100/(float)$detail->regular_price;	
                                                echo sprintf('%.02f',$rate*$total); ?>%</span><?php } ?>
                                        </p>
                                    </div>
                                    <?php 
                                        $quantity_range = isset($detail->quantity_range) ? $detail->quantity_range : ''; 
                                        $price_range = isset($detail->price_range) ? $detail->price_range : ''; 
                                        $qty_range = unserialize($quantity_range);
                                        $pricerange = unserialize($price_range);
                                        $qty_price = array();
                                        if($qty_range[0] !='' && $pricerange[0] !=''){	
                                        	foreach($qty_range as $key => $val){
                                        		$qty_price[$qty_range[$key]] = $rate*$pricerange[$key];		
                                        	}
                                        }
                                        
                                        if(isset($qty_price) && !empty($qty_price) ){ ?>
                                    <div class="product-quin">
                                        <?php foreach($qty_price as $qty=>$price){ ?>
                                        <p><span><?= $qty; ?> Pieces</span><br><?= $symbol.$price ?></p>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                    <?php 
                                        if(isset($variation) && !empty($variation)){
                                          foreach($variation as $key=>$val){ ?>
                                    <div class="ctm_radio variation-item size" id="variation-<?= $key; ?>">
                                        <label for="<?php echo $key; ?>"><?= $key; ?> : </label>
                                        <?php foreach($val as $k=>$v){ ?> 
                                        <label class="category center-aligned time-period-right">
                                        <input type="radio" name="<?= $key?>" class="term_item term_item_<?= $key?>" data-id="<?php echo $v->attribute_item_id ?>" data-name="<?php echo $v->name ?>"  id="attr_itemid_<?php echo $v->attribute_item_id ?>" data-attrlvl="<?= $key?>" value="<?php echo $v->attribute_item_id ?>" required> <?php echo $v->name; ?>
                                        </label>
                                        <?php } ?>
                                    </div>
                                    <?php } } ?>
                                    <?php 
                                        if(isset($attributes) && !empty($attributes)){
                                          foreach($attributes as $key=>$val){ ?>
                                    <div class="ctm_radio attributes-item size" id="attribute-<?= $key; ?>">
                                        <label for="<?php echo $key; ?>"><?= $key; ?> : </label>
                                        <?php foreach($val as $k=>$v){ ?>
                                        <label class="category center-aligned time-period-right"><input class="term_item term_item_<?= $key?>" type="radio" name="<?= $key?>" data-id="<?php echo $v->attribute_item_id ?>" data-name="<?php echo $v->name ?>" id="attr_itemid_<?php echo $v->attribute_item_id ?>" data-attrlvl="<?= $key?>" value="<?php echo $v->attribute_item_id ?>"><?php echo $v->name; ?></label>
                                        <?php } ?>
                                    </div>
                                    <?php } } ?>
                                    <script>
                                        $("input[type=radio]").click(function() {
                                        	name=$(this).attr('name');
                                        	
                                               var attrlvl=$(this).attr('data-attrlvl'); 
                                        	$(".term_item_"+attrlvl).parent().removeClass('category_selected');
                                        	$(this).parent().addClass("category_selected");
                                           		
                                        });
                                    </script>
                                    <div class="d-flex">
                                        <div class="count">
                                            <div class="input-group numbering">
                                                <span class="input-group-btn"><a href="javascript:void(0);" class="btn btn-default quantity_update" data-id="minus" data-dir="dwn"><i class="fa fa-minus"></i></a></span>
                                                <input type="text" name="product_qty" class="form-control numeric text-center qty_update" value="1">
                                                <span class="input-group-btn"><a href="javascript:void(0);" class="btn btn-default quantity_update" data-id="plus" data-dir="up"><i class="fa fa-plus"></i></a></span>
                                            </div>
                                        </div>
                                        <div id="message"></div>
                                        <div class="cart-btn" id="product_id-<?php echo $detail->product_id; ?>">
                                            <?php
                                                $product_price = '';
                                                $sale_price = (isset($detail->sale_price)) ? $detail->sale_price : '';
                                                $regular_price = (isset($detail->regular_price)) ? $detail->regular_price : '';
                                                if($sale_price){
                                                	$product_price=$sale_price;
                                                }else{
                                                	$product_price = $regular_price;
                                                }
                                                ?> 
                                            <?php 
                                                $title = $detail->post_title = $detail->post_title;
                                                $myJSON = json_encode($title);
                                                ?>
                                            <input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />
                                            <input type="hidden" name="product_id" value="<?php echo (isset($detail->product_id)) ? $detail->product_id : ''; ?>" />
                                            <input type="hidden" name="product_net_revenue" value="<?php echo $product_price; ?>" />
                                            <input type="hidden" name="product_name" id="var_name_json" value='<?php echo '[{"title":'.$myJSON.'}]'; ?>' />
                                            <input type="hidden" name="variation_id" id="var_id_jason"  value='0' />
                                            <button type="submit" name="add-to-cart" value="<?php echo (isset($detail->product_id)) ? $detail->product_id : ''; ?>" class="fa fa-shopping-bag single_add_to_cart_button button alt"> ADD TO CART</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="payment mt-3">
                                Payment Method <br>
                                <img src="/assets/frontend/images/payment.png" alt="" class="img-fluid">
                            </div>
                            <div class="social-cont">
                                <div class="social mt-2 ">
                                    <span class="text-left">Share</span>
                                    <a class="social-icon facebook" target="blank" data-tooltip="Facebook" href="">
                                    <i class="fa fa-facebook"></i>
                                    </a>
                                    <a class="social-icon twitter" target="blank" data-tooltip="Twitter" href="">
                                    <i class="fa fa-twitter"></i>
                                    </a>
                                    <a class="social-icon google-plus" target="blank" data-tooltip="Google +" href="">
                                    <i class="fa fa-google-plus"></i>
                                    </a>
                                    <a class="social-icon email" target="blank" data-tooltip="Instagram" href="">
                                    <i class="fa fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="tabbable-panel">
                            <h1 class="border-bottom">DESCRIPTION   </h1>
                            <div class="tab-pane mb-4">
                            <?php if(isset($detail->post_content)){
                                echo (isset($detail->post_content)) ? $detail->post_content : '';
                                }else{				
                                echo '<div class="alert alert-warning">No data available!</div>';
                            } ?>                                       
                            </div>
                            <h1 class="border-bottom">Review    </h1>
                            <div class="tab-pane">
                                <div class="container p-0">
                                    <div class="form-group w-100 revi">
                                    <form class="form-group" id="FromReview"  method="post">
                                        <input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />
                                        <input type="hidden" name="comment_post_ID" value="<?= $detail->product_id; ?>" />
                                        <input type="hidden" name="user_id" value="<?= isset($customer_id) ? $customer_id : ''?>">
                                        <textarea class="form-control" required id="comment" name="comment_content" placeholder=" Write a review"></textarea>
                                        <div class="form-group" id="rating-ability-wrapper">
                                            <label class="control-label" for="rating">
                                            <span class="field-label-info"></span>
                                            <input type="hidden" id="rating" name="rating" value="" required="required">
                                            </label>
                                            <h2 class="bold rating-header" style="">
                                                <span class="selected-rating">0</span><small> / 5</small>
                                            </h2>
                                            <button type="button" class="btnrating btn btn-default btn-lg" data-attr="1" id="rating-star-1">
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btnrating btn btn-default btn-lg" data-attr="2" id="rating-star-2">
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btnrating btn btn-default btn-lg" data-attr="3" id="rating-star-3">
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btnrating btn btn-default btn-lg" data-attr="4" id="rating-star-4">
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btnrating btn btn-default btn-lg" data-attr="5" id="rating-star-5">
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <button class="btn btn-lg btn-light sbbb">Submit</button>
                                    </div>
                                    </form>
                                    <hr>
                                    <div id="ReviewRating" style="display:none;">
                                        <div class="one-review">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h2 class="font-weight-bold">Rahul Roy</h2>
                                                </div>
                                                <div class="col-md-6 text-success text-right">
                                                    <small>30th Jan 2021</small>
                                                </div>
                                            </div>
                                            <div class="row pt-2">
                                                <div class="col-md-12">
                                                    <p>I think I started out at under $3 per month 5 or 6 years ago. The price has steadily increased and my latest renewal offer was $16.99 per month. Additionally last year my wife started having spam problems and it seems like someone gained access to all her email correspondence.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <?php $cart = get_cart();
                    $item = '';
                    $gtotal = 0;$total=0;	
                    foreach($cart as $key=>$val){			
                    $gtotal+= $val['product_qty']*$val['product_net_revenue'];
                    $data = json_decode($val['order_item_name']);			
                    $total = (float) $val['product_qty']* (float)$val['product_net_revenue'];
                    $item .=$key.',';
                    }
                    ?>
                <div class="cart-totals p-3 border">
                    <h3>Cart Totals</h3>
                    <hr>
                    <form action="/checkout" method="POST" accept-charset="utf-8">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td class="subtotal"><?php echo $Subtotal = $symbol.''.sprintf('%.02f',$rate*$gtotal); ?></td>
                                </tr>
                                <tr>
                                    <td class="pb-4">Shipping</td>
                                    <td class="free-shipping pb-4">Free Shipping</td>
                                </tr>
                                <tr class="total-row">
                                    <td>Total</td>
                                    <td class="price-total"><?php echo $Subtotal = $symbol.''.sprintf('%.02f',$rate*$gtotal); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="btn-cart-totals">
                            <?php $subtotal_hidden = sprintf('%.02f',$rate*$gtotal); ?>
                            <input type="hidden" name="cart_item" id="cart_item" value="<?php echo rtrim($item, ','); ?>">
                            <input type="hidden" name="proceed_amount" id="proceed_amount" value="<?php echo $subtotal_hidden; ?>">
                            <input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />	
                            <button type="submit" name="submit" value="submit" class="update btn-checkout">Proceed to Checkout </button>
                        </div>
                        <!-- /.btn-cart-totals -->
                    </form>
                    <!-- /form -->
                </div>
                <?=$delivery_return_widget; ?>
                <?=$seller_imformation; ?>  
            </div>
            <!--/main slider carousel-->
            <!-- thumb navigation carousel -->
        </div>
    </div>
</section>
<?php //echo "<pre>"; print_r($related_post); echo "</pre>"; 
    if(isset($related_post) && !empty($related_post)){ ?>
<section class="arrivals">
    <div class="container p-0">
        <h1 class="featured-head  mb-3">Related Products</h1>
    </div>
    <div class="container">
        <div class="row hp_slick">
            <?php foreach($related_post as $k=>$v){ 			
                $args_image = array('product_id' => $v->product_id );
                $thumb_img = $this->Query_model->get_data('ec_gallery',$args_image);
                if(isset($thumb_img) && !empty($thumb_img)){
                	$img = $thumb_img[0]->file_name;
                } ?>
            <div id="product_id-<?php echo $v->product_id; ?>">
                <div class="white_box p-2 text-center">
                    <a href="<?php echo get_permalink($v->post_slug); ?>" title="post title">
                        <?php if( isset($img) && !empty($img) ){ ?><img src="<?php echo base_url(); ?>assets/uploads/files/<?php echo $img; ?>" alt="<?php echo $img; ?>" class="img-fluid"><?php } ?>
                        <h4><?= $v->post_title; ?></h4>
                        <h6><?= $v->regular_price; ?></h6>
                    </a>
                    <button type="button" name="add-to-cart" data-product-id="<?php echo (isset($v->product_id)) ? $v->product_id : ''; ?>" data-variation-id="0" data-quantity="1" class="btn  btn-primary add_to_cart"> ADD TO CART</button>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php } //related post ?>
<script src="/assets/frontend/js/app.js"></script> 
<script>
    $(document).on('ready', function() {
        $(".hp_slick").slick({
            dots: true,
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            margin:5,
            pauseOnHover: true,
            responsive: [
            {
                breakpoint: 1040,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
         }); 
       }); 
             
        $(document).on('hover', '.dropdown-menu', function (e) {
        e.stopPropagation();
    });
        
    $('#myCarousel').carousel({
       interval: 4000
    });
    
    // handles the carousel thumbnails
    $('[id^=carousel-selector-]').click( function(){
         var id_selector = $(this).attr("id");
         var id = id_selector.substr(id_selector.length -1);
         id = parseInt(id);
         $('#bannerCarousel').carousel(id);
         $('[id^=carousel-selector-]').removeClass('selected');
         $(this).addClass('selected');
    });
    
    // when the carousel slides, auto update
    $('#myCarousel').on('slid', function (e) {
         var id = $('.item.active').data('slide-number');
         id = parseInt(id);
         $('[id^=carousel-selector-]').removeClass('selected');
         $('[id=carousel-selector-'+id+']').addClass('selected');
    }); 
</script>
<script>
    $(document).ready(function(){
    	$('#message').hide();
    	$('#addtocart').on('submit', function (e) {	
    	 e.preventDefault();
    	  $.ajax({
    		type: 'POST',
    		url: '/customer/basket/ajaxaddtocart',
    		data: $('#addtocart').serialize(),
    		dataType:"json",
    		success: function (response) {			
    				if(response.success){
    					console.log(response.data.cart_count);
    					$('#cart_count').html(response.data.cart_count);
    					$('#message').html('<div class="addtocart message">'+response.msg+'</div>');
    					//$('#message').html(response.msg);
    					setTimeout(function(){
    						document.getElementById("message").innerHTML = '';
    					}, 3000);	
    					 location.reload();	
    					//$('#subform').hide();
    					$("#addtocart").trigger("reset");
    					$('#message').show(); 
    				}
    			}
    		});
    	});
      });
    
    var variation_id = {}; var variation_name= {}; 
    $(".term_item").click(function () {
    	
        var varid=$(this).attr('data-id'); 
        var varname=$(this).attr('data-name'); 
        var attrlvl=$(this).attr('data-attrlvl'); 
    
        $(".term_item_"+attrlvl).removeClass("active");
        $(this).addClass("active");
    
        var variation_id_arr=[]; var variation_name_arr=[];
        variation_id[attrlvl] = varid;
        variation_id_arr.push(variation_id);
    	document.getElementById("var_id_jason").value = JSON.stringify(variation_id_arr);
        variation_name['title'] = "<?=$detail->post_title?>";
        variation_name[attrlvl] = varname;
        variation_name_arr.push(variation_name);    
        document.getElementById("var_name_json").value = JSON.stringify(variation_name_arr);
    })
    
    $(document).on('ready', function() {
    // THIS FUNCTION USE FOR THE ADD WISHLIST PRODUCT
        $("#WishlistProduct").on('click', function(e) {
            var product_id = $(this).data('data');
            var customer_id = "<?= $customer_id; ?>";
            var postData = {"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
            postData.product_id = product_id;
            postData.customer_id = customer_id;
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '/welcome/ajax-add-to-wishlist',
                data: postData,
                dataType:"json",
                success: function (response) {          
                    if(response.success == 0){
                        $('#msg').append(response.msg);
                    }else{
                        $('#msg').append(response.msg);
                    }
                }
            });
        });
    });
    
    //This code for the Write a review
    $('#Reviewmessage').hide();
    $("#divWriteReview").hide();
    $("#CloseWriteReview").hide();
    $("#WriteReview").click(function(){
        $("#divWriteReview").show();
        $("#CloseWriteReview").show();
        $("#WriteReview").hide();
    });
    
    $("#CloseWriteReview").click(function(){
        $("#WriteReview").show();
        $("#divWriteReview").hide();
        $("#CloseWriteReview").hide();
    });
    
    $('#FromReview').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
          type: 'POST',
          url: '/welcome/ajax-add-to-review-rating',
          data: $('#FromReview').serialize(),
          dataType:"json",
          success: function (response) {          
                  if(response.success){
                      $('#Reviewmessage').html('<div class="addtocart message">'+response.msg+'</div>');
                      setTimeout(function(){
                          document.getElementById("message").innerHTML = '';
                      }, 3000);
                      $("#FromReview").trigger("reset");
                      $("#FromReview").hide();                   
                      $('#Reviewmessage').show();
                       get_rating();
                  }else{
                      $('#Reviewmsg').html('<div class="addtocart message">'+response.msg+'</div>');
                  }
            }
        });
    });
    
    jQuery(document).ready(function($){
        $(".btnrating").on('click',(function(e) {
            var previous_value = $("#rating").val();
            var selected_value = $(this).attr("data-attr");
            $("#rating").val(selected_value);
            
            $(".selected-rating").empty();
            $(".selected-rating").html(selected_value);
            
            for (i = 1; i <= selected_value; ++i) {
                $("#rating-star-"+i).toggleClass('btn-default');
            }
            
            for (ix = 1; ix <= previous_value; ++ix) {
                $("#rating-star-"+ix).toggleClass('btn-default');
            }
        }));
    });
</script>
