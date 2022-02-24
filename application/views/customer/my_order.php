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
			<h3>My Orders</h3>
			
			<div class="tabbable-panel">
				<div class="tabbable-line">
					<ul class="nav nav-tabs ">
						<li class="active">
							<a href="#tab_default_1" data-toggle="tab">
							ORDERS (<?=$order_count->cnt;?>)		 </a>
						</li>
						<!--<li>
							<a href="#tab_default_2" data-toggle="tab">
							CLOSED ORDERS (0)		 </a>
						</li>-->
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_default_1">
							<div class="row m-1" id="MyOrderList">
						        
							</div> 

						</div>

					</div>
				</div>
			</div>
			
		</div>
	</div>
	</div>
</div>
</section>	  


<script type="text/javascript">

$(document).ready(function() {

//THIS FUNCTION USE FOR SHIPPING ADDRESS LIST
var postData = {"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
var request = $.ajax({
  url: "/<?= $TYPE; ?>/profile/ajax-get-customer-order",
  type: "POST",
  data: postData,
  dataType: "json"
}); 

    request.done(function(response) {
        var outerHtml = '';
        if(response.status == '1'){
            var data = response.data;
            $.each(data, function(key, row) {
                var MyOrderList_html = ''; var more_then_one=''; var order_last_div = '';
            	$.each(row, function(keyinner, rowinner) {
                MyOrderList_html='<div class="col-md-12">'+
									  '<div class="row order-step">'+
									    '<div class="col-md-3">'+
									      '<h5>Order Placed<br><span>'+rowinner.order_date+'</span></h5>'+
									    '</div>'+
									    '<div class="col-md-2">'+
									      '<h5>Total<br><span>$'+rowinner.totalprice+'</span></h5>'+
									      '</div>'+
									    '<div class="col-md-3">'+
									      '<h5>Ship To<br><span>S.R.Verma <i class="fa fa-chevron-down" aria-hidden="true"></i></span></h5>'+
									    '</div>'+
									    '<div class="col-md-4 text-right">'+
									      '<h5>Order # '+rowinner.order_uid+'<br><span>Order Detail | Invoice <i class="fa fa-chevron-down" aria-hidden="true"></i></span></h5>'+
									      '</div>'+
									    '</div>';

									  more_then_one += '<div class="ac-box border row h-a">'+
									  '<h4>Expected Delivery date on '+rowinner.delivery_date+' <span>Your item has been delivered.</span></h4>'+ 
									    '<div class="col-sm-2 p-0">'+
									     '<img src="'+rowinner.image+'" alt="" class="img-fluid">'+
									    '</div>'+
									    '<div class="col-sm-6 p-0">'+
									      '<h2>'+rowinner.productname+'</h2>'+
									      '<p><b>Quantity: </b>'+rowinner.quantity+'</p>'+
									      '<p>Saasller: Balaji Watches</p>'+
									    '</div>'+
									    '<div class="col-sm-1 price text-center p-0">'+
											'<p>$ '+rowinner.proprice+'</p>'+
										'</div>'+
									    '<div class="col-sm-3 p-0 pl-2 gree">'+
										'<a href="/<?= $TYPE; ?>/profile/track-package/'+rowinner.order_id+'">Track Package</a>'+
										'<a href="javascript:void(0);" class="btnGrey">Cancel Item</a>'+
										'<a href="javascript:void(0);" class="btnGrey">Archive Order</a>'+
										'</div>';

                                        
									  order_last_div ='</div>'+
									'</div>';
				});
                outerHtml += MyOrderList_html + more_then_one + order_last_div;
            });

        //MyOrderList_html = MyOrderList_html ? MyOrderList_html : '<div class="container small-p mb-5">There is no information to display.</div>';
        outerHtml = outerHtml ? outerHtml : '<div class="container small-p mb-5">There is no information to display.</div>';

        $('#MyOrderList').html(outerHtml);

        }
    });

        request.fail(function(jqXHR, textStatus) {
           // $('.page-loading').hide();
          //console.log( "Request failed: " + textStatus );
        });

 });


</script>	
