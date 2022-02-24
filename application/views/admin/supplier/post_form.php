<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Add new</h3>
                </div>
                <?= $breadcrumbs ?>
            </div>
        </div>
    </div>.
    <div class="container-fluid">
        <div class="edit-profile">
            <div class="row ">
                <div class="col-lg-12">
                    <?php if (($this->session->flashdata('error')) || validation_errors()!='') { ?>
                    <div class="alert alert-danger">
                        <?= validation_errors();?>
                        <?= $this->session->flashdata('error')?>
                    </div>
                    <?php } ?>

                    <?php if($this->session->flashdata('success')){?>
                       <div class="alert alert-success">
                            <?= $this->session->flashdata('success')?>
                       </div>
                    <?php } ?>

					<form method="POST" class="addpost" id="postForm" action='<?php echo "/$TYPE/supplier/$action/$supplier_id"; ?>' enctype="multipart/form-data" autocomplete='off'>
					
					<div class="card-body">
                        <div class="row">							
							<div class="col-sm-6 col-md-4">
                                <div class="form-group"> 
								<label class="form-label">Company name</label>								
                                    <input type="text" name="cname" class="form-control" value="<?php echo isset($cname) ? $cname : '' ?>" placeholder="Company name" required>
                                	
								</div>
                            </div>
							 <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" rows="5" class="form-control" placeholder="Write Address..." ><?php echo isset($address) ? $address : '' ?></textarea>
                                </div>
                            </div>
							<div class="col-sm-6 col-md-4">
                                <div class="form-group">
								<label class="form-label">Registration No. </label>	 							
                                    <input type="text" name="company_registration_no" class="form-control" id="registration" value="<?php echo isset($company_registration_no) ? $company_registration_no : '' ?>" placeholder="Enter registration no">
                                <div id="registratione-error" style="display:none;"></div>	
								</div>
                            </div>
							<div class="col-sm-6 col-md-4">
                                <div class="form-group"> 
								<label class="form-label">City </label>	 							
                                    <input type="text" name="city" class="form-control onlystring" id="city" value="<?= isset($city) ? $city : '' ?>" placeholder="city">
                                <div id="city-error" style="display:none;"></div>	
								</div>
                            </div>
							<div class="col-sm-6 col-md-4">
                                <div class="form-group"> 
								<label class="form-label">State </label>	 							
                                    <input type="text" name="state" class="form-control" id="state" value="<?= isset($state) ? $state : '' ?>" placeholder="state">
                                <div id="state-error" style="display:none;"></div>	
								</div>
                            </div>
							<div class="col-sm-6 col-md-4">
                                <div class="form-group">
								<label class="form-label">Zip code </label>	 							
                                    <input type="text" name="zip_code" class="form-control" id="pincode" value="<?= isset($zip_code) ? $zip_code : '' ?>" placeholder="Zip code">
                                <div id="zip-error" style="display:none;"></div>	
								</div>
                            </div>
							
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group"> 
								<label class="form-label">First name</label>								
                                    <input type="text" name="fname" class="form-control onlystring" value="<?= isset($fname) ? $fname : '' ?>" placeholder="First name" required>
                                	<div id="fname-error" style="display:none;"></div>
								</div>
                            </div>
							<div class="col-sm-6 col-md-4">
                                <div class="form-group"> 
								<label class="form-label">Last name</label>								
                                    <input type="text" name="lname" class="form-control onlystring" value="<?= isset($lname) ? $lname : '' ?>" placeholder="Last name">
                                	
								</div>
                            </div>
							<div class="col-sm-6 col-md-4">
                                <div class="form-group">
								<label class="form-label">Mobile </label>	 							
                                    <input type="text" name="mobile" class="form-control" id="mob" value="<?= isset($mobile) ? $mobile : '' ?>" placeholder="Mobile">
                                <div id="phone-error" style="display:none;"></div>	
								</div>
                            </div>
							
							<div class="col-sm-6 col-md-4">
                                <div class="form-group"> 
								<label class="form-label">Email </label>								
                                    <input type="email" name="email" class="form-control" id="mailer_validate" value="<?= isset($email) ? $email : '' ?>" placeholder="Email Id" required>
                                	
								</div>
                            </div>
							
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" rows="5" class="form-control" placeholder="Write Something..." ><?= isset($description) ? $description : '' ?></textarea>
                                </div>
                            </div>
							
							
							
							<div class="col-sm-6 col-md-4"><br >
								<label class="col-form-label pt-0">Password</label>
								<input type="password" class="form-control form-control-lg" placeholder="Password" id="password" name="password" type="password" value="<?= isset($password) ? $password : '' ?>" required >
							</div>
							<!--<div class="form-group">
								<label class="col-form-label pt-0">Confirm Password</label>
								<input type="password" class="form-control form-control-lg" placeholder="Confirm Password" id="confirm_password" name="confirm_password" type="password" required data-parsley-equalto="#password" data-parsley-error-message="Password and Confirm password should be same" >
							</div>-->
							<div class="form-group col-md-3 m-t-20">
								<label>Profile image (Size:515X512 50KB) </label>
								<input type="file" name="logo" id="image_url" class="form-control" value=""> 								
								<label for="image_url" id="img_error" style="display:none;"  generated="true" class="error">Please enter a value with a valid extension  and image size maximum 50kb.</label>										
								<?php $logo = isset($logo) ? $logo : ''; 
								if($logo){
								?>
								<img src="<?php base_url();?>assets/images/<?php echo $logo; ?>" width="150px" height="150px" alt="feature image" />
								<?php } ?>
							</div>	
								
						    <div class="col-sm-6 col-md-4">
								<div class="form-group"><br >
								<label>Status</label>	
								<?php $status = isset($status) ? $status : ''; ?>									
								<select class="form-control" name="status" required="required">
								  <option value="">Select Status</option>								  
								  <option value="1" <?php if($status=='1') echo "selected=selected"; ?>>Active</option>                          
								  <option value="0" <?php if($status=='0') echo "selected=selected"; ?>>Inactive</option>
								</select>
								</div>  
							</div>   
							
                        </div>
                    </div>
                    <div class="card-footer text-right">
						<input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />
                        <button type="button" class="btn btn-light btn_back">Back</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
//check image validateion
$("#postForm").click(function(){
 $("#img_error").hide();
    var flag=0;
    var files = $("#image_url").get(0).files;
	
	var img_name = $('#image_url').val();
	
    if(img_name!=''){
	var ext = $('#image_url').val().split('.').pop().toLowerCase();

    if($.inArray(ext, ['gif','png','jpg','jpeg','pdf']) == -1){
       flag=1;
    }

    for(var i=0; i<files.length;i++) {

        var file = files[i];
        var name = file.name;
        var size = file.size;
        if(size>600000){
            flag=1;
        }
      }
    if(flag==1){
        $("#img_error").show();
        return false;
        }
    }
})

function validateNumber(event) {
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else {
        return true;
    }
};


$(document).ready(function(){
    $('[id^=pincode]').keypress(validateNumber);
});

$(document).ready(function(){
    $(".onlystring").keypress(function(event){
        var inputValue = event.charCode;
        if(!(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0)){
            event.preventDefault();
        }
    });
});

//update query
$(document).on('click','.btn-edit', function(e){
    var uid=$(this).attr('data-id');
    var url="/<?php echo $TYPE ?>/supplier/update/"+uid+"";
    url_new_tab(e,url);
} );

function url_new_tab(e,url)
{
    if(e.ctrlKey){
        window.open(url);
    }else{
        $(location).attr('href', url);
    }
}
</script> 
