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
                <h1>Log in On EL K'lentano Shop </h1>
                <hr>  
                <div class="alert alert-danger" style="display:none;" id="loginForm_error"></div>
                <div class="alert alert-success" style="display:none;" id="loginForm_success"></div>
                <?php echo form_open("/$TYPE/auth/login", array('id' => 'loginForm', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'my-form')) ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email ID</label>
                        <input type="email" class="form-control" placeholder="Email ID" name="email" id="email" required data-parsley-pattern="^[a-zA-Z0-9\'\.\-_\+]+@[a-zA-Z0-9\-]+\.([a-zA-Z0-9\-]+\.)*?[a-zA-Z]+$" data-parsley-error-message="This value should be a valid email.">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password" required placeholder="Password" value="" data-parsley-errors-container="#password_error" required />
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Log In</button>
                    <div class="form-check">
                        <!--<input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>-->
                        <a href="/<?= $TYPE?>/auth/forgot">Lost your password?</a>
                    </div>
                    <h2><span>OR LOGIN WITH</span></h2>
                    <button type="" class="btn btn-primary w-100 fb"><i class="fa fa-facebook-f"></i>Facebook</button>
                    <button type="submit" class="btn btn-primary w-100 gg"><i class="fa fa-google"></i>Google</button>
                    <a href="/<?= $TYPE?>/auth/register" class="not-yet">No account yet ? Register Now</a>
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
</script>
