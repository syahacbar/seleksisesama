<!-- Datatable style -->
<link href="<?php echo base_url('public/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('public/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('public/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
 
<style>
    th { white-space: nowrap; } 
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    tr { height: 10px;  }
    table{
    table-layout: fixed; 
    word-wrap:break-word;
    }
    th.dt-center, td.dt-center { text-align: center; }
</style>  


<div class="box">
   <div class="box-header">
     <h3 class="box-title">Master Data Program Studi</h3>
     <div class="pull-right">
     <?php  if($this->ion_auth->is_admin()){ ?>
        <button id="btnadd" class="btn btn-sm btn-success" onclick="add_record()"><i class="glyphicon glyphicon-plus"></i> Tambah Data</button>
     <?php } ?>
        <button class="btn btn-sm btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
    
   </div>
   </div>
<div class="box-body table-responsive">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" style="font-size:12px">
            <thead>
                <tr>
                    <th width="20px">No</th>
                    <th>Program Studi</th>
                    <th>Jenjang</th>
                    <th>Fakultas</th>
                    <th>Daya Tampung</th>
                    <?php  if($this->ion_auth->is_admin()){ ?>
                    <th style="width:130px;">Aksi</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
            </tbody>
 
           
        </table>
        </div>
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
    $("#mnprodi").addClass('active');
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('prodi/ajax_list')?>",
            "type": "POST"
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [2,4], 
            "className": 'dt-center',
            "width": 100,
        },
        ],
 
    }); 
 
});
 
 
 
function add_record()
{
    save_method = 'add';
    $('#form-prodi')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $('#modal_form').modal('show'); 
    $('.modal-title').text('Tambah Program Studi'); 
    $("#error_namaprodi").html('');
    $("#error_jenjang").html('');
    $("#error_dayatampung").html('');
    $("#error_idfakultas").html('');
}
 
function edit_record(id)
{
    save_method = 'update';
    $('#form-prodi')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $("#error_namaprodi").html('');
    $("#error_jenjang").html('');
    $("#error_dayatampung").html('');
    $("#error_idfakultas").html('');
 
    //Ajax Load data from ajax  
    $.ajax({
        url : "<?php echo base_url('prodi/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="idfakultas"]').val(data.idfakultas);
            $('[name="idprodi"]').val(data.idprodi);
            $('[name="namaprodi"]').val(data.namaprodi);
            $('[name="jenjang"]').val(data.jenjang);
            $('[name="dayatampung"]').val(data.dayatampung);
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
    table.ajax.reload(null,false); 
}
 
function save()
{
    $("#error_namaprodi").html('');
    $("#error_dayatampung").html('');
    $("#error_jenjang").html('');
    $("#error_idfakultas").html('');
    $('#btnSave').text('saving...');
    $('#btnSave').attr('disabled',true); 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('prodi/ajax_add')?>";
    } else {
        url = "<?php echo site_url('prodi/ajax_update')?>";
    }
 
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form-prodi').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            
            if (data.hasil !== "sukses") {
                $("#error_namaprodi").html(data.error.namaprodi);
                $("#error_jenjang").html(data.error.jenjang);
                $("#error_dayatampung").html(data.error.dayatampung);
                $("#error_idfakultas").html(data.error.idfakultas);
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
            url : "<?php echo base_url('prodi/ajax_delete')?>/"+id,
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
                <h3 class="modal-title">Form Program Studi/h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form-prodi" class="form-horizontal">
                    <input type="hidden" value="" name="idprodi"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama Prodi</label>
                            <div class="col-md-8">
                                <input name="namaprodi" placeholder="Nama Prodi" class="form-control" type="text">
                                <span class="text-danger" id="error_namaprodi"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Jenjang</label>
                            <div class="col-md-8">
                                <input name="jenjang" placeholder="Jenjang" class="form-control" type="text">
                                <span class="text-danger" id="error_jenjang"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Daya Tampung</label>
                            <div class="col-md-8">
                                <input name="dayatampung" placeholder="Daya Tampung" class="form-control" type="number">
                                <span class="text-danger" id="error_dayatampung"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Fakultas</label>
                            <div class="col-md-8">
                            <?php echo form_dropdown('idfakultas', $dd_fakultas, $fakultas_selected,'class="form-control select2"'); ?>
                                <span class="text-danger" id="error_idfakultas"></span>
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