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
</div>
<form method="POST" class="addpost" id="postForm" action='<?php echo "/$TYPE/product/$action/$product_id"; ?>' enctype="multipart/form-data" autocomplete='off' onsubmit="return validatePrices()">

<div class="container-fluid row">
<div class="col-sm-9">
<div class="row">
<div class="col-sm-12 card">
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

<div class="card-body"> 
<div class="row">
<div class="col-sm-6 col-md-6">
<div class="form-group">
	<input type="text" name="post_title"  class="form-control"  value="<?= isset($post_title) ? $post_title : '' ?>" placeholder="Enter Title" onkeypress="return check(event)" required>
</div></div>
<div class="col-sm-12 col-md-12">
<?php if(isset($post_title)) { ?><span>Permalink: <a target="_blank" href="<?php echo site_url('/product/detail/').$post_slug; ?>"><?php echo isset($post_slug) ? $post_slug : '' ?></a></span><?php } ?>
</div>
<div class="col-md-12">
<div class="form-group mb-0">
	<label class="form-label">Body</label>
	<textarea name="post_content" rows="5" class="form-control" placeholder="Write Something..." ><?= isset($post_content) ? $post_content : '' ?></textarea>
</div>
</div>

<div class="form-group col-md-6 m-t-20">
<label for="post_status">Categories</label>
<?php 
	if(isset($category_ids)){
		echo form_dropdown('category[]',$categories,$category_ids,array('class' => 'select2 form-control category_combo','multiple' => true));   
	}else{
		echo form_dropdown('category[]',$categories,null,array('class' => 'select2 form-control category_combo','multiple' => true));
	} ?>
</div>

<?php   ?>
<div class="form-group col-md-6 m-t-20" style="display:none">
<label for="post_status">Tags</label>
<?php                                                    
if(isset($tag_ids)){
echo form_dropdown('tag[]',$tags,$tag_ids,array('class' => 'select2-tags form-control','multiple' => true));
}else{
echo form_dropdown('tag[]',$tags,null,array('class' => 'select2-tags form-control','multiple' => true));
}

?>
</div>


<div class="form-group col-md-6 m-t-20">
<label for="post_status">Brand</label>
<select id="brand_id" name="brand_id" class="form-control brand_combo" data-parsley-errors-container="#brand_id_error" required>
     <option></option>
    <?php
        foreach($brand_obj as $row){
            $brand_seleted = (isset($brand_id) && $brand_id == $row->brand_id) ? 'Selected' : '';
            echo "<option value=\"$row->brand_id\" $brand_seleted>$row->name</option>";
        }
    ?>
</select>
<div id="brand_id_error"></div>
</div>

<div class="form-group col-md-6">
<label for="post_status">Supplier</label>
<select id="supplier_id" name="supplier_id" class="form-control supplier_combo" data-parsley-errors-container="#supplier_id_error" required>
     <option></option>
    <?php
        foreach($supplier_obj as $row){
            $supplier_seleted = (isset($supplier_id) && $supplier_id == $row->supplier_id) ? 'Selected' : '';
            echo "<option value=\"$row->supplier_id\" $supplier_seleted>$row->cname</option>";
        }
    ?>
</select>
<div id="supplier_id_error"></div>
</div>

<?php  ?>
<div class="col-sm-6 col-md-4">		 
<div class="form-group">
<label>Choose Files</label>
<input type="file" class="form-control" name="upload_Files[]" multiple/>				
</div>   
</div> 
<div class="col-sm-12">&nbsp;</div>	
<?php //echo "<pre>"; print_r($gallery); echo "</pre>"; ?>
<div class="col-sm-12 col-md-12">
<div class="gallery">
<ul>
<?php if(isset($gallery) && !empty($gallery)): foreach($gallery as $key=>$file):
$file_name = isset($file->file_name) ? $file->file_name : '';
$imgid = isset($file->id) ? $file->id : '';
?>
<li>
<button title="Delete" data-toggle="tooltip" data-animation="false" data-html="true" class="btn custom-popover-btn btn-delete bg-none" style=" background:none; color:red;" type="button" data-id="<?php echo $imgid; ?>"><i class="fa fa-trash"></i></button>	

<img width="150" height="150" src="<?php echo base_url('assets/uploads/files/'); echo $file_name; ?>" alt="" >
</li>
<?php endforeach; else: ?>
<!--<p>No File uploaded.....</p>-->
<?php endif; ?>
</ul>
</div>
</div>

							
<div class="col-sm-12 col-md-12">&nbsp;</div>	
	<div class="col-md-6">
		<div class="form-group"><br >
		<label>Status</label>									
			<select class="form-control status_combo" name="enabled" required="required">
			  <option value="">Select Status</option>								  
			  <option value="1" selected>Active</option>                          
			  <option value="0">Inactive</option>                           
			</select>
		</div>  
	</div>                            
</div>
</div>


</div>	
</div>

	
<div class="row">
<div class="col-sm-12 p-0">
<div class="card add-product">
<div class="card-header">
<h5 class="m-b-0">
<span>Product data                                       
<span>-
<label for="product-type">
    <select id="product-type" name="product-type" class="form-control">
		<optgroup label="Product Type">
		<option value="simple" selected="selected">Simple product</option>
		<option value="variable">Variable product</option>
    </optgroup>
    </select>
</label>                                   
</span>
</span> 								
</h5>

</div>
<div class="card-body">
<div class="form-menu">
<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-wrench" aria-hidden="true"></i> <span>General</span></a>
    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fa fa-file-text" aria-hidden="true"></i> <span>Inventory</span></a>
    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i class="fa fa-truck" aria-hidden="true"></i> <span>Shipping</span></a>
    <!--<a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fa fa-link" aria-hidden="true"></i> <span>Linked Products</span></a>-->
    <a class="nav-link" id="v-pills-attributes-tab" data-toggle="pill" href="#v-pills-attributes" role="tab" aria-controls="v-pills-attributes" aria-selected="false"><i class="fa fa-clipboard" aria-hidden="true"></i> <span>Attributes</span></a>
    <a class="nav-link" id="v-pills-advanced-tab" data-toggle="pill" href="#v-pills-advanced" role="tab" aria-controls="v-pills-advanced" aria-selected="false"><i class="fa fa-cog" aria-hidden="true"></i> <span>Variant</span></a>
    <!--<a class="nav-link" id="v-pills-get-tab" data-toggle="pill" href="#v-pills-get" role="tab" aria-controls="v-pills-get" aria-selected="false"><i class="fa fa-plug" aria-hidden="true"></i> <span>Get more options</span></a>-->
</div>
</div>
<div class="form-detail">

<div class="tab-content" id="v-pills-tabContent">
<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
											
<div class="form-group row">
<label for="Regular price" class="col-sm-3 col-form-label">Regular price</label>
<div class="col-sm-6">
        <input type="text" name="regular_price" class="form-control no_validate" id="regular_price" value="<?= isset($regular_price) ? $regular_price : '' ?>" placeholder="Regular price" required>
</div>	
</div>

<div class="form-group row">
<label for="Sale price" class="col-sm-3 col-form-label">Sale price</label>
<div class="col-sm-6">
<input type="text" name="sale_price" class="form-control no_validate" id="sale_price" value="<?= isset($sale_price) ? $sale_price : '' ?>" placeholder="Sale price">
</div>

<div class="col-sm-3">
    <a href="JavaScript:void(0)" class="form-control" id="show">Schedule</a>
</div>
</div>

<?php if( isset($sale_price_dates_from) && !empty($sale_price_dates_from)){	
	$st = "display:block";
}else{
	$st = "display:none";
} ?>
<div class="timef" style="<?php echo $st; ?>">
<div class="form-group row">
<label for="Sale price" class="col-sm-3 col-form-label">Sale Price Dates</label> 
<div class="col-sm-6">
	<input type="text" name="sale_price_dates_from" value="<?= isset($sale_price_dates_from) ? $sale_price_dates_from : '' ?>"  class="form-control fancy_date" id="sale_price_dates_from" placeholder="From… YYYY-MM-DD" readonly data-parsley-myvalidator="" data-parsley-error-message="Start Date can't be greater than End Date">
</div>
<div class="col-sm-3">
	<a href="JavaScript:void(0)" class="ccc" id="hide">Cancel</a> <i class="fa fa-question-circle ttc" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="The sale will start at 00:00:00 of 'From' date and end at 23:59:59 of 'To' date."></i>
</div>
</div>
<div class="form-group row">
<label for="Sale price" class="col-sm-3 col-form-label"></label>
<div class="col-sm-6">
  <input type="text" name="sale_price_dates_to" value="<?= isset($sale_price_dates_to) ? $sale_price_dates_to : '' ?>"  class="form-control fancy_date" id="sale_price_dates_to" placeholder="To…  YYYY-MM-DD" readonly>
</div>

</div>
</div>
<hr>

<div class="form-group row">
<label for="inputEmail3" class="col-sm-3 col-form-label">Tax</label>
<div class="col-sm-6">
<select id="tax_id" name="tax_id" class="form-control tax_combo">
    <?php 
        foreach($tax_obj as $row){
            $tax_seleted = (isset($tax_id) && $tax_id == $row->tax_id) ? 'Selected' : '';
            echo "<option value=\"$row->tax_id\" $tax_seleted>$row->name</option>";
        }
    ?>
</select>
</div>
<div class="col-sm-3">
<i class="fa fa-question-circle ttc" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Define whether or not the entire product is taxable, or just the cost of shipping it."></i>
</div>

</div>



  <hr>

<hr>
<h5>Multi-currency</h5>
<p>To override the automatic price conversion for this product, put the fixed price values in the fields below.</p>


</div>
<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
        <div class="form-group row">
        <label for="SKU" class="col-sm-3 col-form-label">SKU</label>
        <div class="col-sm-6">
            <input type="text" name="sku" class="form-control"  value="<?= isset($sku) ? $sku : '' ?>" placeholder="Enter sku" onkeypress="return check(event)" required>
        </div>
        <div class="col-sm-3">
        <i class="fa fa-question-circle ttc" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="SKU refers to a Stock-keeping unit, a unique identifier for each distinct product and services that can be purchased."></i>
        </div>
        </div>
        <div class="checkbox p-0 row" style="display:none;">
            <div class="col-sm-3">Manage stock?</div>
            <div class="col-sm-8 ml-3">
                <input id="dafault-checkbox" type="checkbox" class="d-none ">
                <label for="dafault-checkbox" class="m-0"><p>Enable stock management at product level</p></label>
            </div>
        </div>
       <div class="form-group row m-t-20 ">
            <label for="Stock quantity" class="col-sm-3 col-form-label">Stock Quantity</label>
            <div class="col-sm-6">
                <input type="text" name="stock" class="form-control numeric" id="stock" value="<?= isset($stock) ? $stock : '' ?>" placeholder="Stock Qty" required>
            </div>
            <div class="col-sm-3">
                <i class="fa fa-question-circle ttc" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="SKU refers to a Stock-keeping unit, a unique identifier for each distinct product and services that can be purchased."></i>
            </div>
        </div>
    
        <?php /* ?><div class="form-group row mt-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">Stock status</label>
        <div class="col-sm-6">
        <select id="tax_class" name="tax_class" class="form-control">
        <option value="" selected="selected">In stock</option>
        <option value="reduced-rate">Out of stock</option>
        <option value="zero-rate">On backorder</option>		
        </select>
        </div>
        <div class="col-sm-3">
        <i class="fa fa-question-circle ttc" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Controls whether or not the product is listed as 'in stock' or 'out of stock' on the frontend."></i>
        </div>
        </div><?php */ ?>
		
 <div class="form-group mt-3">
<label for="Range" class="col-form-label">Range <i class="fa fa-question-circle ttc" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Qry (Ex:50-499) Price: (Ex:$120.50)"></i></label>

<?php $quantity_range = isset($quantity_range) ? $quantity_range : '';
$qrange = unserialize($quantity_range);
//echo "<pre>"; print_r($qrange); echo "</pre>";	
$pricerange = isset($price_range) ? $price_range : '';
$price_range = unserialize($pricerange); ?>	

<div id="dynamic_field">
<?php if($quantity_range){
for($i=0;$i<sizeof($qrange);$i++){ ?>
<div class="row" id="row<?php echo $i ?>">
<div class="col-sm-4 col-md-4"> <div class="form-group">
	<input type="text" name="quantity_range[]" value="<?php echo $qrange[$i]; ?>" class="form-control numeric_range" id="quantity_range" placeholder="Enter Quantity" autocomplete="off">      
</div></div> 							 
<div class="col-sm-4 col-md-4"><div class="form-group">
	<input type="text" name="price_range[]" value="<?php echo $price_range[$i]; ?>" class="form-control unsigned_float" id="price_range" placeholder="Enter price" autocomplete="off">
	</div></div> 
<?php if($i!=0){ ?>	
<div class="col-sm-12 col-md-12"><button type="button" name="remove" id="<?php echo $i; ?>" class="btn btn-danger btn_remove">X</button></div>
<?php } ?>
</div> 	
<?php }}else{ ?>								
<div class="row">
    <div class="col-sm-4 col-md-4"> <div class="form-group">
	    <input type="text" name="quantity_range[]" value="" class="form-control numeric_range" id="quantity_range" placeholder="Enter Quantity" autocomplete="off">      
    </div>
</div> 							 
    <div class="col-sm-4 col-md-4"><div class="form-group">
	    <input type="text" name="price_range[]" value="" class="form-control unsigned_float" id="price_range" placeholder="Enter price" autocomplete="off">
	</div>
</div> 
</div> 	
<?php } ?></div>  								
</div>
<div class="form-group row">   
<div class="col-sm-3"></div>
<div class="col-sm-6">
<button type="button" name="add" id="add" class="btn btn-success">Add More</button>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){      
  var i=1;  

  $('#add').click(function(){  
	   i++;             
	   $('#dynamic_field').append('<div class="row" id="row'+i+'"> <div class="col-sm-4 col-md-4"><div class="form-group"><input type="text" class="form-control"  placeholder="Enter quantity " name="quantity_range[]" autocomplete="off"></div></div> <div class="col-sm-4 col-md-4"><div class="form-group"><input type="text" class="form-control unsigned_float" id="price_range" placeholder="Enter Price" name="price_range[]" autocomplete="off"></div></div> <div class="col-sm-2 col-md-2"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div></div>');
 });
 
 $(document).on('click', '.btn_remove', function(){  
	   var button_id = $(this).attr("id"); 
	   var res = confirm('Are You Sure You Want To Delete This?');
	   if(res==true){
	   $('#row'+button_id+'').remove();  
	   $('#'+button_id+'').remove();  
	   }
  });  

});  
</script>
<hr>

</div>
    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">

<div class="form-group row">
<label for="inputEmail3" class="col-sm-3 col-form-label">Weight (kg)</label>
<div class="col-sm-6">
	<input type="text" name="weight" value="<?= isset($weight) ? $weight : '' ?>" class="form-control wc_input_decimal unsigned_float" id="product_weight" placeholder="Weight">
</div>
<div class="col-sm-3">
	<i class="fa fa-question-circle ttc" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Weight in decimal form"></i>
</div>
</div>
<div class="form-group row">
<label for="inputEmail3" class="col-sm-3 col-form-label">Dimensions (cm)</label>
<div class="col-sm-6 row pr-0">
<div class="col-sm-4 pr-0">
	<input type="text" name="length" value="<?= isset($length) ? $length : '' ?>" class="form-control wc_input_decimal unsigned_float" id="product_length" placeholder="Length">
</div>

<div class="col-sm-4 pr-0">
	<input type="text" name="width" value="<?= isset($width) ? $width : '' ?>" class="form-control wc_input_decimal unsigned_float" id="product_width" placeholder="Width">
</div>
<div class="col-sm-4 pr-0">
	<input type="text" name="height" value="<?= isset($height) ? $height : '' ?>" class="form-control wc_input_decimal unsigned_float" id="product_height" placeholder="Height">
</div>
</div>
<div class="col-sm-3">
	<i class="fa fa-question-circle ttc pl-4" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="LxWxH in decimal form"></i>
</div>
</div>
<hr>
<div class="form-group row mt-3">
<label for="inputEmail3" class="col-sm-3 col-form-label">Shipping</label>
<div class="col-sm-6">
<select id="shipping_id" name="shipping_id" class="form-control shipping_combo" style="width:247.5px">
    <?php
        foreach($shipping_obj as $row){
            $shipping_seleted = (isset($shipping_id) && $shipping_id == $row->shipping_id) ? 'Selected' : '';
            echo "<option value=\"$row->shipping_id\" $shipping_seleted>$row->name</option>";
        }
    ?>
</select>
</div>
<div class="col-sm-3">
<i class="fa fa-question-circle ttc" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Shipping classes are used by certain shipping methoods to group similar products."></i>
</div>
</div>
<hr>

</div>
<div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
<div class="tab-pane fade" id="v-pills-attributes" role="tabpanel" aria-labelledby="v-pills-attributes-tab">

<div class="form-group row mt-3">
	<?php //echo "<pre>"; print_r($categories); echo "</pre><br>"; ?>
	<?php //echo "<br><pre>"; print_r($all_attr); echo "</pre>"; ?>
	<div class="col-sm-6"> 
		<select id="attr_class" name="attr_class" style="width:250px;" class="form-control attribute_combo">
				<option></option>
		   <?php if(!empty($all_data_attr)) { foreach($all_data_attr as $key=>$val){ ?>
				<option value="<?php echo $val->attribute_id; ?>"><?php echo $val->name; ?></option>
		   <?php } } ?>    
		</select>
	</div>
	<div class="col-sm-2"><a href="javascript:void(0);"class="btn btn-primary" id="attribute_id">ADD</a></div>
        
</div>
<hr>
<?php 


#echo "<pre>"; print_r($attributes_ids); echo "</pre>";
#echo "<pre>"; print_r($all_attr); echo "</pre>";exit;

if(isset($all_iterm)){
	
foreach($all_iterm as $kk=>$vall){
	if(isset($all_attr[$kk])){
#$attr_name = $this->Attribute_model->get_attr($kk);
?>	
	<div class="form-group row" id="attr-<?php echo $kk; ?>" >
	<label for="Attribute-Colour" class="col-sm-2 col-form-label"><?php echo $all_attr[$kk] ?></label>
	<div class="col-sm-8"><select id="attribute_item_<?php echo $kk; ?>" name="attribute_item[]" class="form-control attribute_item" multiple>     
	 
	 <?php foreach($vall as $k2=>$val2){
			$selected = isset($attributes_ids[$val2->attribute_item_id]) ? 'selected' : '';
		 ?>
	 <option value="<?php echo $val2->attribute_item_id; ?>" <?= $selected ?>><?php echo $val2->name; ?></option> 
	 <?php } ?>
	 
	</select></div><div class="col-sm-2 col-md-2"><button type="button" name="remove" id="<?php echo $kk; ?>" class="btn btn-danger attr_remove">X</button></div>
	</div>
	
<?php }}
}
?>

<div id="attributes_divs">&nbsp;</div>
	
</div>
<div class="tab-pane fade" id="v-pills-advanced" role="tabpanel" aria-labelledby="v-pills-advanced-tab">

<div class="form-group row mt-3">
	<?php //echo "<pre>"; print_r($categories); echo "</pre><br>"; ?>
	<?php //echo "<br><pre>"; print_r($all_vari); echo "</pre>"; ?>
	<div class="col-sm-6"> 
		<select id="variations_class" name="variations_class" class="form-control jp variation_combo">
				<option></option>
		   <?php if(!empty($all_vari)) { foreach($all_vari as $key=>$val){ ?>
				<option value="<?php echo $val->attribute_item_id; ?>"><?php echo $val->name; ?></option>
		   <?php } } ?>    
		</select>
	</div>
	<div class="col-sm-2"><a href="javascript:void(0);"class="btn btn-primary" id="variations_id">ADD</a></div>
        
</div>
    
<p style="color:#bb77ae;">Before you can add a variation you need to add some variation attributes on the Attributes tab.</p>
<?php //echo "<pre>"; print_r($all_vari_term); echo "</pre>";die;  ?>

<div id="variations_data">
	<?php if(isset($all_vari_term)) : foreach($all_vari_term as $k=>$v){ 
		//echo "<pre>"; print_r($v); echo "</pre>";die;
		$va_id = isset($v->va_id) ? $v->va_id:'';
		$attribute_item_id = isset($v->attribute_item_id) ? $v->attribute_item_id:'';
		$product_id = isset($v->product_id) ? $v->product_id:'';
		$_sale_price = isset($v->_sale_price) ? $v->_sale_price:'';
		$_regular_price = isset($v->_regular_price) ? $v->_regular_price:'';
		$_sku = isset($v->_sku) ? $v->_sku:'';
		$_stock = isset($v->_stock) ? $v->_stock:'';
		$_thumbnail = isset($v->name) ? $v->_thumbnail_id:'';
		$attribute_id = isset($v->attribute_id) ? $v->attribute_id:'';
		$item_name = isset($v->name) ? $v->name:'';
		
	?>
	<div class="border p-2 sadow" style="background: #fbfbfb;" id="variation-<?php echo $va_id; ?>">
	<div class="form-group row">
	<label for="variations-Black" class="col-sm-3 col-form-label"><?php echo '#'.$va_id .''.$item_name ?></label>
	<div class="col-sm-7 col-md-7">Upload image<input type="hidden" name="attr_itemid[]" value="<?= $attribute_item_id ?>">
	<input type="file" name="_thumbnail_id[]" id="_thumbnail_id_<?php echo $k; ?>" class="form-control" value="" <?= ($_thumbnail) ? '' : 'required' ?>>
	<img src="<?php echo base_url().'/assets/uploads/'.$_thumbnail; ?>" width="100" height="100">
	</div><div class="col-sm-2 col-md-2"><button type="button" name="variation-remove" data-postid="<?php echo $product_id; ?>" data-id="<?php echo $attribute_item_id; ?>" class="btn btn-danger btn_remove_variation p-0"  style="padding:0px 7px !important;">X</button></div>
	</div>

    <div class="row mb-2"> 
		<div class="col-sm-6 col-md-6"><label for="regular_price" class="col-sm-12 col-form-label">Regular price</label>
		<input type="text" name="_regular_price[]" id="_regular_price_<?php echo $k; ?>" class="form-control" value="<?php echo $_regular_price; ?>" required=""></div>
		<div class="col-sm-6 col-md-6"><label for="Regular price" class="col-sm-12 col-form-label">Sale price</label>
		<input type="text" name="_sale_price[]" id="_sale_price_<?php echo $k; ?>" class="form-control" value="<?php echo $_sale_price; ?>" placeholder=""></div>
		<div class="col-sm-6 col-md-6"><label for="sku" class="col-sm-12 col-form-label">Sku</label>
		<input type="text" name="_sku[]" id="_sku_<?php echo $k; ?>" class="form-control"  style="" value="<?php echo $_sku; ?>" placeholder=""></div>
		<div class="col-sm-6 col-md-6"><label for="stock" class="col-sm-12 col-form-label">Stock</label>
		<input type="number" name="_stock[]" id="_stock_<?php echo $k; ?>" class="form-control" style="" value="<?php echo $_stock; ?>" placeholder=""></div>
	
	</div></div>
	<hr>
	<?php } endif; ?>



<div id="variations_divs">&nbsp;</div>


</div>
<div class="tab-pane fade" id="v-pills-get" role="tabpanel" aria-labelledby="v-pills-get-tab"></div>
</div>

</div>
</div>

</div>
</div>
</div>
</div></div>
<div class="col-sm-3" style="position:relative;">
<div style="position:sticky;top:100px;">
<input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />
<button type="button" class="btn btn-light btn_back mb-2 w-100">Back</button>
<button type="submit" class="btn btn-primary  w-100">Submit</button>
</div>
</div>

</div>
</div>
    

<?php echo form_close() ?> 	

<style>
#formdiv {  text-align: center;}
#file{  color: green;  padding: 5px;  border: 1px dashed #123456;  background-color: #f9ffe5;}
#img{  width: 17px;  border: none;  height: 17px;  margin-left: -20px;  margin-bottom: 191px;}
.upload{ width: 100%;  height: 30px;}
.abcd{  text-align: center;  position: relative;}
.abcd img{  height: 200px;  width: 200px;  padding: 5px;  border: 1px solid rgb(232, 222, 189);}
.delete{  color: red;  font-weight: bold;  position: absolute;  top: 0;  cursor: pointer }
.diss{ display:block !important;}
</style>

<script>
/*
$('.fancy_date').daterangepicker({
    autoUpdateInput: false,
    minDate: moment().format('DD-MM-YYYY'),
    startDate: nearestMinutes(0),
    timePickerIncrement: 15,
    singleDatePicker: true,
    showDropdowns: true,
    timePicker: true,
    timePicker24Hour: true,
    drops: 'down',
    locale: { cancelLabel: 'Clear', format: 'YYYY-MM-DD H:mm' }
});

$('.fancy_date').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD H:mm'));
    $(this).parsley().reset();
});

$('.fancy_date').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
    $(this).parsley().validate()
});

*/

$(document).ready(function() {
//    $('select').select2({allowClear: true, placeholder: "Attributes"});
    $('.category_combo').select2({allowClear: true, placeholder: "Category"});
    $('.brand_combo').select2({allowClear: true, placeholder: "Brand"});
    $('.status_combo').select2({allowClear: true, placeholder: "Status"});
    $('.supplier_combo').select2({allowClear: true, placeholder: "Supplier"});
    $('.tax_combo').select2({allowClear: true, placeholder: "Tax"});
    $('.shipping_combo').select2({allowClear: true, placeholder: "Shipping"});
    $('.attribute_combo').select2({allowClear: true, placeholder: "Attributes"});
    $('.variation_combo').select2({allowClear: true, placeholder: "Variations"});
    $('.attribute_item').select2({allowClear: true, placeholder: "Attribute Item"});
});

function nearestMinutes(mnt){
    time = moment();
    round_interval = 15;
    intervals = Math.ceil(time.minutes() / round_interval);
    minutes = intervals * round_interval;
    time.minutes(minutes);
    return time.add(mnt,'minutes').format('YYYY-MM-DD H:mm');
}


function validatePrices()
{
  var regular_price = parseFloat( $( "#regular_price" ).val() );
  
  var sale_price = parseFloat( $( "#sale_price" ).val() );
  if ( !isNaN( regular_price )  && !isNaN( sale_price)  )
  {
    if ( regular_price <= sale_price )//if greater than or equal to then show error alert
    {
		document.getElementById("error").innerHTML = 'Less than regular price';//parsley-required
		$("#error").addClass("parsley-required");
		$("#sale_price").addClass("parsley-err");
		return false;
    }
  }
  /*else
  {
       alert( "price from and price to should be valid numbers " );
       return false;
  }*/
}

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
    $('[id^=stock]').keypress(validateNumber);
});


$('#add_more').click(function() {
      "use strict";
      $(this).before($("<div/>", {
        id: 'filediv'
      }).fadeIn('slow').append(
        $("<input/>", {
          name: 'file[]',
          type: 'file',
          id: 'file',
          multiple: 'multiple',
          accept: 'image/*'
        })
      ));
    });

    $('#upload').click(function(e) {
      "use strict";
      e.preventDefault();

      if (window.filesToUpload.length === 0 || typeof window.filesToUpload === "undefined") {
        alert("No files are selected.");
        return false;
      }
        
    });

    function deletePreview(ele, i) {
      "use strict";
      try {
        $(ele).parent().remove();
        window.filesToUpload.splice(i, 1);
      } catch (e) {
        console.log(e.message);
      }
    }

    $("#file").on('change', function() {
      "use strict";


      window.filesToUpload = [];

      if (this.files.length >= 1) {
        $("[id^=previewImg]").remove();
        $.each(this.files, function(i, img) {
          var reader = new FileReader(),
            newElement = $("<div id='previewImg" + i + "' class='abcd'><img /></div>"),
            deleteBtn = $("<span class='delete' onClick='deletePreview(this, " + i + ")'>delete</span>").prependTo(newElement),
            preview = newElement.find("img");

          reader.onloadend = function() {
            preview.attr("src", reader.result);
            preview.attr("alt", img.name);
          };

          try {
            window.filesToUpload.push(document.getElementById("file").files[i]);
          } catch (e) {
            console.log(e.message);
          }

          if (img) {
            reader.readAsDataURL(img);
          } else {
            preview.src = "";
          }

          newElement.appendTo("#filediv");
        });
      }
    });



</script>

<script>
$(document).on('click','.btn-delete', function(e){
	//alert('dd');
    var uid=$(this).attr('data-id');  
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
                url         :   '<?php echo base_url();?>admin/Product/delimg',
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
		 
                        swal('User Delete Successfully.'); 
                        location.reload(true);
				   } 
			   
				}
		});
    }
	
//variation delete query
$(document).on('click','.btn_remove_variation', function(e){

   // var uid=$(this).attr('data-id'); 
	var uid = $(this).attr("data-id");
	var postid = $(this).attr("data-postid");	
	//alert(uid);	
	delete_variation_post(uid,postid);
} );

function delete_variation_post(id,postid)
    {
        var postData = {};
		var csrf_name = "<?= $csrf->name; ?>";
		var csrf_value = "<?= $csrf->hash; ?>";
		postData[csrf_name] =  csrf_value;
        postData.id = id;
		postData.postid = postid;
		
		
        $.ajax({
                url         :   '<?php echo base_url();?>admin/Product/delete_variation',
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
		 
                        swal('User Delete Successfully.'); 
                        location.reload(true);
				   } 
			   
				}
		});
    }
	
</script>


<script>
$(document).on('click','#attribute_id', function(e){
	var obj = $('#attr_class');
	var attr = $('#attr_class').val();
    if(attr){
	    attr_post(obj.val());
	    e.stopPropagation();
    }
} );

var attr_name = '';
var attr_key = '';

function attr_post(id)
{
	var postData = {};
	var csrf_name = "<?= $csrf->name; ?>";
	var csrf_value = "<?= $csrf->hash; ?>";
	postData[csrf_name] =  csrf_value;
	postData.id = id;


	$.ajax({
			url         :   '<?php echo base_url();?>admin/Product/get_attr',
			type        :   'post',
			//		    enctype	    :   'multipart/form-data',
			dataType    :   "json",  
			data        :   postData,
			success     :   function(response){
			response = eval(response);
			if(response.status == 'success')
			{
				var data = response.data;
				//alert(JSON.stringify(data));
				var optionHtml = '';
				
				$.each( data, function( key, value ) {
					optionHtml += '<option value='+key+'>'+value+'</option>';
				});
				//var attr_name = $("#attr_class option:selected").text();
				//var attr_key = $("#attr_class option:selected").val();
				var append_html =   '<div class="form-group row"><label for="Attribute-'+attr_name+'" class="col-sm-2 col-form-label">'+attr_name+'</label><div class="col-sm-8"><select id="attribute_item_'+attr_key+'" name="attribute_item[]" class="form-control select2ref" multiple="" tabindex="-1" aria-hidden="true">'+optionHtml+'</select></div></div>';
				//alert(append_html);
				$('#attributes_divs').append(append_html);	
				$(".select2ref").select2();     
			} 
		}
	});
}
</script>

<script>
$(document).on('click','#variations_id', function(e){
	//alert('dd');
	var obj2 = $('#variations_class');
	//alert(obj2);
    //var uid=$(this).attr('data-id');  
	variations_post(obj2.val());
	 e.stopPropagation();
} );

var attr_name = '';
var attr_key = '';
function variations_post(id)
{
	var postData = {};
	var csrf_name = "<?= $csrf->name; ?>";
	var csrf_value = "<?= $csrf->hash; ?>";
	postData[csrf_name] =  csrf_value;
	postData.id = id;


	$.ajax({
            url         :   '<?php echo base_url();?>admin/Product/get_vitem_ajax',
            type        :   'post',
            enctype	    :   'multipart/form-data',
            dataType    :   "json",  
            data        :   postData,
            success     :   function(response){
            response = eval(response);
            if(response.status == 'success')
            {
                    var data = response.data;
                    //alert(JSON.stringify(data));
                    var optionHtml = '';

                    $.each( data, function( key, value ) {
                            optionHtml += '<option value='+key+'>'+value+'</option>';
                    });
                    //attr_name = $("#variations_class option:selected").text();
                    //attr_key = $("#variations_class option:selected").val();

                    var variations_html =   '<div class="border p-2 sadow" style="background: #fbfbfb;"><div class="form-group row pp"><label for="variations-'+attr_name+'" class="col-sm-3 col-form-label">'+attr_name+'</label><div class="col-sm-7 col-md-7">Upload image<input type="hidden" name="attr_itemid[]" value='+attr_key+'>'+ '<input type="file" name="_thumbnail_id[]" id="_thumbnail_id" class="form-control" value="" required></div>'+
                    '<div class="col-sm-2 col-md-2"><button type="button" name="remove" id="<?php echo "#"; ?>" class="btn btn-danger btn_remove p-0" style="padding:0px 7px !important;">X</button></div></div>'+
                    '<div class="row mb-2">'+
					
					'<div class="col-sm-6 col-md-6"><label for="regular_price" class="col-sm-12 col-form-label">Regular price</label><input type="text" name="_regular_price[]" id="_regular_price" class="form-control" value="" required></div>'+
					'<div class="col-sm-6 col-md-6"><label for="Regular price" class="col-sm-12 col-form-label">Sale price</label><input type="text" name="_sale_price[]" id="_sale_price" class="form-control" value="" placeholder=""></div>'+
                    '<div class="col-sm-6 col-md-6"><label for="sku" class="col-sm-12 col-form-label">Sku</label><input type="text" name="_sku[]" id="_sku" class="form-control" style="" value="" placeholder=""></div>'+
					'<div class="col-sm-6 col-md-6"><label for="stock" class="col-sm-12 col-form-label">Stock</label><input type="number" name="_stock[]" id="_stock" class="form-control" style="" value="" placeholder=""></div>'+
                    '</div></div></div><hr >'; 

                    //alert(variations_html);
                    $('#variations_divs').append(variations_html);	
                    $(".select2variations").select2();     
            } 
        }
	});
}

$(document).on('click','#attribute_id', function(e){
//$("#variations_class").change( function(e){
  e.preventDefault();
  //var val = $(this).val();
   
  attr_key = $('#attr_class option:selected').val();
  attr_name = $('#attr_class option:selected').text();
  
  $("#attr_class option[value='"+attr_key+"']").remove(); 
});

$(document).on('click','#variations_id', function(e){
//$("#variations_class").change( function(e){
  e.preventDefault();
  //var val = $(this).val();
   
  attr_key = $('#variations_class option:selected').val();
  attr_name = $('#variations_class option:selected').text();
  
  $("#variations_class option[value='"+attr_key+"']").remove();
});

$(document).on('click', '.attr_remove', function(){  
	   var button_id = $(this).attr("id"); 
	   var res = confirm('Are You Sure You Want To Delete This?');
	   if(res==true){
	   $('#attr-'+button_id+'').remove();  
	   $('#'+button_id+'').remove();  
	   }
});
/*  
$(document).on('click', '.btn_remove_variation', function(){  
	   var button_id = $(this).attr("id"); 
	   var res = confirm('Are You Sure You Want To Delete This?');
	   if(res==true){
	   $('#variation-'+button_id+'').remove();  
	   $('#'+button_id+'').remove();  
	   } 
  });  
  */  

$('.fancy_date').daterangepicker({
    autoUpdateInput: false,
    minDate: moment().format('YYYY-MM-DD H:mm'),
    startDate: nearestMinutes(0),
    timePickerIncrement: 15,
    singleDatePicker: true,
    showDropdowns: true,
    timePicker: true,
    timePicker24Hour: true,
    drops: 'up',
    locale: { cancelLabel: 'Clear', format: 'YYYY-MM-DD H:mm' }
});

$('.fancy_date').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD H:mm'));
    $(this).parsley().reset();
});

$('.fancy_date').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
    $(this).parsley().validate()
});

function nearestMinutes(mnt){
    time = moment();
    round_interval = 15;
    intervals = Math.ceil(time.minutes() / round_interval);
    minutes = intervals * round_interval;
    time.minutes(minutes);
    return time.add(mnt,'minutes').format('YYYY-MM-DD H:mm');
}

$(document).ready(function() {
    window.ParsleyValidator.addValidator('myvalidator',
    function (value) {
        var sdate = $('#sale_price_dates_from').val();
        var edate = $('#sale_price_dates_to').val();
        var error = 0;
        if(sdate && edate){
            var sfepoch = Date.parse(sdate)/1000;
            var stepoch = Date.parse(edate)/1000;

            if(sfepoch > stepoch){
                error = 1;
                   // return false;
            }else{
                   // return true;
            }
        }else{
            //    return false;
        }
        
        if(error == 1){
            return false;
        }else{
            return true;
        }
    }, 32)

    .addMessage('en', 'myvalidator', 'Start Date can\'t be greater than End Date');
});
</script>
