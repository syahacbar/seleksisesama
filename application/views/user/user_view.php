<!-- Datatable style -->
<link href="<?php echo base_url('public/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('public/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('public/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">

<style>
    th, td { white-space: normal; } 
    div.dataTables_wrapper { 
        margin: 0 auto;
    }
    tr { height: 10px;  }
    table{
    table-layout: fixed; 
    }
    th.dt-center, td.dt-center { text-align: center; }
</style>      

  <div class="box">
   <div class="box-header">
     <h3 class="box-title">Master Data User</h3>
     <div class="pull-right">
        <button class="btn btn-sm btn-success" onclick="add_record()"><i class="glyphicon glyphicon-plus"></i> Tambah Data</button>
        <button class="btn btn-sm btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        
     </div>
   </div>
        <div class="box-body table-responsive">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" style="font-size:12px;">
            <thead>
                <tr>
                    <th width="20px">No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Last Login</th>
                    <th>IP Address</th>
                    <th>Fakultas</th>
                    <th>Status</th>
                    <th>On/Off</th>
                    <th style="width:200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
 
           
        </table>
        </div>
 
   <!-- /.box-body -->
 </div>
 <!-- /.box --> 

<script src="<?php echo base_url('public/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('public/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('public/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('public/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<script type="text/javascript">
 
var save_method; //for save method string
var table;

$(document).ready(function() {
    $("#mndatauser").addClass('active');
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('user/ajax_list')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [0,-1,6,7], 
            "orderable": false, 
            "className": 'dt-center',
        },
        { 
            "targets": [5], 
            "width": 200,
        },
        { 
            "targets": [6,7], 
            "width": 20,
        },
        ],
 
    });
 
    
 
});

 
 function add_record()
{
    save_method = 'add';
    $('#form-user')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $('#modal_form').modal('show'); 
    $('.modal-title').text('Tambah User'); 
    $("#error_firstname").html('');
    $("#error_lastname").html('');
    $("#error_idfakultas").html('');
    $("#error_username").html('');
    $("#error_email").html('');
    $("#error_password").html('');
    $("#error_confirmpassword").html('');
    $("#div_password").show();
    $("#div_password_confirm").show();
} 

function edit_record(id)
{
    save_method = 'update';
    $('#form-user')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $("#error_firstname").html('');
    $("#error_lastname").html('');
    $("#error_idfakultas").html('');
    $("#error_username").html(''); 
    $("#error_email").html('');
    $("#error_password").html('');
    $("#error_confirmpassword").html('');
    $("#div_password").hide();
    $("#div_password_confirm").hide();
 
    //Ajax Load data from ajax  
    $.ajax({
        url : "<?php echo base_url('user/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('[name="first_name"]').val(data.first_name);
            $('[name="last_name"]').val(data.last_name);
            $('[name="idfakultas"]').val(data.idfakultas);
            $('[name="username"]').val(data.username);
            $('[name="email"]').val(data.email);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Program Studi'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

 
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $("#error_firstname").html('');
    $("#error_lastname").html('');
    $("#error_idfakultas").html('');
    $("#error_username").html('');
    $("#error_email").html('');
    $("#error_password").html('');
    $("#error_confirmpassword").html('');
    $('#btnSave').text('saving...');
    $('#btnSave').attr('disabled',true); 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('user/ajax_add')?>";
    } else {
        url = "<?php echo site_url('user/ajax_update')?>";
    }
 
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form-user').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            
            if (data.hasil !== "sukses") {
                $("#error_firstname").html(data.error.firstname);
                $("#error_lastname").html(data.error.lastname);
                $("#error_idfakultas").html(data.error.idfakultas);
                $("#error_username").html(data.error.username);
                $("#error_email").html(data.error.email);
                $("#error_password").html(data.error.password);
                $("#error_confirmpassword").html(data.error.confirmpassword);
                $("#error_cekpassword").html(data.error.cekpassword);
            }
 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
 
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
        }
    });
    
}
 
function delete_record(id)
{
    if(confirm('Apakah anda yakin akan menghapus data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo base_url('user/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
    }
}


function reset_login(id){
        $.ajax({
            url : "<?php echo base_url('user/reset_login')?>/"+ id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    
}

 
</script>
 
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Program Studi/h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form-user" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama Depan</label>
                            <div class="col-md-8">
                                <input name="first_name" placeholder="Nama Depan" class="form-control" type="text">
                                <span class="text-danger" id="error_firstname"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama Belakang</label>
                            <div class="col-md-8">
                                <input name="last_name" placeholder="Nama Belakang" class="form-control" type="text">
                                <span class="text-danger" id="error_lastname"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Fakultas</label>
                            <div class="col-md-8">
                            <?php echo form_dropdown('idfakultas', $dd_fakultas, $fakultas_selected,'class="form-control select2"'); ?>
                                <span class="text-danger" id="error_idfakultas"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Username</label>
                            <div class="col-md-8">
                                <input name="username" placeholder="Username" class="form-control" type="text">
                                <span class="text-danger" id="error_username"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Email</label>
                            <div class="col-md-8">
                                <input name="email" placeholder="Email" class="form-control" type="text">
                                <span class="text-danger" id="error_email"></span>
                            </div>
                        </div>
                        <div class="form-group" id="div_password">
                            <label class="control-label col-md-4">Password</label>
                            <div class="col-md-8">
                                <input id="password" name="password" placeholder="Password" class="form-control" type="password">
                                <span class="text-danger" id="error_password"></span>
                            </div>
                        </div>
                        <div class="form-group"  id="div_password_confirm">
                            <label class="control-label col-md-4">Konfirmasi Password</label>
                            <div class="col-md-8">
                                <input id="password_confirm" name="password_confirm" placeholder="Konfirmasi Password" class="form-control" type="password">
                                <span class="text-danger" id="error_confirmpassword"></span><br><span class="text-danger" id="error_cekpassword"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
</body>
</html>