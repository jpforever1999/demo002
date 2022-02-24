<?php $url = $_SERVER['REQUEST_URI']; 
	$page = explode('/', $url);
	//print_r($page);
?>
<div class="col-md-3 account-menu border">
    <ul>
      <li><a href="/<?= $TYPE?>/profile" class="my1">My Account</a></li>
      <li><a href="/<?= $TYPE?>/profile/customer-order" class="my1 my2">Orders</a></li>
      <li><a href="/<?= $TYPE?>/profile/customer-voucher" class="my1 my3">Voucher Credit</a></li>
      <li><a href="/<?= $TYPE?>/profile/customer-wishlist" class="my1 my4">Wishlist Items</a></li>
      <li><a href="/<?= $TYPE?>/profile/customer-address" class="my1 my5">Shipping Address</a></li>
      <li><a href="/<?= $TYPE?>/profile/customer-change-password" class="my1 my6">Change Password</a></li>
      <li><a href="/<?= $TYPE?>/auth/logout" class="my1 my7">Logout</a></li>
    </ul>
</div>