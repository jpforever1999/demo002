
    <section>
    	<img src="/assets/frontend/images/p_banner.jpg" class="img-fluid w-100" alt="">
    </section>
		
		  <section>
		  
		  <div class="container">
		
<nav aria-label="breadcrumb">
  <ol class="breadcrumb text-uppercase">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">My Account</li>
  </ol>
</nav>
			 
	<div class="row">
		
	<?php include('profile_left_menu.php');?>

	<div class="col-md-9">
		<div class=" card border ac-detail">
				<div class="row">
					<div class="col-md-6">
						<h3>My Address</h3>
					</div>
					<div class="col-md-6 shipping">
						<a href="/<?= $TYPE?>/profile/shipping-address">Add shipping address</a>
					</div>
					<div class="col-md-12">
						<?php if($this->session->flashdata('message')){?>
						<div class="alert alert-success">
						    <?= $this->session->flashdata('message')?>
						</div>
						<?php } ?>
					</div>
				</div>
				<hr>
				<div class="row" id="ShippingAddress"></div>
		</div>
	</div>
</div>
</section>	  
	
<script type="text/javascript">

$(document).ready(function() {

//THIS FUNCTION USE FOR SHIPPING ADDRESS LIST

    var postData = {"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
    var request = $.ajax({
      url: "/<?= $TYPE; ?>/profile/ajax-shipping-address",
      type: "POST",
      data: postData,
      dataType: "json"
    }); 

    request.done(function(response) {
        var ShippingAddress_html = '';
        if(response.status == '1'){
            var data = response.data;
            $.each(data, function(key, row) {
                ShippingAddress_html+='<div class="col-md-6">'+
					'<div class="ac-box border">'+
						'<h2>Shipping Address </h2>'+
						'<hr>'+
						'<p>'+row.shipping_first_name+' '+row.shipping_last_name+'<br>'+
							''+row.shipping_mobile+'<br>'+
							''+row.shipping_address_1+'<br>'+
							''+row.shipping_city+'<br>'+
							''+row.shipping_postcode+'<br>'+
							''+row.shipping_country+''+
						'</p>'+
						'<a href="/<?= $TYPE; ?>/profile/shipping-address/'+row.cmeta_id+'">Edit Address</a>'+
					'</div>'+
				'</div>';
            });

        ShippingAddress_html = ShippingAddress_html ? ShippingAddress_html : '<div class="container small-p mb-5">There is no information to display.</div>';

        $('#ShippingAddress').html(ShippingAddress_html);

        }
    });

        request.fail(function(jqXHR, textStatus) {
           // $('.page-loading').hide();
          //console.log( "Request failed: " + textStatus );
        });


      

 });


$(window).load(function() {
	 setTimeout(function() { 
            $('.alert-success').fadeOut('fast'); 
        }, 3000); 
});

</script>	
