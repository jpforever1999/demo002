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
			<h3>Change Password </h3>
      <hr>
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
              <div class="alert alert-success" id="SubmitChamngePassword">
              </div>
          </div>
				<div class="col-md-6 offset-md-3">
          <form method="POST" id="ChamngePassword" >
					   <div class="ac-box border my-form">
              <input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />
                  <div class="form-group col-md-12">
                    <label for="inputPassword4">New Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" value="" data-parsley-errors-container="#password_error"  maxlength="15" data-parsley-error-message="Please fill the passowrd" required="" />
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputPassword4">Confirm New Password</label>
                    <input type="password" class="form-control" name="confirm_password" id="ConfirmPassword" placeholder="Password" value="" data-parsley-errors-container="#password_error" minlength="1" maxlength="15" data-parsley-error-message="Confirm Password must be same as new password" required="">
                  </div>
                  <div class="form-group col-md-12">	
                <button class="btn btn-primary w-100" type="submit" name="submit">Submit</button>
						  </div>
            </div>
          </form>

					</div>
				
				</div>
	
			</div>
		</div>
	</div>
	</div>
</div>
</section>	  


<script type="text/javascript">
  
$(document).on('ready', function() {
$('#SubmitChamngePassword').hide();
$('#ChamngePassword').on('submit', function (e) {
    e.preventDefault();
      $.ajax({
        type: 'POST',
        url: '/customer/profile/change-password',
        data: $('#ChamngePassword').serialize(),
        dataType:"json",
        success: function (response) {          
                if(response.status == '1'){
                    $('#SubmitChamngePassword').html(response.message);
                    setTimeout(function() { 
                            $('.alert-success').fadeOut('fast'); 
                    }, 3000); 
                    $("#ChamngePassword").trigger("reset");
                    //location.href = '<?=base_url();?>customer/profile/customer-change-password';
                    $('#SubmitChamngePassword').show();
                }else{
                    $('#SubmitChamngePassword').show();
                    $('#SubmitChamngePassword').html(response.message);
                    //location.href = '<?=base_url();?>customer/profile/customer-change-password';
                     setTimeout(function() { 
                            $('.alert-success').fadeOut('fast'); 
                    }, 3000);
                }
            }
        });
    });
});


</script>
		  
	
