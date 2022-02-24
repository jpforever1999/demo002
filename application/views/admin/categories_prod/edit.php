<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Edit Category</h3>
                </div>
                <?php $breadcrumbs ?>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="edit-profile">
            <div class="row ">
                <div class="col-lg-12">
                   
				 <form role="form" action="<?php echo site_url('admin/categories_prod/update')?>" method="post" enctype="multipart/form-data" >
					<div class="card-body">
						<?php echo $this->session->flashdata('message');?>
						<?php echo validation_errors(); ?>
							
                        <div class="row">
						  <?php echo message_box(validation_errors(),'danger'); ?>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                <label for="category_name">Category Name</label>
                                <input type="text" name="name" class="form-control" id="category_name" placeholder="Name" 
                                       value="<?php echo set_value('name', isset($category['name']) ? $category['name'] : '') ?>" required>
								</div>
                            </div>
							 <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                <label for="Icon_name">Icon</label>
                                <input type="file" name="icon" class="form-control" id="icon" placeholder="icon"> 
								<?php if(isset($category['icon']) && $category['icon']!=''){ ?><img src="<?php echo base_url();?>assets/categories/<?php echo $category['icon']; ?>" width="100" height="100"> <?php } ?>     
								</div>
                            </div>
							<div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                <label for="Thumbnail image">Image Name</label>
                                <input type="file" name="thumbnail_image" class="form-control" id="thumbnail_image" placeholder="Image"> 
								<?php if(isset($category['thumbnail']) && $category['thumbnail'] !='' ){ ?><img src="<?php echo base_url();?>assets/categories/<?php echo $category['thumbnail']; ?>"  width="100" height="100"> <?php } ?>     
								</div>
                            </div>
						   <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                <label for="parent_id">Parent</label>
                                <select name="parent_id" id="parent_id" class="form-control">
                                <option></option>
                                <?php
                                    $this->Category_prod_model->categoryTree(0,'',$category['parent_id']);
                                    #echo form_dropdown('parent_id',$cat_array,isset($category['parent_id']) ? $category['parent_id'] : '',array('id' => 'parent_id', 'class' => 'form-control'));
                                ?>
                                </select>
                                </div>
							</div>
						   <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                <label for="category_status">Status</label>
                                <?php 
                                $category_status = array("0" => "Inactive", "1" => "Active");
                                echo form_dropdown('status',$category_status, isset($category['status']) ? $category['status'] : '',array('id' => 'status', 'class' => 'form-control'));
                                ?>
                                </div> 
                            </div>
														
                        </div>
                    </div>
                    <div class="card-footer text-right">
						<input type="hidden" name="id" value="<?php echo $category['id']?>">
						<input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />
                        <button type="button" class="btn btn-light btn_back">Back</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#parent_id').select2({allowClear: true, placeholder: "Parent"});
    $('#status').select2({allowClear: true, placeholder: "Status"});
});
</script>
