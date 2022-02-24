<?php 
$TYPE = $_SESSION['type'];
$logged_in = FALSE;
if($this->session->userdata($TYPE)){
    $session_obj = $this->session->userdata($TYPE);
	//echo "<pre>"; print_r($session_obj); echo "</pre>";
	$login_id  = $session_obj['login_id'];
	$name      = $session_obj['fname'];
    $email     = $session_obj['email'];
    $image     = isset($session_obj['image']) ? $session_obj['image'] : '';
}

?>
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
			<h3>My Account</h3>
			<div class="row">
				<div class="col-md-12">
					<?php if($this->session->flashdata('message')){?>
			            <div class="alert alert-success">
			                <?= $this->session->flashdata('message')?>
			            </div>
			        <?php } ?>
	    		</div>
				<div class="col-md-6">
					<div class="ac-box border">
						<h2>ACCOUNT DETAILS <a href="/<?= $TYPE?>/profile/customer-profile"><i class="fa fa-pencil"></i></a></h2>
						<hr>
						<p><span><?= $account_detail->fname.' '.$account_detail->lname; ?></span></p>
						<p><span><?=$account_detail->email; ?></span></p>
						<p><span><?=$account_detail->mobile; ?></span></p>
						<a href="/<?= $TYPE?>/profile/customer-change-password">Change Password</a>

					</div>
				
				</div>
				<div class="col-md-6">
					<div class="ac-box border">
						<h2>ADDRESS BOOK<a href="/<?= $TYPE?>/profile/customer-profile" title="Edit billing address"><i class="fa fa-pencil"></i></a></h2>
						<hr>
						<p><span>Your default Billing address:</span></p>
						<p><?=$account_detail->street; ?></p>
						<p><?=$account_detail->city; ?>, <?=$account_detail->zip_code; ?></p>
						<p><?=$country; ?></p>
						<p><?=$account_detail->address; ?></p>
						<a href="/<?= $TYPE?>/profile/shipping-address">Add shipping address</a>

					</div>
				
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
</section>	  
	
