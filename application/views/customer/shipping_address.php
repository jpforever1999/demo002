  <section>
	  	<img src="/assets/frontend/images/p_banner.jpg" class="img-fluid w-100" alt="">
	  </section>
	
	  <section>
		  
		  <div class="container">
		
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb text-uppercase">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">My Account</li>
      </ol>
    </nav>
			 
	<div class="row">
	
  <?php include('profile_left_menu.php');?>

	<div class="col-md-9">
		<div class=" card border ac-detail">
			<h3><?php if($cmeta_id !='') { echo "Update"; }else{ echo "Add "; } ?>  Shipping Address </h3>
			<div class="row">
				<div class="col-md-12">
          <div id="SubmitShippingFrom"></div>
          <?php if ((isset($message) && $message['error']!='') || validation_errors()!='') { ?>
            <div class="alert alert-danger">
                <?= validation_errors();
                    if($message['error']!=''){
                        echo $message['error'];
                    }
                ?>
            </div>
            <?php } ?>
					<div class="ac-box border my-form">
          <form class="form-group" method="POST" id="AddShippingFrom">
          <input type="hidden" name="cmeta_id" value="<?= isset($cmeta_id) ? $cmeta_id : ''; ?>" />
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="FirstName">First Name</label>
              <input type="text" name="shipping_first_name" class="form-control" id="FirstName" placeholder="First Name" value="<?= isset($shippingaddress->shipping_first_name) ? $shippingaddress->shipping_first_name : ''?>"  />
            </div>
            <div class="form-group col-md-4">
              <label for="LastName">Last Name</label>
              <input type="text" name="shipping_last_name" class="form-control" id="LastName" placeholder="Last Name" value="<?= isset($shippingaddress->shipping_last_name) ? $shippingaddress->shipping_last_name : ''?>"   />
            </div>
            <div class="form-group col-md-4">
              <label for="MobileNo">Mobile No</label>
              <input type="text" name="shipping_mobile" class="form-control" placeholder="Mobile No" value="<?= isset($shippingaddress->shipping_mobile) ? $shippingaddress->shipping_mobile : ''?>" onkeypress="return isNumberKey(event)" data-parsley-pattern="^((5|6|7|8|9)[0-9]{9})$" data-parsley-error-message="Please enter valid mobile number." data-parsley-errors-container="#mobile_error" maxlength="10">
            </div>
            <div class="form-group col-md-6">
              <input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />
              <label for="Street">Street</label>
              <input type="text" name="shipping_street" placeholder="Street Name" class="form-control" id="Street"  value="<?= isset($shippingaddress->shipping_street) ? $shippingaddress->shipping_street : ''?>"  />
            </div>
            <div class="form-group col-md-6">
              <label for="CityName">City</label>
              <input type="text" class="form-control" placeholder="City Name" name="shipping_city" id="CityName" value="<?= isset($shippingaddress->shipping_city) ? $shippingaddress->shipping_city : ''?>"  />
            </div>
           <div class="form-group col-md-6">
                <label for="ZipCode">Zip Code</label>
                <input type="text" name="shipping_postcode" class="form-control" placeholder="Zip Code" id="ZipCode" value="<?= isset($shippingaddress->shipping_postcode) ? $shippingaddress->shipping_postcode : ''?>" />
            </div>
            <div class="form-group col-md-6">
                <label for="CountryName">Country</label>
                <select name="shipping_country" id="CountryName" class="form-control" />
                  <option value="">Select Country Name</option>
                  <?php foreach($country_list as $countrydata){
                      if($shippingaddress->shipping_country == $countrydata->country_id) {?>
                      
                      <option value="<?= $countrydata->country_id; ?>" selected ><?= $countrydata->name; ?></option>

                  <?php }else{ ?>

                    <option value="<?= $countrydata->country_id; ?>" ><?= $countrydata->name; ?></option>

                  <?php } } ?>

                </select>
            </div>
          </div>
          <div class="form-group">
            <label for="AddressDetail">Address Detail</label>
        	  <textarea class="form-control add" name="shipping_address_1" id="AddressDetail" placeholder="Landmark / Building / Apartment No. / Floor" ><?= isset($shippingaddress->shipping_address_1) ? $shippingaddress->shipping_address_1 : ''?></textarea>
          </div>

					<div class="form-group">
						<button class="btn btn-primary w-100" type="submit" name="submit"><?php if($cmeta_id==''){ echo 'Save'; }else{ echo 'Update';}?> </button>
					</div>
					</div>
        </form>
				</div>
	
			</div>
		</div>
	</div>
	</div>
</div>
</section>	  
<script type="text/javascript">
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    {
        return false;
    }
    return true;
}

$(document).on('ready', function() {
//$('#SubmitShippingFrom').hide();
$('#AddShippingFrom').on('submit', function (e) {
    e.preventDefault();
      $.ajax({
        type: 'POST',
        url: '/customer/profile/add-shipping-address',
        data: $('#AddShippingFrom').serialize(),
        dataType:"json",
        success: function (response) {          
                if(response.status == '1'){
                    $('#SubmitShippingFrom').html(response.message);
                    $("#AddShippingFrom").trigger("reset");
                    location.href = '<?=base_url();?>customer/profile/customer-address';
                    //$('#SubmitShippingFrom').show();
                }else{
                    //$('#SubmitShippingFrom').show();
                    $('#SubmitShippingFrom').html(response.message);
                    location.href = '<?=base_url();?>customer/profile/shipping-address';
                }
            }
        });
    });
});

</script>