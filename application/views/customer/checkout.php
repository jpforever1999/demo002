<?php

$TYPE = $_SESSION['type'];
$logged_in = FALSE;
if($this->session->userdata($TYPE)){
    $session_obj = $this->session->userdata($TYPE);
	//echo "<pre>"; print_r($session_obj); echo "</pre>";
	$logged_in = $session_obj['logged_in'];
	$current_id = $session_obj['login_id'];
	$emailarray  = explode('@',$session_obj['email']);
	$emailSuffix = $emailarray[0];	
	
	$name  = $session_obj['fname'];
    $image = isset($session_obj['image']) ? $session_obj['image'] : '';
}
//echo '=='.$logged_in;

$class='';
if($logged_in==1){ 
	$class="btn btn-link collapsed";
	$active = 'Hi '. $emailSuffix;
	$current_id = $current_id;
}else{
	$class="btn btn-link ";
	$current_id = $_SESSION['__ci_last_regenerate'];
}

$default_currency = default_currency();
$currency =get_currency($default_currency);
$rate = $currency->rate;
$symbol = $currency->symbol;


$session_itemid = $this->session->userdata('proceed_checkout');
$item_id = explode(",",$session_itemid);
$cart_details = get_cart();
$proceed_amt = 0; $proceed_amount = 0; $cart_item = 0;
if(isset($cart_details)){
	foreach($cart_details as $row => $val){
		//$val['order_item_id'];
		if (in_array($val['order_item_id'], $item_id )){
			$proceed_amt+=$val['product_net_revenue'] * $val['product_qty'];
			$proceed_amount =$rate*$proceed_amt;
			$cart_item += $val['product_qty'];
		}
	}
}

$status_key='';
$shippingid ='';
foreach($current_user_info as $k =>$v){	
	if(isset($v->status) &&  $v->status=='1'){
		$status_key= 1;
		$shipping_id= $v->cmeta_id;
	}	
}

?>

<section><div class="container">
<?= $breadcrumbs; ?>	
<?PHP if($proceed_amount) {
	
 ?>
<div class="row mb-4"><div class="col-md-8">        
<div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="<?= $class?>" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <i class="fa fa-check-circle" aria-hidden="true"></i> <?php if($logged_in==1) echo "loged in"; else echo "1. ADDRESS DETAILS"; ?>
        </button>
      </h5>
    </div>
	<?php //if($logged_in==1) echo "collapsed collapse"; else echo "collapsed collapse show";  ?>
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
	
		<div id="thanks"></div> <div id="otpthanks"></div>
		<div class="card-body">
		<?php if (validation_errors()!='') { ?>
			<div class="alert alert-danger"> <?php echo validation_errors();?> </div>
		<?php } 		
		if($logged_in==1){ ?>	
		
		<p><?php echo $active;  ?>	</p>		
		<?php }else{ ?>	
		 <div id="success_msg"></div>
		<div id="hideForm">
			<form class="ckeckout" id="checkoutForm" method="post">			  
			<div class="form-group col-md-6">
			  <label for="inputEmail4">Email</label>
			  <input type="email" name="email_id" class="form-control" id="email_id" required>
			   <div id="mail_exist"></div>
			</div>
            <div class="form-group col-md-6 otp_div" style="display:none;">
              <label for="inputEmail4">OTP verify Please</label>
                <input type="text" name="otp" value="" class="form-control" id="opt_input">
               <div id="mail_exist"></div>
            </div>	
			
			<div class="btn-cart-totals">
				<input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />						
			  <button type="submit" class="btn-checkout" name="submit" value="submit">Save and Continue </button>
			</div>			
			</form> 		
	   </div>
		<?php } ?>
      </div>
    </div>	
</div>
<!------Step second------>

 <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" <?php if($logged_in==1) echo 'data-toggle="collapse"'; ?> data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">  2. DELIVERY ADDRESS </button>
      </h5>
    </div>
	<?php //echo '=='.$current_id; ?>
    <div id="collapseTwo" class="collapse checkout-page"  aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
	  	<div class="shippingAddress" id="addr"></div>		
		<div class="add_new" id="add_address"><a id="addnew_address" href="javascript:void(0);" onclick="toggle_visibility('form-hide');" title="add add" >Add New Address</a></div>
		<div class="billing_address_success"></div>	
		<div id="form-hide" class="billing_form" style="display:none">	
		<form class="address_billing" id="address_billing_form" method="post">		  
			<div class="form-row">
				<div class="form-group col-md-6">
				  <label for="First Name">First Name</label>
				  <input name="fname" type="text" value="<?php echo isset($current_user_info->shipping_first_name) ? $current_user_info->shipping_first_name:'';  ?>" class="form-control" id="fname" placeholder="" required>
				  <div class="fname_billing_error"></div>
				</div>
				<div class="form-group col-md-6">
				  <label for="Last Name">Last Name</label>
				  <input name="lname" type="text" value="<?php echo isset($current_user_info->shipping_last_name) ? $current_user_info->shipping_last_name:'';  ?>"  class="form-control" id="lname" placeholder="">
				<div class="last_billing_error"></div>
				</div>
			</div>
		  <div class="form-group">
				<label for="Address">Street</label>
				<textarea name="street" class="form-control add" id="street" placeholder="Street Name / Building / Apartment No. / Floor" required><?php echo isset($current_user_info->shipping_street) ? $current_user_info->shipping_street:'';  ?></textarea>
				
		  </div>
		  <div class="form-row">
			<?php /* ?><div class="form-group col-md-6">
				<label for="inputState">State</label>
				<input type="text" name="state" id="state" value="<?php echo isset($current_user_info->shipping_state) ? $current_user_info->shipping_state:'';  ?>"  class="form-control" placeholder="" required>
			</div><?php */ ?>
			<div class="form-group col-md-6">
                <label for="CountryName">Country</label>
                <select name="shipping_country" id="CountryName" class="form-control" required />
                  <option value="">Select Country Name</option>
                  <?php foreach($country_list as $countrydata){
                      if($shippingaddress->shipping_country == $countrydata->country_id) {?>
                      
                      <option value="<?= $countrydata->country_id; ?>" selected ><?= $countrydata->name; ?></option>

                  <?php }else{ ?>

                    <option value="<?= $countrydata->country_id; ?>" ><?= $countrydata->name; ?></option>

                  <?php } } ?>

                </select>
            </div>
			
			<div class="form-group col-md-6">
				<label for="City">City</label>
				<input type="text" name="city" id="city" value="<?php echo isset($current_user_info->shipping_city) ? $current_user_info->shipping_city:'';  ?>"  class="form-control"  placeholder="" required>
				 
			</div>
			<div class="form-group col-md-6">
				<label for="Zip">Zip</label>
				<input type="text" name="zip_code" value="<?php echo isset($current_user_info->shipping_postcode) ? $current_user_info->shipping_postcode:'';  ?>" class="form-control" id="zip_code" required>
				
			</div>
			<div class="form-group col-md-6">
				<label for="mobile">Mobile</label>
				<input type="text" name="mobile" value="<?php echo isset($current_user_info->shipping_mobile) ? $current_user_info->shipping_mobile:'';  ?>" class="form-control" id="mobile" required>
				
			</div>
		  </div>
		  <div class="form-group">
				<label for="Address Detail">Address Detail</label>
				<textarea name="address" class="form-control add" id="address" placeholder="Landmark / Directions / More Details" ><?php echo isset($current_user_info->shipping_address_1) ? $current_user_info->shipping_address_1:'';  ?></textarea>
				 
		  </div>
		  
			<div class="btn-cart-totals">
				<input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />
				<input type="hidden" name="item_id" id="item_id" value="0" />
			  <button type="submit" class="btn-checkout billing_address" name="submit" value="submit">Save and Continue </button>
			</div>
			
		
	</form>
	 </div> </div> </div>
  </div>
	<!  ----------Third step-----  -->
	<div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" <?php if($logged_in==1) echo 'data-toggle="collapse"'; ?> data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> 3. PAYMENT METHOD </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
	<div class="card-body">
	
	<form id="order_confirm" method="post">
		<div class="custom-control custom-radio custom-control-inline d-block">
		<p class="stng mb-3">How do you want to pay for your order?</p>
		<input type="radio" name="payment" class="custom-control-input" id="customRadio1" >
		<label class="custom-control-label" for="customRadio1"><strong class="stng">Stay Safe, go cashless with JumiaPay.	</strong><br><br>Card payments are supported by all banks.<br>Paypal payment is accepted while buying from Nigeria only </label>
		<img src="<?php echo base_url(); ?>assets/frontend/images/logo-strip-paypal.png" class="img-fluid mt-2" alt="">
		</div>
		<hr>
		<div class="custom-control custom-radio custom-control-inline d-block">
		<input type="radio" name="payment"  class="custom-control-input" id="customRadio2" checked>
		<label class="custom-control-label" for="customRadio2"><i class="fa fa-money"></i> <strong class="stng">Cash On Delivery</strong><br>Unavailable <a class="" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Why?</a>
		<br><br>
		</label>
		<div class="collapse" id="collapseExample">
		<div class="note">
		Pay on Delivery unavailable? It may be due to one of the following reasons:<br>	
		<ol>
			<li>1) Selected items shipped from overseas are not eligible for Pay on Delivery</li>
			<li>2) Your total cart value is under ₦ 2,000</li>
			<li>3) Your total cart value is above ₦ 150,000</li>
			<li>4) Your order contains large items</li>
			<li>5) Your delivery option (some far regions, some specific pick-up stations) is not eligible for Pay on Delivery</li>
		</ol>
		For further enquiry, please contact us <a href="#">here</a>	</div></div>		  
		</div>
		<input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />
		<input type="hidden" id="cart_item" name="cart_item" value="<?php if($cart_item) echo $cart_item; ?>" /> 
		<input type="hidden" name="product_net_revenue_usd" value="<?php echo $current_id; ?>" />
		<?php /* ?><input type="hidden" name="total_sales" value="<?php if($proceed_amount) echo $proceed_amount; ?>" /><?php */ ?>
		<input type="hidden" name="rate" value="<?php echo $rate; ?>" />
		<input type="hidden" name="currency_id" value="<?php echo $currency->currency_id; ?>" />
		<input type="hidden" name="cmeta_id" id ="cmeta_id" value="<?php if( isset($shipping_id) ) echo $shipping_id; ?>" />				
		<button type="submit" name="submit" value="submit" class="update btn-checkout">Confirm Order</button>
	 
  </form>
</div></div></div>
</div> </div>
         
<div class="col-md-4">			
<div class="cart-totals p-3 border">
<h3>Cart Totals</h3>
<hr>
<form action="#" method="get" accept-charset="utf-8">
<table>
<tbody>
	<tr>
		<td>Subtotal</td>
		<td class="subtotal"><?php if($proceed_amount) echo $symbol.$proceed_amount; ?></td>
	</tr>
	<tr>
		<td class="pb-4">Shipping</td>
		<td class="free-shipping pb-4">Free Shipping</td>
	</tr>
	<tr class="total-row">
		<td>Total</td>
		<td class="price-total"><?php if($proceed_amount) echo $symbol.$proceed_amount; ?></td>
	</tr>
</tbody>
</table>

<!-- /.btn-cart-totals -->
</form>
<!-- /form -->
</div>

</div>


</div>

<?php 
}else{
echo '<div class="alert alert-warning">Your cart is empty!</div>';
}
?>

</div>
</section>	 

<script>
$(document).ready(function(){ 
$('#thanks').hide();
$('#checkoutForm').on('submit', function (e) {
e.preventDefault();
$.ajax({
		type: 'POST',
		url: '/customer/checkout/ajaxCheckout',
		data: $('#checkoutForm').serialize(),
		dataType:"json",
		success: function (data) {
				if(data.success){
                    $('.otp_div').show();
                    $('#mail_exist').addClass('alert alert-success');
                    $('#mail_exist').html(data.msg);
					
					
					if(data.userdata.fname){				
						
						//$('#success_msg').html('<div id="success_msg" class="alert alert-success">' +data.msg + '</div>');
						/*
						setTimeout(function(){
							document.getElementById("success_msg").innerHTML = '';
						}, 3000);					
						*/
						//$('#headingOne').html('Hi, ' + data.userdata.fname);							
						//$('#hideForm').html('Hi, ' + data.userdata.fname);	 
					}
					//location.reload();
					window.location=window.location;
				}
                else
                {
                    $('#mail_exist').addClass('alert alert-danger');
                    $('#mail_exist').html(data.msg);
                    
                }
				
			}
			
		});
	});
});
 


$(document).ready(function(){ 
$('#thanks').hide();
$('#address_billing_form').on('submit', function (e) {
	
e.preventDefault();
$.ajax({
		type: 'POST',
		url: '/customer/checkout/ajax_bill_address_update',
		data: $('#address_billing_form').serialize(),
		dataType:"json",
		success: function (data) {
				if(data.success){
					
                    $('.billing_address_success').addClass('alert alert-success');
                    $('.billing_address_success').html(data.msg);
                    shipping_address();
					
				}
                else
                {
					$('.billing_address_success').addClass('alert alert-danger');
					$('.billing_address_success').html(data.msg);
					
                    
                }
			}
		});
	});
});
 
// shipping list

$(document).ready(function() {
shipping_address();
});

function shipping_address() {
	//THIS FUNCTION USE FOR SHIPPING ADDRESS LIST
    var postData = {"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
    var request = $.ajax({
      url: "/<?= $TYPE; ?>/profile/ajax_shipping_address",
      type: "POST",
      data: postData,
      dataType: "json"
    }); 
 
    request.done(function(response) {
        var ShippingAddress_html = '';
        if(response.status == '1'){			
            var data = response.data;
            $.each(data, function(key, row) {
                var checked = '';
                if(row.status == 1){
                    checked = 'checked';
                }
                ShippingAddress_html+='<div class="col-md-12 id-'+row.cust_id+'"><div class="row">'+
					'<div class="ship_address col-md-9 p-2">'+
						'<input type="radio" data-id="'+row.cmeta_id+'" class="customermeta" name="addreess" value="'+row.cust_id+'" '+checked+'> '+						
						'<label class="shipping_fname">'+row.shipping_first_name+' '+row.shipping_last_name+' '+
						' mob '+row.shipping_mobile+' '+
						'</label>'+
						'<div class="billing_address  p-2"> '+							
							''+row.shipping_address_1+' '+
							''+row.shipping_city+' '+
							''+row.shipping_postcode+' '+
							''+row.shipping_country+''+
							', mob '+row.shipping_mobile+' '+
						'</div>'+						
					'</div>'+
					'<div class="col-md-3 p-2 text-right"><a href="javascript:void(0);" class="billing visibility_div visibility_div_'+row.cmeta_id+'" data-id = "'+row.cmeta_id+'" data-mobile="'+row.shipping_mobile+'" data-shipping_country="'+row.shipping_country+'" data-shipping_postcode="'+row.shipping_postcode+'" data-shipping_first_name="'+row.shipping_first_name+'" data-shipping_last_name="'+row.shipping_last_name+'" data-shippingCity="'+row.shipping_city+'" data-shippingstreet="'+row.shipping_street+'" data-shippingstate="'+row.shipping_state+'" data-shipping_address_1="'+row.shipping_address_1+'">Edit</a></div>'+
				'</div></div>';
            });

        ShippingAddress_html = ShippingAddress_html ? ShippingAddress_html : '<div class="container small-p mb-5">There is no information to display.</div>';			
        $('#addr').html(ShippingAddress_html);

        }
    });

        request.fail(function(jqXHR, textStatus) {
           // $('.page-loading').hide();
          //console.log( "Request failed: " + textStatus );
        });

}

//show hide form
$(document).on("click",".visibility_div",function() {
	$('#add_address').hide();
	var e = document.getElementById('form-hide');
    var id = $(this).data("id"); 
	var mobile = $(this).data("mobile"); 
	var fname = $(this).data("shipping_first_name");
	var lname = $(this).data("shipping_last_name"); 	
	var shippingstreet = $(this).data("shippingstreet"); 
	var address = $(this).data("shipping_address_1"); 
	var shippingstate = $(this).data("shippingstate"); 
	var shippingcity = $(this).data("shippingcity"); 
	var zip_code = $(this).data("shipping_postcode"); 
	//alert(shippingstreet);
	var mobile = $('#mobile').val(mobile);	
    var fname = $('#fname').val(fname);
	var lname = $('#lname').val(lname);
	var street = $('#street').val(shippingstreet);
	var address = $('#address').val(address);
	var state = $('#state').val(shippingstate);
	var city = $('#city').val(shippingcity);
	var zip_code = $('#zip_code').val(zip_code);
	
   if(e.style.display == 'block')
    {
		
	    e.style.display = 'none';
		//$('.visibility_div_'+id).html('Edit');
		$('#item_id').val(0);
        $('#add_address').show();   
    }
   else
    {
	    e.style.display = 'block';
        //$('.visibility_div_'+id).html('Close');
		$('#item_id').val(id);
        //$('#add_address').hide();
    }
});

function toggle_visibility(id) {
	//$('#add_address').hide();
	$('#item_id').val(0);
    var e = document.getElementById('form-hide');
    $('#address_billing_form')[0].reset();
    $('.visibility_div').html('Edit');
    if(e.style.display == 'block')
    {
		e.style.display = 'none';
        //$('.visibility_div').show();
		$('#addnew_address').html('Add New Address');
    }
    else
    {
	  e.style.display = 'block';
       // $('.visibility_div').hide();
		$('#addnew_address').html('Add New Address');
    }
}


//order now

$(document).ready(function(){ 
$('#confirmorder').hide();
$('#order_confirm').on('submit', function (e) {
	
e.preventDefault();
$.ajax({
		type: 'POST',
		url: '/customer/checkout/ajax_order_confirm',
		data: $('#order_confirm').serialize(),
		dataType:"json",
		success: function (data) {
				if(data.success){					
					$('.confirm_order_success').addClass('alert alert-success');
					$('.confirm_order_success').html(data.msg);	
					window.location.href = "<?php echo base_url() ?>thanks";
						
				}
                else
                {
					$('.confirm_order_success').addClass('alert alert-danger');
					$('.confirm_order_success').html(data.msg);	
						
                }
			}
		});
	});
});


$(document).on("click", ".customermeta", function(e) {
    var data_id = $(this).attr('data-id');	
    var postData = {"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
    postData.cmeta_id = data_id;
    var request = $.ajax({
        url: "/<?= $TYPE; ?>/checkout/ajax_order_delivery_address",
        type: "POST",
        data: postData,
        dataType: "json"
    }); 
 
    request.done(function(response) {
        if(response.status == '1'){			
            swal(response.message);
			$('#cmeta_id').val(data_id);
        }
    });

    request.fail(function(jqXHR, textStatus) {
        // $('.page-loading').hide();
        //console.log( "Request failed: " + textStatus );
    });
});

</script>
