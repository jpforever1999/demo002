<section>
  <img src="/assets/frontend/images/p_banner.jpg" class="img-fluid w-100" alt="">
</section>

  <section>
	  
<div class="container">
		
<nav aria-label="breadcrumb">
  <ol class="breadcrumb text-uppercase">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?=base_url()?>customer/profile/customer-order">My Order</a></li>
    <li class="breadcrumb-item active" aria-current="page">Order Tracking</li>
  </ol>
</nav>
			 
	<div class="container tracking">
    <article class="card">
        <header class="card-header"> <a href="<?=base_url()?>customer/profile/customer-order">My Order</a> / Tracking </header>
        <div class="card-body">
        	<div id="OrderTrack">
            
           </div>
            <hr>
            <a href="<?=base_url()?>customer/profile/customer-order" class="btn btn-primary" data-abc="true"> <i class="fa fa-chevron-left"></i> Back to orders</a>
        </div>
    </article>
</div>
</div>
</section>	  
<script type="text/javascript">
$(document).ready(function() {

  //THIS FUNCTION USE FOR TRACKING ORDER
  var postData = {"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
  postData.order_id = "<?=$order_id ?>";
  var request = $.ajax({
    url: "/<?= $TYPE; ?>/profile/ajax-get-track-package",
    type: "POST",
    data: postData,
    dataType: "json"
  }); 


  request.done(function(response) {
        var OrderTrack_html = '';
        if(response.status == '1'){
            var data = response.data;
            var OrderTrack_html='<h6 class="mb-2">OrderID: '+data[0].order_uid+'</h6>'+
            '<article class="card">'+
                '<div class="card-body row">'+
                    '<div class="col"> <strong>Estimated Delivery time:</strong> <br>'+data[0].delivery_date+' </div>'+
                    '<div class="col"> <strong>Shipping BY:</strong> <br> BLUEDART, | <i class="fa fa-phone"></i> +1598675986 </div>'+
                    '<div class="col"> <strong>Status:</strong> <br> '+data[0].orderstatus+'</div>'+
                    '<div class="col"> <strong>Tracking #:</strong> <br> BD045903594059 </div>'+
                '</div>'+
            '</article>'+
            '<div class="track">'+
                '<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>'+
                '<div class="step active"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Picked by courier</span> </div>'+
                '<div class="step"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On the way </span> </div>'+
                '<div class="step"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Ready for pickup</span> </div>'+
            '</div>'+
            '<hr>'+
            '<ul class="row">';
         $.each(data, function(key, row) {
            OrderTrack_html+=
                '<li class="col-md-4">'+
                    '<figure class="itemside mb-3">'+
                        '<div class="aside"><img src="'+row.productimg+'" class="img-sm border"></div>'+
                        '<figcaption class="info align-self-center">'+
                            '<p class="title">'+row.productname+'</p> <span class="text-muted">$ '+row.price+' </span>'+
                        '</figcaption>'+
                    '</figure>'+
                '</li>';
        	});
        OrderTrack_html+='</ul>';

        OrderTrack_html = OrderTrack_html ? OrderTrack_html : '<div class="container small-p mb-5">There is no information to display.</div>';

        $('#OrderTrack').html(OrderTrack_html);

        }

      });

}); 

</script>