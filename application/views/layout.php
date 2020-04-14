<!DOCTYPE html>
<html lang="en">
	<head>
		  <title>Sistem Admisi Unipa</title>
		  <!-- Tell the browser to be responsive to screen width -->
		  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		  <!-- Bootstrap 3.3.6 -->
		  <link rel="stylesheet" href="<?= base_url() ?>public/bootstrap/css/bootstrap.min.css">
		  <!-- Font Awesome -->
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		  <!-- Ionicons -->
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		  <link rel="stylesheet" href="<?= base_url() ?>public/font-googleapis.css">
		  <!-- Theme style -->
	      <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/AdminLTE.min.css">
	       <!-- Custom CSS -->
		  <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/style.css">
		  <!-- AdminLTE Skins. Choose a skin from the css/skins. -->
		  <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/skins/skin-purple.min.css">
		   <!-- bootstrap datepicker 
 		  <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/bootstrap-datepicker.min.css">-->
		  <!-- jQuery 2.2.3 -->
		  <script src="<?= base_url() ?>public/plugins/jQuery/jquery-2.2.3.min.js"></script>
		  <!-- jQuery UI 1.11.4 --> 
	</head>
	<body class="hold-transition skin-purple sidebar-mini">
		<div class="wrapper" style="height: auto;">
			 <?php if($this->session->flashdata('message') != ''): ?>
			    <div class="alert alert-warning flash-msg alert-dismissible">
			      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			      <h4> Perhatian!</h4>
			      <?= $this->session->flashdata('message'); ?> 
			    </div>
			  <?php endif; ?> 
			
			<section id="container">
				<!--header start-->
				<header class="header white-bg">
					<?php include('include/navbar.php'); ?>
				</header>
				<!--header end-->
				<!--sidebar start-->
				<aside>
					<?php include('include/sidebar.php'); ?>
				</aside>
				<!--sidebar end-->
				<!--main content start-->
				<section id="main-content">
					<div class="content-wrapper" style="min-height: 394px; padding:15px;">
						<!-- page start-->
						<?php $this->load->view($view);?>
						<!-- page end-->
					</div>
				</section>
				<!--main content end-->
				<!--footer start-->
				<footer class="main-footer">
					<strong>Copyright © 2018 <a href="http://unipa.ac.id">Universitas Papua</a></strong> All rights
					reserved.
				</footer>
				<!--footer end-->
			</section>

			<!-- /.control-sidebar -->
			<?php include('include/control_sidebar.php'); ?>

	</div>	
    
	
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('public/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
	<!-- AdminLTE App -->
    <script src="<?= base_url() ?>public/dist/js/app.min.js"></script>
    <script src="<?= base_url() ?>public/dist/js/adminlte.min.js"></script>
	<!-- page script -->
	<script type="text/javascript">
	  $(".flash-msg").fadeTo(2000, 500).slideUp(500, function(){
	    $(".flash-msg").slideUp(500);
	});

function edit_password(id)
{
    save_method = 'update';
    $('#form-ubahpassword')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $("#error_old").html('');
    $("#error_new").html('');
    $("#error_new_confirm").html('');
    $("#error_cekpass").html('');
 
    //Ajax Load data from ajax  
    $.ajax({
        url : "<?php echo base_url('user/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('#modal_changepassword').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Program Studi'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
function changepassword()
{
    //$('#form-ubahpassword')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $("#error_old").html('');
    $("#error_new").html('');
    $("#error_new_confirm").html('');
    $("#error_cekpass").html('');
    $('#btnSaveubahpass').text('saving...');
    $('#btnSaveubahpass').attr('disabled',true); 
	var passlama = $("input#old").val();
	var passbaru = $("input#new").val();
  	var konfirm_passbaru = $("input#new_confirm").val();
	var dataString = 'old='+ passlama + '&new=' + passbaru + '&new_confirm=' + konfirm_passbaru ;

    $.ajax({
        url : "<?php echo site_url('user/changepassword')?>",
        type: "POST",
        data: dataString,
        dataType: "JSON",
        success: function(data)
        {
            
            if (data.hasil !== "sukses") {
                $("#error_old").html(data.error.old);
                $("#error_new").html(data.error.new);
                $("#error_new_confirm").html(data.error.new_confirm);
                $("#error_cekpass").html(data.error.cekpass);
            }
 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_changepassword').modal('hide');
                window.location = "<?php echo site_url('auth/logout')?>";
            }
 
            $('#btnSaveubahpass').text('Simpan'); //change button text
            $('#btnSaveubahpass').attr('disabled',false); //set button enable 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSaveubahpass').text('Simpan'); //change button text
            $('#btnSaveubahpass').attr('disabled',false); //set button enable 
 
        }
    });
    
}
</script>
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_changepassword" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Form Ubah Passowrd </h4>
            </div>
            <div class="modal-body form">
                <form id="form-ubahpassword" class="form-horizontal" style="font-size:12px">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-4">Username</label>
                            <div class="col-md-8">
                                <input readonly="readonly" id="user" name="user" class="form-control" type="text" value="<?= $this->session->userdata('identity'); ?>">
                                <span class="text-danger" id="error_user"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Password Lama</label>
                            <div class="col-md-8">
                                <input id="old" name="old" placeholder="Password Lama" class="form-control" type="password">
                                <span class="text-danger" id="error_old"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Password Baru</label>
                            <div class="col-md-8">
                                <input id="new" name="new" placeholder="Password Baru" class="form-control" type="password">
                                <span class="text-danger" id="error_new"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Konfirmasi Password Baru</label>
                            <div class="col-md-8">
                                <input id="new_confirm" name="new_confirm" placeholder="Konfirmasi Password Baru" class="form-control" type="password">
                                <span class="text-danger" id="error_new_confirm"></span><br><span class="text-danger" id="error_cekpassword"></span><br>
                                <span class="text-danger" id="error_cekpass"></span><br><span class="text-danger" id="error_cekpassword"></span>
                            </div>
                        </div>
                    </div>          
                
            </div>
            <div class="modal-footer">
              <button type="button" id="btnSaveubahpass" onclick="changepassword()" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
            </div></form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
 	
</body>
</html>