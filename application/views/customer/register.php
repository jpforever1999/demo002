<section class="banner2">
    <div class="bg2"></div>
    <div class="container pdd">
        <div class="row">
            <div class="col-md-5 offset-md-3 sign-in-content">
                <div class="sign-box row mb-5 ">
                    <div class="col-3 text-center">
                        <img src="/assets/frontend/images/s_icon_1.png" alt="">
                    </div>
                    <div class="col-9 pl-0">
                        <h2>TRACK YOUR ORDERS</h2>
                        <p>Track orders, manage cancellations &amp; returns.</p>
                    </div>
                </div>
                <div class="sign-box row mb-5">
                    <div class="col-3 text-center">
                        <img src="/assets/frontend/images/s_icon_2.png" alt="">
                    </div>
                    <div class="col-9 pl-0">
                        <h2>SHORTLIST ITEMS YOU LOVE</h2>
                        <p>Keep items you love on a watchlist.</p>
                    </div>
                </div>
                <div class="sign-box row">
                    <div class="col-3 text-center">
                        <img src="/assets/frontend/images/s_icon_3.png" alt="">
                    </div>
                    <div class="col-9 pl-0">
                        <h2>AWESOME OFFERS UPDATES FOR YOU</h2>
                        <p>Be first to know about great offers and save.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 sign-in">
                <h1>Create Account </h1>
                <hr>
                <div class="alert alert-danger" style="display:none;" id="loginForm_error"></div>
                <div class="alert alert-success" style="display:none;" id="loginForm_success"></div>
                <?php echo form_open("/$TYPE/auth/register", array('id' => 'loginForm', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'my-form')) ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">First Name</label>
                        <input type="text" name="fname" id="name" placeholder="First Name" class="form-control" required data-parsley-pattern="^[a-zA-Z\s+]+$" data-parsley-error-message="Please enter valid name." data-parsley-errors-container="#name_error" />
                    </div>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Last Name</label>
                        <input type="text" name="lname" placeholder="Last Name" class="form-control" data-parsley-pattern="^[a-zA-Z\s+]+$" data-parsley-error-message="Please enter valid name." data-parsley-errors-container="#name_error" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email ID</label>
                        <input type="email" class="form-control" placeholder="Email ID" name="email" id="email"value="" data-parsley-pattern="^[a-zA-Z0-9\'\.\-_\+]+@[a-zA-Z0-9\-]+\.([a-zA-Z0-9\-]+\.)*?[a-zA-Z]+$" data-parsley-error-message="Please enter valid email." maxlength="100" data-parsley-errors-container="#email_error" required />
                    </div>                    
                    <div class="form-group">
                        <label for="Mobile">Mobile Number</label>
                        <input type="text" name="mobile"class="form-control" placeholder="Mobile No" value="" onkeypress="return isNumberKey(event)" data-parsley-pattern="^((5|6|7|8|9)[0-9]{9})$" data-parsley-error-message="Please enter valid mobile number." data-parsley-errors-container="#mobile_error" maxlength="10" required />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password" value="" data-parsley-errors-container="#password_error" required minlength="3" maxlength="15" data-parsley-error-message="Password must be at least 3 characters" />
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input">
                        <label class="form-check-label">I want to receive Newsletters with the offers.</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                    <h2><span>OR Register WITH</span></h2>
                    <button type="button" class="btn btn-primary w-100 fb"><i class="fa fa-facebook-f"></i>Facebook</button>
                    <button type="button" class="btn btn-primary w-100 gg"><i class="fa fa-google"></i>Google</button>
                    <a href="/<?= $TYPE?>/auth/login" class="not-yet">Already have an account?</a>                    
                    <input type="hidden" name="api" value="1">        
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</section>
<script>
$("#loginForm").on('submit', function(e) {
    e.preventDefault();
    var loginForm = $(this);
    $.ajax({
        url: loginForm.attr('action'),
        type: 'post',
        data: loginForm.serialize(),
        success: function(response){
            if(response.status == '1') {
                $('#loginForm_error').hide();
                $('#loginForm_success').show();
                $('#loginForm_success').html(response.message);

                // Simulate a mouse click:
                window.location.href = '<?= base_url()?><?= $TYPE?>/dashboard';
            }else{
                $('#loginForm_success').hide();
                $('#loginForm_error').show();
                $('#loginForm_error').html(response.message);
            }
        }
    });
});
/*
$(document).ready(function() {
    $('form').parsley();
    $("#name").focus();
});*/
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
