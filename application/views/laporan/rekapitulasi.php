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
     <h3 class="box-title">Rekapitulasi Penerimaan Seleksi Jalur Sesama Universitas Papua <?=$tahun;?></h3>
     
     <div class="pull-right">
     <?php if($this->ion_auth->is_admin()){?>
        <a target="blank" class="btn btn-sm btn-warning" href="<?=base_url('laporan/rekapexcel')?>"><i class="glyphicon glyphicon-download"></i> Download Excel</a>
      <?php } ?>
      <button class="btn btn-sm btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        
        
     </div>
   </div>
        <div class="box-body table-responsive">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" style="font-size:12px;">
            <thead>
                <tr>
                    <th width="20px">No</th>
                    <th>Program Studi</th>
                    <th>Peminat</th>
                    <th>Daya Tampung</th>
                    <th>Terima</th>
                    <th>Kosong</th>
                    <th>% Kosong</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">TOTAL</th>
                    <th><div id="totalpeminat"></div></th>
                    <th><div id="totaldayatampung"></div></th>
                    <th><div id="totalterima"></div></th>
                    <th><div id="totalkosong"></div></th>
                    <th><div id="totalpersenkosong"></div></th>
                </tr>
            </tfoot>
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
     $("#mnrekapitulasi").addClass('active');
     //datatables
     gettotal();
     table = $('#table').DataTable({ 
  
         "processing": true, //Feature control the processing indicator.
         "serverSide": true, //Feature control DataTables' server-side processing mode.
         "order": [], //Initial no order.
  
         // Load data for the table's content from an Ajax source
         "ajax": {
             "url": "<?php echo site_url('laporan/rekapitulasi_list')?>",
             "type": "POST"
         },
  
         //Set column definition initialisation properties.
         "columnDefs": [
         { 
             targets: [1], 
             width: '250',
         },
         {
            targets: [0,2,3,4,5,6],
            className: 'dt-center',
            orderable: true,
         },
         ],
  
     });
  
     
  
 });
 function reload_table(){
    $('#table').DataTable().ajax.reload(null, false);
} 
 function gettotal()
    {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('laporan/gettotal')?>",
            dataType: 'JSON',
            success: function(data){
                $("#totalpeminat").append(data.totalpeminat);
                $("#totaldayatampung").append(data.totaldayatampung);
                $("#totalterima").append(data.totalterima);
                $("#totalkosong").append(data.totalkosong);
                $("#totalpersenkosong").append(data.persenkosong+" %");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Gagal Proses');
            }
        });
    }
 </script>