<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row"><div class="col-lg-6"> <h3>Supplier</h3> </div>  <?= $breadcrumbs ?> </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">    
                    <div class="card-body">
                        <div class="topAction-btn"><a href="/<?= $TYPE?>/supplier/add" class="btn btn-primary addNew" title="Add New" data-toggle="tooltip" data-placement="top" data-animation="false"><i class="fa fa-plus"></i></a>&nbsp;<a href="javascript:void(0)" class="btn btn-primary addNew" title="Filter" data-toggle="tooltip" data-placement="top" data-animation="false"><i class="fa fa-filter"></i></a></div>
                        <div class="dt-ext table-responsive">
                            <div id="new-cons_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="table" class="display dataTable table-striped table-bordered table-hover custom-table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Address</th>
													<th>City</th>
													<th>Status</th>
                                                    <th width="35px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var table;
$(document).ready(function() {
	
    dataTable();
	
});

function dataTable()
{
    var postData = {"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
    var filterData = {};
    postData.filter = filterData;
    table = $('#table').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "responsive": true,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
        "orderCellsTop": true,
        "destroy": true,
		//"order":[],
        "pageLength": <?= $page_count ?>,
        //Load data for the table's content from an Ajax source
        "ajax": {
            "url": "/<?= $TYPE; ?>/supplier/index_ajax_post",
            "data": postData,
            "type": "POST",
            "dataType": 'json',
            complete: function () {
               $('[data-toggle="tooltip"]').tooltip();
            },
        },
        "language": {
           "paginate": {
           "next": '&raquo;', // or '→'
           "previous": '&laquo;' // or '←'
           }
        },
        "dom": '<"top"i>t<"bottom"flp><"clear">',
        "columnDefs": [ {
            "targets": -1,
            "data": null, 
            "render": function ( data, type, row ) {
var actionTemplate = '<button type="button" class="btn btn-primary btn-sm" data-toggle="popover" data-placement="top" data-html="true" data-content=\''+
'<button title="'+row.status+'" data-toggle="tooltip" data-placement="top" data-animation="false" data-html="true" class="btn custom-popover-btn btn-status" type="button" data-status="'+row.status+'" data-id="'+row.supplier_id+'"><i class="fa fa fa-toggle-on"></i></button>'+
'<button type="button" title="Edit" data-toggle="tooltip" class="btn custom-popover-btn btn-edit" data-id="'+row.supplier_id+'"><i class="fa fa-pencil-square-o"></i></button>'+
'<button type="button" title="View" data-toggle="tooltip" class="btn custom-popover-btn btn-view" data-id="'+row.supplier_id+'"><i class="fa fa-eye"></i></button>'+ 
'\''+
'><i class="fa fa-cog"></i></button>';
                return actionTemplate;
            },
            "defaultContent": ''
            },
         ],
        "columns": [
				{"data": "cname"},
			    {"data": "email"},
				{"data": "mobile"},
                {"data": "address"},                           
			    {"data": "city"},				   
			    {"data": "status"},
                {"data": "action"},
          ]
    } );
}

//update query
$(document).on('click','.btn-edit', function(e){
    var uid=$(this).attr('data-id');
    var url="/<?php echo $TYPE ?>/supplier/update/"+uid+"";
    url_new_tab(e,url);
} );

function url_new_tab(e,url)
{
    if(e.ctrlKey){
        window.open(url);
    }else{
        $(location).attr('href', url);
    }
}

$(document).on('click','.btn-primary', function(e){
    $('[data-toggle="popover"]').popover();
    $('[data-toggle="tooltip"]').tooltip();
});

//delete query
$(document).on('click','.btn-delete', function(e){
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
                url         :   '<?php echo base_url();?>admin/supplier/del',
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
		 
                        swal('Supplier Delete Successfully.'); 
                        location.reload(true);
				   } 
			   
				}
		});
    }
//Change status	
$(document).on('click','.btn-status', function(e){
    var uid=$(this).attr('data-id'); 
	var status=$(this).attr('data-status');  	
	//alert(status);
	status_change(uid,status);
} );

function status_change(id,status)
    {
        var postData = {};
		var csrf_name = "<?= $csrf->name; ?>";
		var csrf_value = "<?= $csrf->hash; ?>";
		postData[csrf_name] =  csrf_value;
        postData.id = id;
		postData.status = status;
		
		
        $.ajax({
                url         :   '<?php echo base_url();?>admin/supplier/status_change',
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
		 
                        swal('Supplier status changed.'); 
                        location.reload(true);
				   } 
			   
				}
		});
    }

//redirect to profile view page
$(document).on('click','.btn-view', function(e){
    var uid=$(this).attr('data-id');  
	var base_url = '<?php base_url() ?>';
	window.location.href = base_url+"/admin/supplier/view/"+uid;	
	//view_order(uid);
} );

	
</script>
