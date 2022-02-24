<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <h3><?php if($type !='') { echo "Update"; }else{ echo "Add "; } ?> <?=$banner_type ?></h3>
                </div>
                <?= $breadcrumbs ?>
            </div>
        </div>
    </div>
    <div class="container-fluid">
            <div class="row ">
                <div class="col-sm-12">
                    <div class="card"> 
                        <?php if ((isset($message) && $message['error']!='') || validation_errors()!='') { ?>
                          <div class="alert alert-danger">
                              <?= validation_errors();
                                  if($message['error']!=''){
                                      echo $message['error'];
                                  }
                              ?>
                          </div>
                          <?php } ?>
                          <?php if($this->session->flashdata('message')){?>
                          <div class="alert alert-success">
                              <?= $this->session->flashdata('message')?>
                          </div>
                          <?php } ?>  
                        <?php if($type==''){?>        
    				    <form role="form" action="<?php echo site_url('admin/banner/add/').$widget_id; ?>" method="post" enctype="multipart/form-data" > 
                        <?php }else{ ?>
                        <form role="form" action="<?php echo site_url('admin/banner/update/').$banner_id ?>" method="post" enctype="multipart/form-data" > 
                        <?php } ?>
        					<div class="card-body">
                                <input type="hidden" name="type" value="<?= isset($type)?$type:''?>">
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                        <label for="category_name">Banner Heading</label>
                                        <input type="text" name="title" class="form-control" id="Bannertitle" placeholder="Banner Heading" value="<?= isset($title)?$title:''?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="category_name">URL</label>
                                            <input type="text" placeholder="URL" name="url" class="form-control" id="url" value="<?= isset($url)?$url:''?>" />
                                        </div>
                                    </div>
        							 <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="category_name">Banner Image</label>
                                            <input type="file" name="banner_image" class="form-control" id="Image" value="<?= isset($banner_image)?$banner_image:''?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="category_name">Banner Height</label>
                                            <input type="text" placeholder="Banner Height in px" name="height" class="form-control" id="BannerHeight" value="<?= isset($height)?$height:''?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="category_name">Banner Width</label>
                                            <input type="text" placeholder="Banner Width in px" name="width" class="form-control" id="Bannerwidth" value="<?= isset($width)?$width:''?>" />
                                        </div>
                                    </div>
                                    <?php if($type!=''){?>
                                    <div class="col-sm-6 col-md-4">
                                           <img src="<?php echo base_url().'assets/home_page_banner/'.$banner_image; ?>" width="100"  height="100" />
                                        </div>
                                    <?php }?>
                                    <div class="col-sm-6 col-md-2">
                                       <div class="form-group">
                                        <label for="category_status">Status</label>
                                            <select name="enabled" id="enabled" class="form-control"> 
                                                <option value="1" <?php if(isset($enabled) && $enabled == 1){ echo 'selected=selected'; }?>>Active</option>
                                                <option value="0" <?php if(isset($enabled) && $enabled == 0){ echo 'selected=selected'; }?>>Inactive</option>
                                            </select>
            							</div>
                                    </div>
        							
                                </div>
                            </div>
                            <div class="card-footer text-right">
        						<input type="hidden" name="<?= $csrf->name; ?>" value="<?= $csrf->hash; ?>" />
                                <button type="button" class="btn btn-light btn_back">Back</button>
                                <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php if($type==''){ echo 'Submit'; }else{ echo 'Update';}?></button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</div>
