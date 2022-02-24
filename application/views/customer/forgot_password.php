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
                <h1>Forgot Password</h1>
                <hr>  
                <div class="alert alert-danger" style="display:none;" id="loginForm_error"></div>
                <div class="alert alert-success" style="display:none;" id="loginForm_success"></div>
                <?php echo form_open("/$TYPE/auth/forgot", array('id' => 'loginForm', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'my-form')) ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email ID</label>
                        <input type="email" class="form-control" placeholder="Email ID" name="email" id="email" required data-parsley-pattern="^[a-zA-Z0-9\'\.\-_\+]+@[a-zA-Z0-9\-]+\.([a-zA-Z0-9\-]+\.)*?[a-zA-Z]+$" data-parsley-error-message="This value should be a valid email.">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                    <div class="form-check">
                        <a href="/<?= $TYPE?>/auth/login">Back to Login?</a>
                    </div>
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
               // window.location.href = '<?= base_url()?><?= $TYPE?>/login';
            }else{
                $('#loginForm_success').hide();
                $('#loginForm_error').show();
                $('#loginForm_error').html(response.message);
            }
        }
    });
});
</script>
