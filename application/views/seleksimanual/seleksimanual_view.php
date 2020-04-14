<!-- Datatable style -->

<link href="<?php echo base_url('public/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
<link href="<?php echo base_url('public/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('public/fixedColumns.dataTables.min.css')?>">
<link rel="stylesheet" href="<?php echo base_url('public/select.dataTables.min.css')?>">
<link rel="stylesheet" href="<?php echo base_url('public/buttons.dataTables.min.css')?>">

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
    td..color-blue { background-color: Blue; }

    
</style>  
  
  <div class="box"> 
    <div class="box-header">
        <h3 class="box-title">Seleksi Calon Mahasiswa Baru Universitas Papua Jalur Seleksi Sesama TA. <?=$tahunakademik;?></h3>  
        <div class="pull-right">
            <button type="submit" name="btnterimakolektif" id="btnterimakolektif" class="btn btn-sm btn-success">Terima Kolektif</button>
            <button id="btnreload" class="btn btn-sm btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                
        </div>
   </div>
   <!-- /.box-header -->
  
        <div class="box-body table-responsive">
        <form action="#" id="form-filter" class="form-horizontal">
        <div class="form-group">
        <table width="100%">
            <tr>
                <td width="10%"><label style="font-size:13px;">Pilih Program Studi :</label></td>
                <td width="1%"></td>
                <td width="25%"><?php echo form_dropdown('pilihprodi', $dd_prodi, $prodi_selected,'id="pilihprodi" class="form-control select2 input-sm"'); ?></td>
                <td width="2%"></td>
                <td width="10%"><label style="font-size:13px;">Daya Tampung Prodi:</label></td>
                <td width="1%"></td>
                <td width="5%"><input type="text" name="dayatampung" class="form-control" readonly="readonly" style="text-align:center;font-weight:bold;"></td>
                <td width="41%"></td>
            </tr>
            <tr>
                <td width="10%"><label style="font-size:13px;">Pilih Suku :</label></td>
                <td width="1%"></td>
                <td width="25%"><?php echo form_dropdown('pilihsuku', $dd_suku, $suku_selected,'id="pilihsuku" class="form-control select2 input-sm"'); ?></td>
                <td width="2%"></td>
                <td width="10%"><label style="font-size:13px;">Sisa Kuota Prodi:</label></td>
                <td width="1%"></td>
                <td width="5%"><input type="text" name="sisakuota" class="form-control" readonly="readonly" style="text-align:center;font-weight:bold;"></td>
                <td width="41%"></td>
            </tr>
        </table>
        
        </form>               
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size:12px;">
               
        <thead>
                <tr>
                    <th style="width: 20; text-align:center;"><input type="checkbox" id="selectall">Select All</th>
                    <th style="width: 60;">No. Pendaftaran</th>
                    <th style="width: 180;">Nama Pendaftar</th>
                    <th style="width: 30;">Pil. Ke</th>
                    <th style="width: 50;">Suku</th>
                    <th style="width: 80;">Jur. SLTA</th>
                    <th style="width: 20;">N.Sem-3</th>
                    <th style="width: 20;">N.Sem-4</th>
                    <th style="width: 20;">N.Sem-5</th>
                    <th style="width: 20;">N.Rata</th>
                    <th style="width: 20;">Thn. Lulus</th>
                    <th style="width: 100;">Aksi</th>
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
<script src="<?php echo base_url('public/jquery-3.3.1.js')?>"></script>  
<script src="<?php echo base_url('public/jquery.dataTables.min.js')?>"></script>  
<script src="<?php echo base_url('public/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>  
<script src="<?php echo base_url('public/dataTables.select.min.js')?>"></script> 
<script src="<?php echo base_url('public/dataTables.fixedColumns.min.js')?>"></script> 
<script src="<?php echo base_url('public/dataTables.buttons.min.js')?>"></script> 
<script src="<?php echo base_url('public/buttons.html5.min.js')?>"></script> 
<script src="<?php echo base_url('public/buttons.print.min.js')?>"></script> 

<script type="text/javascript">
 
var save_method; //for save method string
var dataTable;

$(document).ready(function() {
    $("#mnpendaftar").addClass('active');
    $("body").addClass("sidebar-collapse ");
    $("#btnreload").hide();
    $("#btnterimakolektif").hide();
    getdayatampung();
    var dataTable = $('#table').DataTable({
        
            "language": {
            "emptyTable": "Tidak ada data yang ditampilkan. Pilih salah satu Program Studi"
            },
    });

    function load_data(is_prodi,is_suku){
        $("#btnreload").show();
        var dataTable = $('#table').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url: "<?php echo site_url('seleksi/ajax_list')?>",
                type:"POST",
                data:{is_prodi:is_prodi,is_suku:is_suku}
            },
            
            fixedHeader: true,

            select: true,

            columnDefs: [
            { 
                targets: [-1], //last column
                orderable: false, //set not orderable
                width: '100',
                className: 'dt-center',
            },
            {
                orderable: false,
                width: '20',
                targets: 0,
                className: 'dt-center select-checkbox',
            },
            {
                targets: 1,
                width: '60',
                className: 'dt-center',
            },
            {
                targets: 2,
                width: '180',
            },
            {
                orderable: false,
                targets: 3,
                width: '30',
                className: 'dt-center',
            },
            {
                orderable: false,
                targets: 4,
                width: '50',
                className: 'dt-center',
            },
            {
                targets: 5,
                width: '80',
                className: 'dt-center',
            },
            
            {
                targets: [6,7,8,9,11],
                width: '20',
                className: 'dt-center',
            },
            {
                targets: 10,
                width: '20',
                className: 'dt-center color-blue',
            },
            ],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
        
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if ( aData[11] <= 2014 )
                    {
                        $('td', nRow).css('background-color', 'Red');
                    }
            }
         
        });
        
        dataTable.search('').draw(); //required after
        
       

}

    $(document).on("click","#selectall",function() {
        var dataTable = $('#table').DataTable();
        if(this.checked) { // check select status
            dataTable.rows().select();
        }else{
            dataTable.rows().deselect();
        }
    });

    $(document).on("click","#btnterimakolektif",function() {
        var dataTable = $('#table').DataTable();
        var selectednopendaftar = [];
        $.each(dataTable.rows('.selected').nodes(), function(i, item) {
            var data = dataTable.row(this).data();
            selectednopendaftar.push(data[1]);
        });
        
        var prodi = $('#pilihprodi').val();
        selectednopendaftar = selectednopendaftar.toString(); 
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('seleksi/terimakolektif')?>",
            dataType: 'JSON',
            data: {nopendaftar:selectednopendaftar, pilihprodi:prodi},
            success: function(data){
                if(data.statusterima){
                    $('#table').DataTable().ajax.reload(null, false);
                    getdayatampung(prodi);
                    dataTable.search('').draw(); //required after
                } else {
                    alert("Jumlah peserta yang dipilih melebihi sisa kuota !");
                    $('#table').DataTable().ajax.reload(null, false);
                    getdayatampung(prodi);
                    dataTable.search('').draw(); //required after
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Gagal Proses');
            }
        });
    });
    

    $(document).on('change', '#pilihprodi', function(){
        var dataTable = $('#table').DataTable();
        var prodi = $('#pilihprodi').val();
        var suku = $('#pilihsuku').val();
        $('#table').DataTable().destroy();
        if(prodi != '')
        {
            if(prodi == 'x' || prodi == '0'){
                $("#btnterimakolektif").hide();
            } else {
                $("#btnterimakolektif").show();
            }
            getdayatampung(prodi);
            load_data(prodi,suku);
            dataTable.search('').draw(); //required after
        }
        else
        {
            getdayatampung();
            load_data();
        }
    });

    $(document).on('change', '#pilihsuku', function(){
        var prodi = $('#pilihprodi').val();
        var suku = $('#pilihsuku').val();
        $('#table').DataTable().destroy();
        if(prodi != '')
        {
            getdayatampung(prodi);
            load_data(prodi,suku);
        }
        else
        {
            getdayatampung();
            load_data();
        }
    });

    
});
function getdayatampung(prodi) 
    {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('seleksi/getdayatampungprodi')?>",
            dataType: 'JSON',
            data: {pilihprodi:prodi},
            success: function(data){
                if(prodi=='x'){
                    $('[name="dayatampung"]').val('');
                    $('[name="sisakuota"]').val('');
                } else {
                    $('[name="dayatampung"]').val(data.dayatampung);
                    $('[name="sisakuota"]').val(data.sisakuota);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Gagal Proses');
            }
        });
    }
 
function detail_record(id)
{ 
    save_method = 'detail';
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url('pendaftar/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="nopendaftar"]').val(data.nopendaftar);
            $('[name="namapendaftar"]').val(data.namapendaftar);
            $('[name="ttl"]').val(data.tempatlahir+", "+data.tanggallahir);

            $('[name="jeniskelamin"]').val(data.jeniskelamin);
            $('[name="suku"]').val(data.suku);
            $('[name="pilihan1"]').val(data.pilihan1);
            $('[name="pilihan2"]').val(data.pilihan2);        
            $('[name="pilihan3"]').val(data.pilihan3);
            $('[name="jenjangslta"]').val(data.jenjangslta);
            $('[name="jurusanslta"]').val(data.jurusanslta);        
            $('[name="asalslta"]').val(data.asalslta);        
            $('[name="tahunlulus"]').val(data.tahunlulus);
            $('[name="nsem3"]').val(data.nsem3);
            $('[name="nsem4"]').val(data.nsem4);
            $('[name="nsem5"]').val(data.nsem5);
            $('[name="ratarata"]').val(data.ratarata);
            $('[name="status"]').val(data.status);
            $('[name="tahunakademik"]').val(data.tahunakademik);
            $('.modal-title').text('Data Pendaftar'); // Set title to Bootstrap modal title
            $('#modal_detail').modal('show'); // show bootstrap modal when complete loaded
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function terima(id){
    var dataTable = $('#table').DataTable();
    var prodi = $('#pilihprodi').val();
    var status = 'T';
    if(prodi == '0' || prodi == 'x'){
        alert("Pilih program studi terlebih dahulu");
    } else {
        $.ajax({
            url : "<?php echo base_url('seleksi/terima')?>/"+ id,
            type: "POST",
            dataType: "JSON",
            data: {'pilihprodi': prodi,'status':status},
            success: function(data)
            {
                if(data.statusterima){
                    $('#table').DataTable().ajax.reload(null, false);
                    getdayatampung(prodi);
                    dataTable.search('').draw();
                } else {
                    alert("Kuota Program Studi penuh !");
                    $('#table').DataTable().ajax.reload(null, false);
                    getdayatampung(prodi);
                    dataTable.search('').draw();
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
}


function reload_table(){
    $('#table').DataTable().ajax.reload(null, false);
} 
</script>
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_detail" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data Pendaftar</h4>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal" style="font-size:12px">
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
                                <input name="namapendaftar"  readonly="readonly" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tempat, Tgl. Lahir</label>
                            <div class="col-md-9">
                                <input name="ttl"  readonly="readonly" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jenis Kelamin</label>
                            <div class="col-md-9">
                                <input name="jeniskelamin" id="jeniskelamin" readonly="readonly" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Suku</label>
                            <div class="col-md-9">
                                <input name="suku" id="suku" readonly="readonly" class="form-control" type="text">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Pilihan 1</label>
                            <div class="col-md-9">
                                <input name="pilihan1" id="pilihan1" readonly="readonly" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Pilihan 2</label>
                            <div class="col-md-9">
                                <input name="pilihan2" id="pilihan2" readonly="readonly" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Pilihan 3</label>
                            <div class="col-md-9">
                                <input name="pilihan3" id="pilihan3" readonly="readonly" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-6">Jenjang SLTA</label>
                            <label class="col-md-6">Jurusan SLTA</label>
                            <div class="col-md-6">
                                <input name="jenjangslta" id="jenjangslta" readonly="readonly" class="form-control" type="text">
                            </div>
                            <div class="col-md-6">
                            <input name="jurusanslta" id="jurusanslta" readonly="readonly" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-9">Asal SLTA</label>
                            <label class="col-md-3">Tahun Lulus</label>
                            <div class="col-md-9">
                                <input name="asalslta" id="asalslta" readonly="readonly" class="form-control" type="text">
                                <span class="text-danger" id="error_asalslta"></span>
                            </div>
                            <div class="col-md-3">
                                <input name="tahunlulus" readonly="readonly" class="form-control" type="number">
                                <span class="text-danger" id="error_tahunlulus"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 text-center">Nilai Semester 3</label>
                            <label class="col-md-3 text-center">Nilai Semester 4</label>
                            <label class="col-md-3 text-center">Nilai Semester 5</label>
                            <label class="col-md-3 text-center">Nilai Rata-Rata</label>
                        
                            <div class="col-md-3">
                                <input name="nsem3" readonly="readonly" class="form-control" type="number">
                                <span class="text-danger" id="error_nsem3"></span>
                            </div>
                            <div class="col-md-3">
                                <input name="nsem4" readonly="readonly" class="form-control" type="number">
                                <span class="text-danger" id="error_nsem4"></span>
                            </div>
                            <div class="col-md-3">
                                <input name="nsem5" readonly="readonly" class="form-control" type="number">
                                <span class="text-danger" id="error_nsem5"></span>
                            </div>
                            <div class="col-md-3">
                                <input name="ratarata" readonly="readonly" class="form-control" type="number">
                                <span class="text-danger" id="error_ratarata"></span>
                            </div>
                        </div>
                        
                    </div>
                    <input name="status" type="hidden">
                    <input name="tahunakademik" type="hidden">
                                
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
</body>
</html>