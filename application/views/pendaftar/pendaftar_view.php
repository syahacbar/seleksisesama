<!-- Datatable style -->
<link href="<?php echo base_url('public/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
<link href="<?php echo base_url('public/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
<link href="<?php echo base_url('public/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
<link href="<?php echo base_url('public/plugins/select2/select2.min.css')?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('public/EasyAutocomplete-1.3.5/easy-autocomplete.min.css')?>"> 
<link rel="stylesheet" href="<?php echo base_url('public/EasyAutocomplete-1.3.5/easy-autocomplete.themes.min.css')?>"> 

<style>
    th, td { white-space: nowrap; } 
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
     <h3 class="box-title">Data Pendaftar Universitas Papua Jalur Seleksi Sesama TA. <?=$tahunakademik;?></h3>
     <div class="pull-right">
         <?php  if($this->ion_auth->is_admin()){ ?> 
        <button class="btn btn-sm btn-success" onclick="add_record()"><i class="glyphicon glyphicon-plus"></i> Tambah Data</button>
        <button class="btn btn-sm btn-primary" onclick="import_excel()"><i class="glyphicon glyphicon-import"></i> Import Excel</button>
         <?php } ?>
        <button id="btnreload" class="btn btn-sm btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        
     </div>
   </div>
        <div class="box-body table-responsive">
        <form action="#" id="form" class="form-horizontal">
        <div class="form-group">
        <div class="col-xs-3">
            <label style="font-size:13px;">Pilih Program Studi</label>
            <?php echo form_dropdown('pilihprodi', $dd_prodix, $prodi_selected,'id="pilihprodi" class="form-control select2 input-sm"'); ?>
        </div>
        </div>  
        </form>   
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size:12px;">
            <thead>
                <tr>
                    <th width="20px">No</th>
                    <th width="100">No. Pendaftaran</th>
                    <th width="200">Nama Pendaftar</th>
                    <th width="250">Pilihan 1</th>
                    <th width="250">Pilihan 2</th>
                    <th width="250">Pilihan 3</th>
                    <th width="100">Tempat Lahir </th>
                    <th width="50">Tanggal Lahir</th>
                    <th width="50">Jenis Kelamin</th>
                    <th width="50">Suku</th>
                    <th width="80">Jenjang SLTA</th>
                    <th width="250">Asal SLTA</th>
                    <th width="80">Jurusan SLTA</th>
                    <th width="50">Tahun Lulus</th>
                    <?php  if($this->ion_auth->is_admin()){ ?>
                    <th style="width:100px;text-align: center;">Aksi</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
            </tbody>
 
           
        </table>
        </div>
 </div>

<script src="<?php echo base_url('public/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('public/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('public/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('public/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<script src="<?php echo base_url('public/plugins/select2/select2.full.min.js')?>"></script>
<script src="<?php echo base_url('public/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js')?>"></script> 
<script src="<?php echo base_url('public/dataTables.fixedColumns.min.js')?>"></script> 
<script type="text/javascript">
 
var save_method; //for save method string 
var dataTable;

$(document).ready(function() {
    $("#mnpendaftar").addClass('active');
    $("#btnreload").hide();
    //datatables
    var dataTable = $('#table').DataTable({
            "language": {
            "emptyTable": "Tidak ada data yang ditampilkan. Pilih salah satu Program Studi"
            },
    });

    function load_data(is_prodi){
        $("#btnreload").show();
        var dataTable = $('#table').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url: "<?php echo site_url('pendaftar/ajax_list')?>",
                type:"POST",
                data:{is_prodi:is_prodi}
            },
            
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            fixedColumns:   {
                leftColumns: 3,
            }, 

            columnDefs: [
            { 
                targets: [-1], //last column
                orderable: false, //set not orderable
                width: '100',
            },
            {
                orderable: false,
                width: '20',
                targets: 0,
            },
            {
                targets: [1,6],
                width: '100',
            },
            {
                targets: 2,
                width: '200',
            },
            {
                targets: [3,4,5,11],
                width: '250',
            },
            {
                targets: [10,12],
                width: '80',
                className: 'dt-center',
            },
            {
                targets: [7,8,9,13],
                width: '50',
                className: 'dt-center',
            },
            ],
            select: {
                style:    'multi',
                selector: 'td:first-child'
            },
        });
    }

    $(document).on('change', '#pilihprodi', function(){
        var prodi = $('#pilihprodi').val();
        $('#table').DataTable().destroy();
        if(prodi != '')
        {
            load_data(prodi);
        }
        else
        {
            load_data();
        }
    });

 
var optionsasalslta = {
    url: function(phrase) {
        return "<?php echo base_url('pendaftar/asalslta/')?>";
    },
    getValue: "asalslta",
    list: {
        match: {
            enabled: true
        }
    }
};
$("#asalslta").easyAutocomplete(optionsasalslta);   
$('div.easy-autocomplete').removeAttr('style');

var optionsjenjangslta = {
    url: function(phrase) {
        return "<?php echo base_url('pendaftar/jenjangslta/')?>";
    },
    getValue: "jenjangslta",
    list: {
        match: {
            enabled: true
        }
    }
};

$("#jenjangslta").easyAutocomplete(optionsjenjangslta);   
$('div.easy-autocomplete').removeAttr('style');

var optionsjurusanslta = {
    url: function(phrase) {
        return "<?php echo base_url('pendaftar/jurusanslta/')?>";
    },
    getValue: "jurusanslta",
    list: {
        match: {
            enabled: true
        }
    }
};
$("#jurusanslta").easyAutocomplete(optionsjurusanslta);   
$('div.easy-autocomplete').removeAttr('style');  
});
 

function add_record()
{
    save_method = 'add';
     
    $('#form-pendaftar')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Pendaftar'); // Set Title to Bootstrap modal title

    

    //Date picker
    $('#datepicker').datepicker({
        format:"dd-mm-yyyy",
        autoclose: true,
        })
    // select2
    $('.select2').select2({
        tags: true
    });

    $("#error_namapendaftar").html('');
    $("#error_tempatlahir").html('');
    $("#error_tanggallahir").html('');
    $("#error_jeniskelamin").html('');
    $("#error_suku").html('');
    $("#error_pilihan1").html('');
    $("#error_pilihan2").html('');
    $("#error_pilihan3").html('');
    $("#error_jenjangslta").html('');
    $("#error_jurusanslta").html('');
    $("#error_asalslta").html('');
    $("#error_tahunlulus").html('');
    $("#error_nbahasa").html('');
    $("#error_nipa").html('');
    $("#error_nips").html('');
    $("#error_nmat").html('');


     //Ajax Load data from ajax
     $.ajax({
        url : "<?php echo base_url('pendaftar/ajax_get/')?>",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="nopendaftar"]').val(data.nopendaftar);
            $('[name="status"]').val(data.status);
            $('[name="tahunakademik"]').val(data.tahunakademik);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function edit_record(id)
{
    save_method = 'update';
    
    $('#form-pendaftar')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    //Date picker
    $('#datepicker').datepicker({
        format:"dd-mm-yyyy",
        autoclose: true,
        })
    // select2
    $('.select2').select2({
        tags: true
    });

    $("#error_namapendaftar").html('');
    $("#error_tempatlahir").html('');
    $("#error_tanggallahir").html('');
    $("#error_jeniskelamin").html('');
    $("#error_suku").html('');
    $("#error_pilihan1").html('');
    $("#error_pilihan2").html('');
    $("#error_pilihan3").html('');
    $("#error_jenjangslta").html('');
    $("#error_jurusanslta").html('');
    $("#error_asalslta").html('');
    $("#error_tahunlulus").html('');
    $("#error_nbahasa").html('');
    $("#error_nipa").html('');
    $("#error_nips").html('');
    $("#error_nmat").html('');
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url('pendaftar/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="nopendaftar"]').val(data.nopendaftar);
            $('[name="namapendaftar"]').val(data.namapendaftar);
            $('[name="tempatlahir"]').val(data.tempatlahir);
            $('[name="tanggallahir"]').val(data.tanggallahir);
            $("#datepicker").datepicker( "setDate" , data.tanggallahir );
            
            if (data.jeniskelamin == 'LAKI-LAKI')
                $("#jeniskelaminL").prop("checked",true);
            else 
                $("#jeniskelaminP").prop("checked",true);
            
            if (data.suku == 'PAPUA') 
                $("#sukuP").prop("checked",true);
            else 
                $("#sukuNP").prop("checked",true);
            
            $("#pilihan1").val(data.pilihan1).trigger("change");
            $("#pilihan2").val(data.pilihan2).trigger("change");
            $("#pilihan3").val(data.pilihan3).trigger("change");
            $("#jenjangslta").val(data.jenjangslta).trigger("change");
            $("#jurusanslta").val(data.jurusanslta).trigger("change");           
            $('[name="asalslta"]').val(data.asalslta);            
            $('[name="tahunlulus"]').val(data.tahunlulus);
            $('[name="nbahasa"]').val(data.nbahasa);
            $('[name="nipa"]').val(data.nipa);
            $('[name="nips"]').val(data.nips);
            $('[name="nmat"]').val(data.nmat);
            $('[name="status"]').val(data.status);
            $('[name="tahunakademik"]').val(data.tahunakademik);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Ubah Data Pendaftar'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
 

 
function save()
{
    
    $("#error_namapendaftar").html('');
    $("#error_tempatlahir").html('');
    $("#error_tanggallahir").html('');
    $("#error_jeniskelamin").html('');
    $("#error_suku").html('');
    $("#error_pilihan1").html('');
    $("#error_pilihan2").html('');
    $("#error_pilihan3").html('');
    $("#error_jenjangslta").html('');
    $("#error_jurusanslta").html('');
    $("#error_asalslta").html('');
    $("#error_tahunlulus").html('');
    $("#error_nbahasa").html('');
    $("#error_nipa").html('');
    $("#error_nips").html('');
    $("#error_nverbal").html('');
    
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('pendaftar/ajax_add')?>";
    } else {
        url = "<?php echo site_url('pendaftar/ajax_update')?>";
    }
 
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form-pendaftar').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            if (data.hasil !== "sukses") {
                $("#error_namapendaftar").html(data.error.namapendaftar);
                $("#error_tempatlahir").html(data.error.tempatlahir);
                $("#error_tanggallahir").html(data.error.tanggallahir);
                $("#error_jeniskelamin").html(data.error.jeniskelamin);
                $("#error_suku").html(data.error.suku);
                $("#error_pilihan1").html(data.error.pilihan1);
                $("#error_pilihan2").html(data.error.pilihan2);
                $("#error_pilihan3").html(data.error.pilihan3);
                $("#error_jenjangslta").html(data.error.jenjangslta);
                $("#error_jurusanslta").html(data.error.jurusanslta);
                $("#error_asalslta").html(data.error.asalslta);
                $("#error_tahunlulus").html(data.error.tahunlulus);
                $("#error_nbahasa").html(data.error.nbahasa);
                $("#error_nipa").html(data.error.nipa);
                $("#error_nips").html(data.error.nips);
                $("#error_nverbal").html(data.error.nverbal);
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

function reload_table(){
    $('#table').DataTable().ajax.reload(null, false);
} 

function delete_record(id)
{
    if(confirm('Apakah anda yakin akan menghapus data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo base_url('pendaftar/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                $('#table').DataTable().ajax.reload(null, false);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
    }
}

function import_excel()
{
    save_method = 'import';
    $('#modal_import').modal('show'); // show bootstrap modal
    $('.modal-title').text('Import Data Pendaftar Dari File Excel'); // Set Title to Bootstrap modal title
}

function upload_file()
{
        $.ajax({
            beforeSend:function()
            {
                $("#modimport").css("display","none");
                $("#loading").css("display","block");
                $('#btnUpload').text('Menyimpan...'); 
                $('#btnUpload').attr('disabled',true); 
                var file = document.getElementById("fileku").files[0];
                var formdata = new FormData();
                formdata.append("datafile", file);
                var ajax = new XMLHttpRequest();
                ajax.open("POST", "<?php echo base_url('pendaftar/importexcel')?>", true);
                ajax.send(formdata);
            },
            success:function(data)
            {   if(data.status){
                    $('#modal_import').modal('hide');
                    location.reload();
                }
                location.reload();
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
                <h3 class="modal-title">Form Pendaftar/h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form-pendaftar" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">No. Pendaftar</label>
                            <div class="col-md-9">
                                <input name="nopendaftar"  class="form-control" type="text" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Pedaftar</label>
                            <div class="col-md-9">
                                <input name="namapendaftar" placeholder="Nama Pendaftar" class="form-control" type="text">
                                <span class="text-danger" id="error_namapendaftar"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tempat, Tgl. Lahir</label>
                            <div class="col-md-5">
                                <input name="tempatlahir" placeholder="Tempat Lahir" class="form-control" type="text">
                                <span class="text-danger" id="error_tempatlahir"></span>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </div>
                                <input name="tanggallahir" type="text" placeholder="Tgl. Lahir" class="form-control pull-right" id="datepicker">
                                </div>
                                <span class="text-danger" id="error_tanggallahir"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Jenis Kelamin</label>
                            <div class="col-md-9">
                            <input type="radio" name="jeniskelamin" class="minimal" value="LAKI-LAKI" id="jeniskelaminL"> LAKI-LAKI
                            <input type="radio" name="jeniskelamin" class="minimal" value="PEREMPUAN" id="jeniskelaminP"> PEREMPUAN
                            <span class="text-danger" id="error_jeniskelamin"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Suku</label>
                            <div class="col-md-9">
                                <input type="radio" name="suku" class="minimal" value="PAPUA" id="sukuP"> PAPUA
                                <input type="radio" name="suku" class="minimal" value="NON PAPUA" id="sukuNP"> NON PAPUA
                                <span class="text-danger" id="error_suku"></span>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="control-label col-md-3">Pilihan 1</label>
                            <div class="col-md-9">
                            <?php echo form_dropdown('pilihan1', $dd_prodi, $p1_selected,'id="pilihan1" class="form-control select2" style="width: 100%;"'); ?>
                            <span class="text-danger" id="error_pilihan1"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Pilihan 2</label>
                            <div class="col-md-9">
                            <?php echo form_dropdown('pilihan2', $dd_prodi, $p2_selected,'id="pilihan2" class="form-control select2" style="width: 100%;"'); ?>
                            <span class="text-danger" id="error_pilihan2"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Pilihan 3</label>
                            <div class="col-md-9">
                            <?php echo form_dropdown('pilihan3', $dd_prodi, $p3_selected,'id="pilihan3" class="form-control select2" style="width: 100%;"'); ?>
                            <span class="text-danger" id="error_pilihan3"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-6">Jenjang SLTA</label>
                            <label class="col-md-6">Jurusan SLTA</label>
                            <div class="col-md-6">
                                <input name="jenjangslta" id="jenjangslta" placeholder="Jenjang SLTA" class="form-control" type="text">
                                <span class="text-danger" id="error_jenjangslta"></span>
                            </div>
                            <div class="col-md-6">
                                <input name="jurusanslta" id="jurusanslta" placeholder="Jurusan SLTA" class="form-control" type="text">
                                <span class="text-danger" id="error_jurusanslta"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-9">Asal SLTA</label>
                            <label class="col-md-3">Tahun Lulus</label>
                            <div class="col-md-9">
                                <input name="asalslta" id="asalslta" placeholder="Asal SLTA" class="form-control" type="text">
                                <span class="text-danger" id="error_asalslta"></span>
                            </div>
                            <div class="col-md-3">
                                <input name="tahunlulus" placeholder="Tahun Lulus" class="form-control" type="number">
                                <span class="text-danger" id="error_tahunlulus"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 text-center">Nilai Semester 3</label>
                            <label class="col-md-4 text-center">Nilai Semester 4</label>
                            <label class="col-md-4 text-center">Nilai Semester 5</label>
                            
                            <div class="col-md-4">
                                <input name="nsem3" placeholder="Nilai Semester 3" class="form-control" type="number">
                                <span class="text-danger" id="error_nsem3"></span>
                            </div>
                            <div class="col-md-4">
                                <input name="nsem4" placeholder="Nilai Semester 4" class="form-control" type="number">
                                <span class="text-danger" id="error_nsem4"></span>
                            </div>
                            <div class="col-md-4">
                                <input name="nsem5" placeholder="Nilai Semester 5" class="form-control" type="number">
                                <span class="text-danger" id="error_nsem5"></span>
                            </div>                            
                        </div>
                        
                    </div>
                    <input name="status" type="hidden">
                    <input name="tahunakademik" type="hidden">
                                
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
 
<!-- Modal Import Excel-->
<div class="modal fade" id="modal_import">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="upload_form" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Default Modal</h4>
            </div>
            <div id="modimport">
                <div class="row">
                    <div class="modal-body">
                        <div class="col-md-6">
                            <input type="file" name="datafile" id="fileku">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="modal-body">
                        <div class="col-md-12">
                            Download Format Excel Untuk Import Data Disini 
                            <a class="btn btn-xs btn-info" target="blank" href="<?=base_url('public/format_import_pendaftar.xls')?>"><i class="glyphicon glyphicon-import"></i>Downnload Format Excel</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="image">
                            <img class="col-md3" src=<?=base_url('public/dist/img/ss_importexcels.png')?> width="100%" align="center">
                        </div>
                    </div>
                </div>
            </div>

            <div id="loading" style="display:none">
                <div class="row">
                    <div class="modal-body">
                        <div class="col-md-12" align="center">
                            <img class="col-md3" src=<?=base_url('public/dist/img/loading.gif')?>  align="center">
                        </div>
                    </div>
                </div>
            </div>
              
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnUpload" onclick="upload_file()" >Upload File</button>
            </div>
        </form>
    </div>
</div>
</div>
</body>
</html>