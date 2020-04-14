<!-- Datatable style -->
    <link href="<?php echo base_url('public/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('public/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('public/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('public/buttons.dataTables.min.css')?>" rel="stylesheet">
<style>
    th, td { white-space: nowrap; } 
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    tr { height: 10px;  }
    th, td.dt-center { text-align: center; }
</style>    

  <div class="box">
   <div class="box-header">
     <h3 class="box-title">Hasil Seleksi Jalur Sesama Universitas Papua <?=$tahun;?></h3>
     
     <div class="pull-right">
     <?php if($this->ion_auth->is_admin()){?>
        <a target="blank" class="btn btn-sm btn-danger" onclick="batalkansemua()"><i class="fa fa-remove"></i> Batalkan Semua</a>
        <a target="blank" class="btn btn-sm btn-success" href="<?=base_url('laporan/laporanexcel')?>"><i class="fa fa-file-excel-o"></i> Export Excel</a>
        <a target="blank" class="btn btn-sm btn-primary" href="<?=base_url('laporan/pdfsk')?>"><i class="fa fa-file-pdf-o"></i> Cetak SK</a>
        <a target="blank" class="btn btn-sm btn-warning" href="<?=base_url('laporan/pdfcetak')?>"><i class="fa fa-file-pdf-o"></i> Cetak Hasil</a>
     <?php } ?>
        <button class="btn btn-sm btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        
     </div>
   </div>
        <div class="box-body table-responsive">
        <form action="#" id="form" class="form-horizontal">
        <div class="form-group">
        <div class="col-xs-3">
            <label style="font-size:13px;">Pilih Program Studi</label>
            <?php echo form_dropdown('pilihprodi', $dd_prodi, $prodi_selected,'id="pilihprodi" class="form-control select2 input-sm"'); ?>
        </div>
        </div>  
        </form>   
        <table id="table" class="table table-striped table-bordered" cellspacing="0" style="font-size:12px;">
            <thead>
                <tr>
                    <th width="20px">No</th>
                    <th>No. Peserta</th>
                    <th>Nama</th>
                    <th>Program Studi</th>
                    <th>Jenjang</th>
                    <th>Fakultas</th>
                    <th>Tahun Lulus</th>
                    <th>Aksi</th>
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
<script src="<?php echo base_url('public/jquery-3.3.1.js')?>"></script>  
<script src="<?php echo base_url('public/jquery.dataTables.min.js')?>"></script>  
<script src="<?php echo base_url('public/plugins/datatables/dataTables.bootstrap.min.js')?>"></script> 
<script src="<?php echo base_url('public/dataTables.buttons.min.js')?>"></script> 
<script src="<?php echo base_url('public/buttons.print.min.js')?>"></script> 
<script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {
    $("#mnpenerimaan").addClass('active');

    var dataTable = $('#table').DataTable({
            "language": {
            "emptyTable": "Tidak ada data yang ditampilkan. Pilih salah satu Program Studi"
            },
    });

    function load_data(is_prodi){ 
        var dataTable = $('#table').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url: "<?php echo site_url('penerimaan/ajax_list')?>",
                type:"POST",
                data:{is_prodi:is_prodi}
            }, 
            
            columnDefs: [
            { 
                targets: [-1], //last column
                orderable: false, //set not orderable
                className: 'dt-center',
            },
            {
                targets: 0,
                width: '20',
            },
            {
                targets: [1,4,6],
                width: '70',
                className: 'dt-center',
            },
            {
                targets: [2,3,5],
                width: '200',
            },
            ],
            
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if ( aData[6] <= 2014 )
                    {
                        $('td', nRow).css('background-color', 'Red');
                    }
            },
           
        });
       
    }

    $(document).on('change', '#pilihprodi', function(){
        var prodi = $(this).val();
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

});
function reload_table(){
    $('#table').DataTable().ajax.reload(null, false);
} 

function batalkan(id){
    var status = 'B';
    $.ajax({
        url : "<?php echo base_url('penerimaan/batalkan')?>/"+ id,
        type: "POST",
        dataType: "JSON",
        data: {'status':status},
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

function batalkansemua(){
    if(confirm('Apakah anda yakin akan membatalkan semua peserta yang diterima?'))
    {
        var status = 'B';
        $.ajax({
            url : "<?php echo base_url('penerimaan/batalkansemua')?>",
            type: "POST",
            dataType: "JSON",
            data: {'status':status},
            success: function(data)
            {
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
}
</script>
<!-- End Bootstrap modal -->

</body>
</html>