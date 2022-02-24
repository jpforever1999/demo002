  <section>
  	<img src="frontend/images/p_banner.jpg" class="img-fluid w-100" alt="">
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
			<h3>Update Profile </h3>
			<div class="row">
				<div class="col-md-12">
          <div class="alert alert-danger alert-success" id="UpdateProfile">
          </div>
          <form class="form-group"  method="post" id="UserProfile">
					<div class="ac-box border my-form">
              <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="FirstName">First Name</label>
                    <input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />
                    <input type="text" name="fname" id="FirstName" placeholder="First Name" class="form-control" data-parsley-pattern="^[a-zA-Z\s+]+$" data-parsley-error-message="Please enter valid name." data-parsley-errors-container="#name_error" value="<?= isset($userdetail->fname) ? $userdetail->fname : ''?>" />
                </div>
                <div class="form-group col-md-6">
                  <label for="LastName">Last Name</label>
                  <input type="text" name="lname" placeholder="Last Name" class="form-control" data-parsley-pattern="^[a-zA-Z\s+]+$" data-parsley-error-message="Please enter valid name." data-parsley-errors-container="#name_error" value="<?= isset($userdetail->lname) ? $userdetail->lname : ''?>" />
                </div>
                <div class="form-group col-md-6">
                  <label for="MobileNo">Mobile No</label>
                  <input type="text" name="mobile" class="form-control" placeholder="Mobile No" onkeypress="return isNumberKey(event)" data-parsley-pattern="^((5|6|7|8|9)[0-9]{9})$" data-parsley-error-message="Please enter valid mobile number." data-parsley-errors-container="#mobile_error" id="MobileNo" maxlength="10" value="<?= isset($userdetail->mobile) ? $userdetail->mobile : ''?>" />
                </div>
                <div class="form-group col-md-6">
                  <label for="MobileNo">Email ID</label>
                  <input type="email" class="form-control" placeholder="Email ID" name="email" id="email" data-parsley-pattern="^[a-zA-Z0-9\'\.\-_\+]+@[a-zA-Z0-9\-]+\.([a-zA-Z0-9\-]+\.)*?[a-zA-Z]+$" data-parsley-error-message="Please enter valid email." maxlength="100" data-parsley-errors-container="#email_error" value="<?= isset($userdetail->email) ? $userdetail->email : ''?>" />
                </div>

                <div class="form-group col-md-6">
                  <label for="inputZip">Street</label>
                  <input type="text" name="street" placeholder="Street Name" class="form-control" id="inputZip" value="<?= isset($userdetail->street) ? $userdetail->street : ''?>"  />
                </div>
                <div class="form-group col-md-6">
                  <label for="inputState">City</label>
                  <input type="text" class="form-control" placeholder="City Name" name="city" id="City" value="<?= isset($userdetail->city) ? $userdetail->city : ''?>"  />
                </div>
                <div class="form-group col-md-6">
                  <label for="inputZip">Zip Code</label>
                  <input type="text" name="zip_code" class="form-control" placeholder="Zip Code" id="ZipCode" value="<?= isset($userdetail->zip_code) ? $userdetail->zip_code : ''?>"  />
                </div>
                <div class="form-group col-md-6">
                  <label for="inputState">Country</label>
                  <select name="country" class="form-control" id="Country" >
                    <option value="">Select Country Name</option>
                    <?php foreach($country_list as $countrydata){ 

                      if($userdetail->country == $countrydata->country_id){ ?>

                        <option value="<?= $userdetail->country; ?>" selected><?= $countrydata->name; ?></option>
    
                      <?php } else{?>

                        <option value="<?= $countrydata->country_id; ?>"><?= $countrydata->name; ?></option>

                      <?php } }?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                  <label for="inputAddress">Address Detail</label>
                  <textarea class="form-control add" id="inputAddress" name="address" placeholder="Landmark / Building / Apartment No. / Floor" required><?= isset($userdetail->address) ? $userdetail->address : ''?></textarea>
                </div>

        		<div class="form-group">
        			<button class="btn btn-primary w-100" name="submit" id="update">Update Profile</button>
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
$('#UpdateProfile').hide();
  $('#UserProfile').on('submit', function (e) {
  e.preventDefault();
    $.ajax({
      type: 'POST',
      url: '/<?= $TYPE; ?>/profile/update-customer-profile',
      data: $('#UserProfile').serialize(),
      dataType:"json",
      success: function (response) {          
              if(response.status == '1'){
                  $('#UpdateProfile').html(response.message);
                  $('#UpdateProfile').show();
                   setTimeout(function() { 
                      $('.alert-success').fadeOut('fast'); 
                  }, 3000);
                  location.href = '<?=base_url();?>customer/profile/';
              }else{
                  $('#UpdateProfile').html(response.message);
                  $('#UpdateProfile').show();
                   setTimeout(function() { 
                      $('.alert-success').fadeOut('fast'); 
                  }, 3000);
                  //location.href = '<?=base_url();?>customer/profile/';
              }
          }
      });
  });

});

function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    {
        return false;
    }
    return true;
}
</script>