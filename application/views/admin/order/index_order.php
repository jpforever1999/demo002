<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Orders</h3>
                </div>
                <?= $breadcrumbs ?>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                     <?php if ($this->session->flashdata('error')) { ?>
                     <div class="alert alert-danger">
                         <?= $this->session->flashdata('error')?>
                     </div>
                     <?php } ?>

                    <?php if($this->session->flashdata('message')){?>
                    <div class="alert alert-success">
                        <?= $this->session->flashdata('message')?>
                    </div>
                    <?php } ?>

                    <!--<div class="form-group">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalfat" data-whatever="@mdo">Open Model</button>
                    </div>-->

                    <div class="card-body">
                        <!--<div class="topAction-btn">
                            <a href="/<?= $TYPE?>/attributes/add" class="btn btn-primary addNew" title="Add New" data-toggle="tooltip" data-placement="top" data-animation="false"><i class="fa fa-plus"></i></a>-->
                            <!--<a href="javascript:void(0)" class="btn btn-primary addNew" title="Filter" data-toggle="tooltip" data-placement="top" data-animation="false"><i class="fa fa-filter"></i></a>
                        </div>-->
                        <div class="dt-ext table-responsive">
                            <div id="new-cons_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="table" class="display dataTable table-striped table-bordered table-hover custom-table">
                                            <thead>
                                                <tr>
                                                    <th>Order Id</th>
                                                    <th>Customer name</th>
                                                    <!--<th>Product Name</th>-->
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Order Date</th>
                                                    <th>Delivery Date</th>
                                                    <th>Order Status</th>
                                                    <th>Action Status</th>
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
<div class="modal fade" id="exampleModalfat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">hi</div>
                <div class="alert alert-success">hi</div>
                <?php echo form_open("/$TYPE/attributes/", array('id' => 'loginForm', 'autocomplete' => 'off', 'method' => 'POST')) ?>
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control" name="slug" id="slug" value="" placeholder="Slug" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea rows="5" class="form-control" placeholder="Description" name="description"></textarea>
                    </div>
                <?php echo form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
<script>
var table;
$(document).ready(function() {
    dataTable();
});


$(document).ready(function() {

  // Handle click on "Approved" button
    $('#table tbody').on('click', 'a', function (e) {
        var statusval = $(this).attr('data-id');
        var orderid = $(this).attr('data-orderid');

        var postData = {"<?= $csrf->name;?>" : "<?= $csrf->hash; ?>"};
        postData.statusval = statusval;
        postData.orderid = orderid;
        swal({
            title: "Are you sure?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                 $.ajax( {
                     url:'/<?= $TYPE; ?>/order/update-ajax-status/',
                     type:'post',
                     dataType:"json",  
                     data: postData,
                     success:function(data) {
                         table.ajax.reload();
                         swal({
                              title: "Status!",
                              text: "Status Update Successfully",
                              timer: 2000,
                              showConfirmButton: false
                         });
                     }
                 });
            }
        });
    });
  

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
     //   "order":[],
        "pageLength": <?= $page_count ?>,
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "/<?= $TYPE; ?>/order/ajax-get-customer-order",
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
            var toggle = row.status == 'Active' ? "fa fa-toggle-on" : "fa fa-toggle-off";
            var actionTemplate ='<div class="btn-group">'+
                      '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                        'Action'+
                      '</button>'+
                      '<div class="dropdown-menu">'+
                        //'<a class="dropdown-item" href="#" class="Action" data-orderid="'+ row.order_id +'"  data-id="1" >Pending</a>'+
                        '<a class="dropdown-item" href="#" class="Action" data-orderid="'+ row.order_id +'"   data-id="15">Approved</a>'+
                        '<a class="dropdown-item" href="#" class="Action" data-orderid="'+ row.order_id +'"  data-id="2">Shipped</a>'+
                        '<a class="dropdown-item" href="#" class="Action" data-orderid="'+ row.order_id +'"  data-id="4">Refunded</a>'+
                        '<a class="dropdown-item" href="#" class="Action" data-orderid="'+ row.order_id +'"  data-id="5">Cancelled</a>'+
                        '<a class="dropdown-item" href="#" class="Action" data-orderid="'+ row.order_id +'"  data-id="10">Completed</a>'+
                      '</div>'+
                    '</div>';
                return actionTemplate;
            },
            "defaultContent": ''
            },
         ],
        "columns": [
               {"data": "order_id"},
               {"data": "customer_name"},
               //{"data": "customer_name"},
               {"data": "net_total"},
               {"data": "quantity"},
               {"data": "order_date"},
               {"data": "delivery_date"},
               {"data": "status"},
               {"data": "action"},
          ]
    } );
}


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

</script>
