<?php 
$default_currency = default_currency();
$currency =get_currency($default_currency);
$rate = $currency->rate;
$symbol = $currency->symbol;
$cart = get_cart();
#echo "<pre>"; print_r($currency); echo "</pre>";  
//echo $detail->post_content;
?>
<section> <div class="container">
<?= $breadcrumbs ?> 		
<?php if($cart) { ?>
<div class="row mb-4"><div class="col-md-8">
<div class="table-cart"><form id="cart_history">
<table>
	<thead>
		<tr>
			<th><a href="javascript:void(0);" class="all" id="allproduct">All</a></th>
			<th>Product</th><th>Price</th>	<th>Quantity</th><th>Total</th>
		</tr>
	</thead>
	<tbody>
	
		<?php 
		//echo "<pre>";	echo "tt=="; print_r($cart);	echo "</pre>";
		//die;
		$item = '';
		$gtotal = 0;$total=0;	
		foreach($cart as $key=>$val){			
			$gtotal+= $val['product_qty']*$val['product_net_revenue'];
			$data = json_decode($val['order_item_name']);			
			$total = (float) $val['product_qty']* (float)$val['product_net_revenue'];
			$item .=$key.',';
			
		?>
		<tr class="bg-white border item-<?= $val['order_item_id']; ?>">
			
			<td class="check-all">		
				<div class="check"><input name="product_item[]" value="<?php echo $total; ?>" type="checkbox" id="product_item_<?php echo $val['order_item_id']; ?>" data-id="<?php echo $val['order_item_id']; ?>" checked></div>
			</td>
			<td class="product">	
				<?php 	
				$product_id = (int)$val['product_id']; 				
				$img = get_thumb_link($val['product_id']);							
				if(isset($img) && !empty($img)){ ?>
				<div class="img-product"><img src="<?php echo $img; ?>" alt="logo" class="mCS_img_loaded"></div>				
				<?php }
				$tmp = null;
				foreach($data[0] as $k=>$v){
					$tmp[] = $k;
				}
				//echo "<pre>"; print_r($tmp); echo "</pre>";
				
				
				for($i=0; $i<sizeof($tmp); $i++){
					foreach($data as $k=>$v){				
					$key = trim($tmp[$i]);                
					$link = '';
					foreach($v as $key1 =>$val1)
					{
					  $link .= get_slug($val1).'/';    
					}
					$link = rtrim($link, "/"); 
					//echo $key;	
					$class = 'attributes';
					if($key == 'title'){
						$class = '';
					}
					?>
					<p class="<?= $class ?> item itemid-<?= $val['order_item_id']; ?>"><a href="<?php echo get_permalink($link); ?>" title="product title"><?php echo $v->$key; ?></a></p>				

					<?php }
				} ?>

				<a href="javascript:void(0);" class="btn-delete kk" data-id="<?= $val['order_item_id']; ?>" >Delete</a>
			</td>
			
			 <td class="price">
				<div class="price2"><?php 				
				$product_net_revenue = $val['product_net_revenue'];			
				echo $symbol.''.sprintf('%.02f',$rate*$product_net_revenue);
				?></div>
					
			</td>  
			
			<td class="product-count quantity">
											
<div class="count">
<div class="input-group numbering">
<span class="input-group-btn"><a href="javascript:void(0);" class="btn btn-default quantity_update" data-id="minus" data-dir="dwn"><i class="fa fa-minus"></i></a></span>
<input type="text" name="quantity[]" class="jp form-control numeric text-center qty_update" value="<?php echo $val['product_qty'] ?>" data-itemid="<?php echo $val['order_item_id']; ?>">
<span class="input-group-btn"><a href="javascript:void(0);" class="btn btn-default quantity_update" data-id="plus" data-dir="up"><i class="fa fa-plus"></i></a></span>
</div>
</div>



				
			</td>
			
			<td class="total">
				<div class="total text-center">
					<?php					
					$total = (float) $val['product_qty']* (float)$val['product_net_revenue'];					
					echo $symbol.''.sprintf('%.02f',$rate*$total);
					?>
				</div>
			</td>
			
		</tr>
		<?php } 
			//echo "<pre>"; print_r($item); echo "<pre>";
		?>		
		
		</tbody>
</table>
</form>

</div>

</div>
<div class="col-md-4">

<div class="cart-totals p-3 border">
<h3>Cart Totals</h3>
<hr>
<form action="/checkout" class="ckeckout" id="checkoutForm" method="post">	

<table>
<tbody>
	<tr>
		<td>Subtotal</td>
		<?php ?>
		<td class="subtotal"><div class="item_total" id="cart_sum"><?php 
		echo $Subtotal = $symbol.''.sprintf('%.02f',$rate*$gtotal); 
		$subtotal_hidden = sprintf('%.02f',$rate*$gtotal); ?></div>
		</td>
	</tr>
	<tr>
		<td class="pb-4">Shipping</td>
		<td class="free-shipping pb-4">Free Shipping</td>
	</tr>
	<tr class="total-row">	
		<td>Total</td>
		<td class="price-total"><div class="item_grand_total" id="grand_total"><?php echo $Subtotal; ?></div></td>
	</tr>
</tbody>
</table>
<div class="btn-cart-totals">
	<input type="hidden" name="cart_item" id="cart_item" value="<?php echo rtrim($item, ','); ?>">
	<input type="hidden" name="proceed_amount" id="proceed_amount" value="<?php echo $subtotal_hidden; ?>">
	<input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />	
	<button type="submit" name="submit" value="submit" class="update btn-checkout">Proceed to Checkout </button>
	
</div>

</form>
<!-- /form -->
</div>

</div>
<!--/main slider carousel-->
<!-- thumb navigation carousel -->
</div>
<?php }else{
	echo '<div class="alert alert-warning">Your cart is empty!</div>';
} ?>
</div>
</section>

<script>

$(function(){
$("input[name='product_item[]']").click(function(){
	
	var currency_symbol = '<?php echo $symbol ?>';
	var val = []; var k=0; item='';
	$(':checkbox:checked').each(function(i){
	  k += Number($(this).val());
	  item += $(this).attr('data-id') + ',';
	//	alert(item);
	});
	$('#cart_sum').html(currency_symbol +'' + k.toFixed(2));
	$('#grand_total').html(currency_symbol +'' + k.toFixed(2));
	$('#proceed_amount').val(currency_symbol + '' + k.toFixed(2));
	$('#cart_item').val(item.replace(/,\s*$/, ""));
	
  });
});


</script>


<script>
$(document).on('click','.quantity_update', function(e){
    var id = $(this).attr('data-id');
    var txtBox = $(this).closest('.numbering').find('input[type=text]');
    var quantity = txtBox.val().trim();
    var item_id = txtBox.attr('data-itemid');

    if(id == 'plus'){
        quantity++;
    }else if(id == 'minus'){
        if(quantity > 1){
            quantity--;
        }
    }
    update_cart(item_id,quantity);
    txtBox.val(quantity);
});

$('.btn-checkout').click(function() {
    proceed_checkout();
});

$(document).on('keyup','.qty_update', function(e){
   	var item_id = $(this).attr('data-itemid');
    var quantity = 1;
    if($(this).val() == '' || $(this).val() == 0){
        quantity = 1;
    }else{
        quantity = $(this).val();
    }
    update_cart(item_id,quantity);
    $(this).val(quantity);
	
} );

function update_cart(item_id,quantity)
{
    console.log('item_id: ' + item_id + '   quantity: ' + quantity);
	
	var postData = {};
	var csrf_name = "<?= $csrf->name; ?>";
	var csrf_value = "<?= $csrf->hash; ?>";
	postData[csrf_name] =  csrf_value;
	postData.item_id = item_id;
	postData.quantity = quantity;

	$.ajax({
		url         :   '<?php echo base_url();?>customer/basket/update_cart_qty',
		type        :   'post',
		enctype	    :   'multipart/form-data',
		dataType    :   "json",  
		data        :   postData,
		success     :   function(data){
			if(data.success)
			{			
			if(data.MSG)
			   {
				swal('Session expired.');
			   }

			swal('Quantity updated'); 
			location.reload(true);
		   } 
	   
		}
	});
	
}


function proceed_checkout()
{
	
	var postData = {};
	var csrf_name = "<?= $csrf->name; ?>";
	var csrf_value = "<?= $csrf->hash; ?>";
	postData[csrf_name] =  csrf_value;
	postData.cart_item = $('#cart_item').val();

	$.ajax({
		url         :   '<?php echo base_url();?>customer/basket/proceed_checkout',
		type        :   'post',
		dataType    :   "json",  
		data        :   postData,
		success     :   function(data){
			if(data.success)
			{			
		    } 
		}
	});
}



$(document).on('click','.btn-delete', function(e){
    var uid=$(this).attr('data-id');  
	//alert(uid);
	delete_post(uid);
} );

function delete_post(id)
{
	var postData = {};
	var csrf_name = "<?= $csrf->name; ?>";
	var csrf_value = "<?= $csrf->hash; ?>";
	postData[csrf_name] =  csrf_value;
	postData.id = id;	
	$.ajax({
		url         :   '<?php echo base_url();?>customer/basket/del',
		type        :   'post',
		enctype	    :   'multipart/form-data',
		dataType    :   "json",  
		data        :   postData,
		success     :   function(data){
			if(data.success)
			{			
			if(data.MSG)
			   {
				swal('Session expired.');
			   }

			swal('Delete Successfully.'); 
			location.reload(true);
		   } 
	   
		}
	});
}
</script>

