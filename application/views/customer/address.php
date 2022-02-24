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
			<h3>Edit Address </h3>
			<div class="row">
				<div class="col-md-12">
           <?php if ((isset($message) && $message['error']!='') || validation_errors()!='') { ?>
            <div class="alert alert-danger">
                <?= validation_errors();
                    if($message['error']!=''){
                        echo $message['error'];
                    }
                ?>
            </div>
            <?php } ?>
          <form class="form-group"  method="post" action="/<?= $TYPE; ?>/profile/add-address/<?= $customer_id; ?>">
					<div class="ac-box border my-form">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />
                  <input type="hidden" name="customer_id" value="<?= $customer_id; ?>" required />
                  <label for="inputZip">Street</label>
                  <input type="text" name="street" placeholder="Street Name" class="form-control" id="inputZip" value="<?= isset($address->street) ? $address->street : ''?>" required />
                </div>
                <div class="form-group col-md-6">
                  <label for="inputState">City</label>
                  <input type="text" class="form-control" placeholder="City Name" name="city" id="City" value="<?= isset($address->city) ? $address->city : ''?>" required />
                </div>
                <div class="form-group col-md-6">
                  <label for="inputZip">Zip Code</label>
                  <input type="text" name="zip_code" class="form-control" placeholder="Zip Code" id="ZipCode" value="<?= isset($address->zip_code) ? $address->zip_code : ''?>" required />
                </div>
                <div class="form-group col-md-6">
                  <label for="inputState">Country</label>
                  <select name="country" class="form-control" id="Country" required>
                    <option value="">Select Country Name</option>
                    <?php foreach($country_list as $countrydata){ 

                           if($address->country == $countrydata->country_id){ ?>

                            <option value="<?= $countrydata->country_id; ?>" selected><?= $countrydata->name; ?></option>
                            
                            <?php } else{?>

                            <option value="<?= $countrydata->country_id; ?>"><?= $countrydata->name; ?></option>

                          <?php } }?>
                  </select>
                </div>
              </div>

            <div class="form-group">
              <label for="inputAddress">Address Detail</label>
          	  <textarea class="form-control add" id="inputAddress" name="address" placeholder="Landmark / Building / Apartment No. / Floor" required><?= isset($address->address) ? $address->address : ''?></textarea>
            </div>

        		<div class="form-group">
        			<button class="btn btn-primary w-100" name="save" id="save">Save</button>
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
$(document).ready(function(){

  $('#Address').on('submit', function (e) {
  e.preventDefault();
    $.ajax({
      type: 'POST',
      url: '/<?= $TYPE; ?>/profile/add-address',
      data: $('#Address').serialize(),
      dataType:"json",
      success: function (response) {          
              if(response.success){
                  $('#Reviewmessage').html('<div class="addtocart message">Address updated sucessfully</div>');
              }
          }
      });
  });

});
</script>