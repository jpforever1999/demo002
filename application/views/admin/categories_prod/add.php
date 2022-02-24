<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <h3>New Category</h3>
                </div>
                <?php $breadcrumbs ?>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="edit-profile">
            <div class="row ">
                <div class="col-lg-12">               
				 <form role="form" action="<?php echo site_url('admin/categories_prod/add')?>" method="post" enctype="multipart/form-data" > 
					<div class="card-body">
                        <div class="row">
						
                            <div class="col-sm-6 col-md-4">
							 
                                <div class="form-group">
								<label for="category_name">Category Name</label>
								<input type="text" name="name" class="form-control" id="category_name" placeholder="Name" required>
								 <?php echo message_box(validation_errors(),'danger'); ?>
								</div>
                            </div>
							 <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                <label for="category_name">Icon</label>
                                <input type="file" name="icon" class="form-control" id="icon"> 
                                       
								</div>
                            </div>
							<div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                <label for="category_name">Image Name</label>
                                <input type="file" name="thumbnail_image" class="form-control" id="thumbnail_image"> 
               
								</div>
                            </div>
						   <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                <label for="parent_id">Parent</label>
                                <select name="parent_id" id="parent_id" class="form-control">
                                <option></option>
                                <?php
                                    $this->Category_prod_model->categoryTree();
                                    #echo form_dropdown('parent_id',$cat_array,isset($category['parent_id']) ? $category['parent_id'] : '',array('id' => 'parent_id', 'class' => 'form-control'));
                                ?>
                                </select>
							    </div>
							</div>
						   <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label for="category_status">Status</label>
                                    <?php $category_status = array("1" => "Active", "0" => "Inactive");
                                        echo form_dropdown('status',$category_status,null,array('id' => 'status', 'class' => 'form-control'));
                                    ?>
							    </div>
							</div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
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
