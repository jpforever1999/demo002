  

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
			<h3>My Saved Items</h3>
			<hr>
			<div id="msg"></div>							
			<div class="row m-1">
				<div class="col-md-12" id="WishlistData">
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
</section>	  
<script type="text/javascript">

$(document).ready(function(){
	get_wishlist_product();
	wishlist_remove();
});

function get_wishlist_product(){
 //THIS FUNCTION USE FOR WISHLIST PRODUCT LISTING
    var postData = {"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
    var request = $.ajax({
      url: "/<?= $TYPE; ?>/profile/ajax-get-wishlist-product",
      type: "POST",
      data: postData,
      dataType: "json"
    }); 

    request.done(function(response) {
        var Wishlist_html = '';
        if(response.status == '1'){
            var data = response.data;
            var buy  	='Buy Now';
            var Remove  ='Remove';

            $.each(data, function(key, row) {
                Wishlist_html+='<div class="ac-box border row h-a">'+
					'<div class="col-sm-2 p-0">'+
						'<img src="<?php echo base_url(); ?>assets/uploads/files/'+row.productimg+'" alt="" class="img-fluid">'+
					'</div>'+
					'<div class="col-sm-6 p-0">'+
						'<h2>'+row.productname+'</h2>'+
					'</div>'+
					'<div class="col-sm-1 price text-center p-0">'+
					'<p>$'+row.price+'</p>'+
					'</div>'+
					'<div class="col-sm-3 p-0 pl-2 gree">'+
					'<button class="btn buy-now">'+buy+'</button>'+
					'<button class="btn remove" id="'+row.wishlist_id+'"><i class="fa  fa-trash-o"></i> '+Remove+'</button>'+
					'</div>'+
				'</div>';
            });

        Wishlist_html = Wishlist_html ? Wishlist_html : '<div class="container small-p mb-5">There is no information to display.</div>';

        $('#WishlistData').html(Wishlist_html);

        }
    });
}

    function wishlist_remove(){
    // Remove product from Wishlist
    $('#WishlistData').on('click', '.remove', function (e) {
        var id = $(this).attr('id');
        var postData = {"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
        postData.id = id;
        swal({
            title: "Are you sure?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                 $.ajax( {
                     url:'/<?= $TYPE; ?>/profile/ajax-remove-wishlist-product',
                     type:'post',
                     dataType:"json",
                     data: postData,
                     success:function(data) {
                     	$('#msg').show();
                     	get_wishlist_product();
                     	$('#msg').addClass('alert alert-success');
                     	$('#msg').html(data.message);
                     	setTimeout(function() {
							$('#msg').hide();
						}, 1000);
                     }
                 });
            }
        });
    });

}

</script>
