<!-- Datatable style -->
<link href="<?php echo base_url('public/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('public/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('public/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
    

  <div class="box">
   <div class="box-header">
     <h3 class="box-title">Master Data Fakultas</h3>
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
                    <th>Fakultas</th>
                    <th>Dekan</th>
                    <th style="width:130px;">Aksi</th>
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
    $("#mnfakultas").addClass('active');
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('fakultas/ajax_list')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [0,-1], //last column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
});
 
 
 
function add_record()
{
    save_method = 'add';
    $('#form-fakultas')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Data'); // Set Title to Bootstrap modal title
    $("#error_namafakultas").html('');
    $("#error_namadekan").html('');
}
 
function edit_record(id)
{
    save_method = 'update';
    $('#form-fakultas')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $("#error_namafakultas").html('');
    $("#error_namadekan").html('');
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url('fakultas/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="idfakultas"]').val(data.idfakultas);
            $('[name="namafakultas"]').val(data.namafakultas);
            $('[name="namadekan"]').val(data.namadekan);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Fakultas'); // Set title to Bootstrap modal title
 
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
    $("#error_namafakultas").html('');
    $("#error_namadekan").html('');
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url; 
 
    if(save_method == 'add') {
        url = "<?php echo site_url('fakultas/ajax_add')?>";
    } else {
        url = "<?php echo site_url('fakultas/ajax_update')?>";
    }
    
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data : $('#form-fakultas').serialize(),
        dataType: "JSON",
        
        success: function(data)
        {
            if (data.hasil != "sukses") {
                $("#error_namafakultas").html(data.error.namafakultas);
                $("#error_namadekan").html(data.error.namadekan);             
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
            url : "<?php echo base_url('fakultas/ajax_delete')?>/"+id,
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

</script>  
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Fakultas/h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form-fakultas" class="form-horizontal">
                    <input type="hidden" value="" name="idfakultas"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama Fakultas</label>
                            <div class="col-md-8">
                                <input name="namafakultas" placeholder="Nama Fakultas" class="form-control" type="text">
                                <span class="text-danger" id="error_namafakultas"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama Dekan</label>
                            <div class="col-md-8">
                                <input name="namadekan" placeholder="Nama Dekan" class="form-control" type="text">
                                <span class="text-danger" id="error_namadekan"></span>
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