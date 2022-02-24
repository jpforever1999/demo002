<footer class="hp_footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 search">			
                <h5>subscribe our newsletter !</h5>
				<div id="subThank"></div>
				<div id="subform">
					<?php if (validation_errors()!='') { ?>
                        <div class="alert alert-danger"> <?php echo validation_errors();?> </div>
                    <?php } ?>
					
					 <form class="contact-form-box" id="sub_form" method="post">
						<input type="email" name="email" value="" required placeholder="Enter your Email id" data-parsley-pattern="^[a-zA-Z0-9\'\.\-_\+]+@[a-zA-Z0-9\-]+\.([a-zA-Z0-9\-]+\.)*?[a-zA-Z]+$" data-parsley-error-message="Please enter valid email." maxlength="100" />
						<input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />
						<button type="submit" name="submit" value="submit">subscribe</button>
					</form>
				</div> 
				
				</div>
        </div>
		
		
        <div class="row">
                <div class="col-md-3">
                    <div class="hp_footer_menu">
                        <h5>Customer Services</h5>
                        <a href="<?= base_url(); ?>page/help-center">Help Center</a>
                        <a href="<?= base_url(); ?>page/contact-us">Contact Us</a>
                        <a href="<?= base_url(); ?>page/report-abuse">Report Abuse</a>
                        <a href="<?= base_url(); ?>page/submit-a-dispute">Submit a Dispute</a>
                        <a href="<?= base_url(); ?>page/policies-rules">Policies & Rules</a>
                        <a href="<?= base_url(); ?>page/get-paid-for-your-feedback">Get Paid for Your Feedback</a>
                    </div>  
                </div>
                <div class="col-md-3">
                    <div class="hp_footer_menu">
                        <h5>Buy on EL K'lentano shop</h5>
                        <a href="<?= base_url(); ?>page/all-categories">All Categories</a>
                        <a href="<?= base_url(); ?>page/request-for-quotation">Request for Quotation</a>
                        <a href="<?= base_url(); ?>page/ready-to-ship">Ready to Ship</a>
                    </div>  
                </div>
                <div class="col-md-3">
                    <div class="hp_footer_menu">
                        <h5>About Us</h5>
                        <a href="<?= base_url(); ?>page/about">About</a>
                        <a href="<?= base_url(); ?>page/sitemap">Sitemap</a>
                    </div>  
                </div>
                
                <div class="col-md-3">
                    <div class="hp_footer_menu">
                        <h5>About Us</h5>
                        <a href="<?= base_url(); ?>page/trade-assurance">Trade Assurance</a>
                        <a href="<?= base_url(); ?>page/business-identity">Business Identity</a>
                        <a href="<?= base_url(); ?>page/logistics-service">Logistics Service</a>
                        <a href="<?= base_url(); ?>page/inspection-services">Inspection Services</a>
                        <a href="<?= base_url(); ?>page/pay-later">Pay Later</a>
                    </div>      
                </div>                                                                                                                                                                                                                                                                                                                          
                
            </div>
            <div class="doen">
            <h5>Download  App: </h5>
                <a href="about.html">
                    <img src="/assets/frontend/images/apple.png" alt="">
                </a>
                <a href="about.html">
                    <img src="/assets/frontend/images/anod.png" alt="">
                </a>
            </div>
            
            <div class="doen doen2 ">
            <h5>Follow Us : </h5>
                <a href="#"><img src="/assets/frontend/images/fb.png" alt=""></a>
                <a href="#"><img src="/assets/frontend/images/tw.png" alt=""></a>
                <a href="#"><img src="/assets/frontend/images/in.png" alt=""></a>
                </div>  
            <br>
            <br>
            <div class="text-center text-white pb-0 ft-content">
            
            <p>Makeup  |  Dresses For Girls  |  T-Shirts  |  Sandals  |  Headphones  |  Babydolls   |  Blazers For Men  |  Handbags  |  Ladies Watches  |  Bags  |  Sport Shoes  |  Reebok Shoes  |  Puma Shoes  |  Boxers  |  Wallets  |  Tops  |  Earrings  |  Fastrack Watches  |  Kurtis  |  Nike  |  Smart Watches  |  Titan Watches  |  Designer Blouse  |  Gowns  |  Rings  |  Cricket Shoes  |  Forever 21  |  Eye Makeup  |  Photo Frames  |  Punjabi Suits  |  Bikini  |  Myntra Fashion Show  |  Lipstick  |  Saree  |  Watches  |  Dresses  |  Lehenga  |  Nike Shoes  |  Goggles  |  Bras  |  Suit  |  Chinos  |  Shoes  |  Adidas Shoes  |  Woodland Shoes  |  Jewellery  |  Designers Sarees</p><br>
                <p>© 2020 www.EL K'lentanoshop.com. All rights reserved.</p>
            </div>
        </div>
      </footer>

      
<style>
.thankyou{ text-align: center;border: 1px solid #ccc; margin: 20px; color:#fff; padding: 10px; border-radius: 10px; }
.thankyou h3{ color:#d6fb0d; font-size: 35px;} 
.thankyou p{line-height:25px; color: #fff}
</style>

<script>
$(document).ready(function(){
	$('#subThank').hide();
	$('#sub_form').on('submit', function (e) {
	 e.preventDefault();
	  $.ajax({
		type: 'POST',
		url: '/welcome/ajaxsubscribeform',
		data: $('#sub_form').serialize(),
		dataType:"json",
		success: function (data) {
				if(data.success){
					$('#subThank').html('<div class="thankyou"> <h3>Thank You</h3> <p>We appreciate you for subscribe with us. One of our colleagues will get back to you shortly.</p> <p>Have a great day!</p></div>');
					$('#subform').hide();
					$("#sub_form").trigger("reset");
					$('#subThank').show(); 
				}
			}
		});
	});




   

//THIS FUNCTION USE FOR MORE CATEGORY LIST

function more_cat() {
var postData = {"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
var request = $.ajax({
  url: "/welcome/ajax-get-more-category-list",
  type: "POST",
  data: postData,
  dataType: "json"
}); 

    request.done(function(response) {
        var MoireCategories_html = '';
        if(response.status == '1'){
            var data = response.data;

            $.each(data, function(key, row) {
                MoireCategories_html+='<div class="col">'+
                                    '<a href="<?= base_url();?>taxonomy/'+row.slug+'">'+
                                      '<li>'+row.name+'</li>'+
                                    '</a>'+
                                  '</div>';
                    });


        MoireCategories_html = MoireCategories_html ? MoireCategories_html : '<div class="container small-p mb-5">There is no information to display.</div>';
        $('.MoireCategories').html(MoireCategories_html);

        }
});
}

//THIS FUNCTION USE FOR CATEGORY LIST
    var postData = {"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
    var request = $.ajax({
      url: "/welcome/ajax-get-category-list",
      type: "POST",
      data: postData,
      dataType: "json"
    }); 

    request.done(function(response) {
        var Categories1_html = '';
        if(response.status == '1'){
            var data = response.data;

            $.each(data, function(key, row) {
                Categories1_html+='<li>'+
                    '<li>'+
                        '<a href="<?= base_url();?>taxonomy/'+row.slug+'">'+
                            '<h4><img src="'+row.icon+'" width="22px">'+row.name+
                            '<span class="plusminus">+</span>'+
                        '</h4>'+
                        '</a>'+
                    '</li>'+
                    /*'<div class="megadrop">'+
                     '<div class="col">'+
                        '<h3><a href="product-list.html">Title</a></h3>'+
                      '<ul>'+
                        '<li><a href="product-list.html">Sub-menu 1</a>'+
                        '</li>'+
                        '<li><a href="product-list.html">Sub-menu 1</a>'+
                        '</li>'+
                        '<li>'+'<a href="product-list.html">Sub-menu 1</a>'+
                        '</li>'+
                     '</ul>'+
                    '</div>'+
                    '<div class="col">'+
                        '<h3><a href="product-list.html">Title</a></h3>'+
                      '<ul>'+
                        '<li><a href="product-list.html">Sub-menu 1</a>'+
                        '</li>'+
                        '<li><a href="product-list.html">Sub-menu 1</a>'+
                        '</li>'+
                        '<li>'+'<a href="product-list.html">Sub-menu 1</a>'+
                        '</li>'+
                     '</ul>'+
                    '</div>'+
                    '<div class="col">'+
                        '<h3>'+'<a href="product-list.html">'+'Title'+'</a></h3>'+
                        '<ul>'+
                            '<li><a href="product-list.html">Sub-menu 1</a>'+
                            '</li>'+
                            '<li><a href="product-list.html">Sub-menu 1</a>'+
                            '</li>'+
                            '<li><a href="product-list.html">Sub-menu 1</a>'+
                        '</li>'+
                      '</ul>'+
                    '</div>'+
                  '</div>'+
                '</li>'+*/
               '<li>';
            });


        Categories1_html = Categories1_html ? Categories1_html : '<div class="container small-p mb-5">There is no information to display.</div>';

        $('.CategoryList').html(Categories1_html);

        }
    });


//THIS FUNCTION USE FOR CATEGORY LIST
    var postData = {"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
    var request = $.ajax({
      url: "/welcome/ajax-get-all-category-list",
      type: "POST",
      data: postData,
      dataType: "json"
    }); 

    request.done(function(response) {
        var Categories_html = '';
        if(response.status == '1'){
            var data = response.data;

            $.each(data, function(key, row) {
                Categories_html+='<li>'+
                    '<a href="/taxonomy/'+row.slug+'">'+
                        '<img src="'+row.icon+'" title="'+row.name+'" width="20">'+'<span>'+row.name+'</span>'+'<i class="fa fa-chevron-right" aria-hidden="true">'+'</i>'+
                    '</a>'+
                    /*'<div class="megadrop">'+
                     '<div class="col">'+
                        '<h3><a href="product-list.html">Title</a></h3>'+
                      '<ul>'+
                        '<li><a href="product-list.html">Sub-menu 1</a>'+
                        '</li>'+
                        '<li><a href="product-list.html">Sub-menu 1</a>'+
                        '</li>'+
                        '<li>'+'<a href="product-list.html">Sub-menu 1</a>'+
                        '</li>'+
                     '</ul>'+
                    '</div>'+
                    '<div class="col">'+
                        '<h3><a href="product-list.html">Title</a></h3>'+
                      '<ul>'+
                        '<li><a href="product-list.html">Sub-menu 1</a>'+
                        '</li>'+
                        '<li><a href="product-list.html">Sub-menu 1</a>'+
                        '</li>'+
                        '<li>'+'<a href="product-list.html">Sub-menu 1</a>'+
                        '</li>'+
                     '</ul>'+
                    '</div>'+
                    '<div class="col">'+
                        '<h3>'+'<a href="product-list.html">'+'Title'+'</a></h3>'+
                        '<ul>'+
                            '<li><a href="product-list.html">Sub-menu 1</a>'+
                            '</li>'+
                            '<li><a href="product-list.html">Sub-menu 1</a>'+
                            '</li>'+
                            '<li><a href="product-list.html">Sub-menu 1</a>'+
                        '</li>'+
                      '</ul>'+
                    '</div>'+
                  '</div>'+
                '</li>'+*/
               '<li>';
            });

        Categories_html +='<li>'+
            '<a href="#"><img src="/assets/frontend/images/more.png" width="22px"><span>'+'More Products'+'</span><i class="fa fa-chevron-right" aria-hidden="true"></i>'+'</a>'+
              '<div class="megadrop MoireCategories">'+
              '</div>'+
            '</li>';


        Categories_html = Categories_html ? Categories_html : '<div class="container small-p mb-5">There is no information to display.</div>';

        $('#GetCategory').html(Categories_html);
        more_cat();

        }
    });

    request.fail(function(jqXHR, textStatus) {
       // $('.page-loading').hide();
      //console.log( "Request failed: " + textStatus );
    });
 
});

$(document).ready(function() {
    $('#currencies_combo').on('change', function() {
        set_default('cur',this);
    }); 
    $('#language_combo').on('change', function() {
        set_default('ln',this);
    }); 
});

function set_default(type,obj)
{
    var postData = {};//{"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
    postData.type = type;
    postData.id   = $(obj).val();
    postData.api  = 1;
    $.ajax({
        url: "/welcome/ajax_set_default",
        type: 'post',
        data: postData,
        dataType: "json",
        beforeSend: function() {
        },
        success: function(response){
            location.reload(); 
            if(response.status == 'success') {
            }else{
            }
        }
    });
}

$(document).on("input", ".numeric", function() {
    var self = $(this);
    self.val(self.val().replace(/[^\d]+/, ""));
});

$(document).on("input", ".disable_space", function(e) {
    var self = $(this);
    self.val(self.val().replace(/\s/g, ""));
});

$(document).on("input", ".unsigned_float", function(evt) {
    var self = $(this);
    self.val(self.val().replace(/[^0-9\.]/g, ''));
});

$(document).on("click", ".add_to_cart", function(e) {
    e.preventDefault();
    <?php $csrf = csrf_token(); ?>
    var variation_id = $(this).attr('data-variation-id');
    var quantity = $(this).attr('data-quantity');
    var product_id = $(this).attr('data-product-id');
    var postData = {"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
    postData.variation_id = variation_id;
    postData.product_qty = quantity;
    postData.product_id = product_id;
    $.ajax({
        url: '/customer/basket/ajaxaddtocart',
        type: 'post',
        data: postData,
        dataType: "json",
        success: function(response){
            if(response.success){
                $('#cart_count').html(response.data.cart_count);
                swal('Added!');
            }else{
            }
        }
    });
});


</script>
