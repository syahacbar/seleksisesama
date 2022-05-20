<!-- Datatable style -->
    <link href="<?php echo base_url('public/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('public/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('public/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
<div class="row">
<form action="#" id="form" class="form-horizontal">
    <div class="col-md-3">   
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Pengaturan Sistem</h3> 
            </div>
            <div class="box-body">
                <div class="form">
                    <div class="form-body">
                        <div class="form-group">
                            <label>Aktifkan Sesi Pilihan </label>
                            <div class="input-group">
                                <?php echo form_dropdown('sesipilihan', $dd_sesipilihan, $sesipilihan_selected,'id="sesipilihan" class="form-control select2"'); ?>
                                <div class="input-group-btn">
                                    <button type="button" id="btnsavesesipilihan" onclick="savesesipilihan()" class="btn btn-primary">Simpan</button>
                                </div>
                            <span class="text-danger" id="sukses_sesipilihan"></span>    
                        </div>
                        </div>
                        <div class="form-group">
                            <label>Tahun Akademik</label>
                            <div class="input-group">
                                <?php echo form_dropdown('tahunakademik', $dd_tahunakademik, $tahunakademik_selected,'id="tahunakademik" class="form-control select2"'); ?>
                                <div class="input-group-btn">
                                    <button type="button" id="btnsavetahunakademik" onclick="savetahunakademik()" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Status User</label>
                            <div class="input-group">
                                <?php echo form_dropdown('statususer', $dd_statususer, $statususer_selected,'id="statususer" class="form-control select2"'); ?>
                                <div class="input-group-btn">
                                    <button type="button" id="btnsavestatususer" onclick="savestatususer()" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="col-md-5">   
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title">Pengaturan SK</h3> 
            </div>
            <div class="box-body">
                <div class="form">
                    <div class="form-body">
                        <div class="form-group">
                            <label>Lampiran SK</label>
                            <div class="input-group">
                                <input name="lampiransk" id="lampiransk" class="form-control" type="text">
                                <div class="input-group-btn">
                                    <button type="button" id="btnsavelampiransk" onclick="savelampiransk()" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nomor SK</label>
                            <div class="input-group">
                                <input name="nomorsk" id="nomorsk" class="form-control" type="text">
                                <div class="input-group-btn">
                                    <button type="button" id="btnsavenomorsk" onclick="savenomorsk()" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tentang SK</label>
                            <div class="input-group">
                                <input name="tentangsk" id="tentangsk" class="form-control" type="text">
                                <div class="input-group-btn">
                                    <button type="button" id="btnsavetentangsk" onclick="savetentangsk()" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Rektor</label>
                            <div class="input-group">
                                <input name="namarektor" id="namarektor" class="form-control" type="text">
                                <div class="input-group-btn">
                                    <button type="button" id="btnsavenamarektor" onclick="savenamarektor()" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>NIP Rektor</label>
                            <div class="input-group">
                                <input name="niprektor" id="niprektor" class="form-control" type="text">
                                <div class="input-group-btn">
                                    <button type="button" id="btnsaveniprektor" onclick="saveniprektor()" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">   
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Pengaturan Undangan Sesama</h3> 
            </div>
            <div class="box-body">
                <div class="form">
                    <div class="form-body">
                        <div class="form-group">
                            <label>Tgl. Surat</label>
                            <div class="input-group">
                                <input name="tglundangan" id="tglundangan" class="form-control" type="text">
                                <div class="input-group-btn">
                                    <button type="button" id="btnsavetglundangan" onclick="savetglundangan()" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <label>Nomor Surat</label>
                            <div class="input-group">
                                <input name="nomorundangan" id="nomorundangan" class="form-control" type="text">
                                <div class="input-group-btn">
                                    <button type="button" id="btnsavenomorundangan" onclick="savenomorundangan()" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <label>Perihal</label>
                            <div class="input-group">
                                <input name="perihalundangan" id="perihalundangan" class="form-control" type="text">
                                <div class="input-group-btn">
                                    <button type="button" id="btnsaveperihalundangan" onclick="saveperihalundangan()" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <label>Tgl. Registrasi</label>
                            <div class="input-group">
                                <input name="tglregist" id="tglregist" class="form-control" type="text">
                                <div class="input-group-btn">
                                    <button type="button" id="btnsavetglregist" onclick="savetglregist()" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <label>Nomor Pengumuman</label>
                            <div class="input-group">
                                <input name="nopengumuman" id="nopengumuman" class="form-control" type="text">
                                <div class="input-group-btn">
                                    <button type="button" id="btnsavenopengumuman" onclick="savenopengumuman()" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                          <div class="form-group">
                            <label>Gambar Pengesah</label>
                            <div class="input-group">
                                <input name="filettd" id="filettd" class="form-control" type="file">
                                <div class="input-group-btn">
                                    <button type="button" id="btnsavefilettd" onclick="savefilettd()" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</form>
</div>


<script src="<?php echo base_url('public/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('public/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('public/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('public/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>

<script type="text/javascript">
$(document).ready(function() {
     $("#mnpengaturan").addClass('active');
    $.ajax({
            type: "POST",
            url: "<?php echo site_url('pengaturan/pengaturan_list')?>",
            dataType: 'JSON',
            success: function(data){
                $('[name="namarektor"]').val(data.namarektor);
                $('[name="niprektor"]').val(data.niprektor);
                $('[name="lampiransk"]').val(data.lampiransk);
                $('[name="nomorsk"]').val(data.nomorsk);
                $('[name="tentangsk"]').val(data.tentangsk);
                $('[name="tglundangan"]').val(data.tglundangan);
                $('[name="nomorundangan"]').val(data.nomorundangan);
                $('[name="perihalundangan"]').val(data.perihalundangan);
                $('[name="tglregist"]').val(data.tglregist);
                $('[name="nopengumuman"]').val(data.nopengumuman);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Gagal Proses');
            }
        });
}); 

function savesesipilihan(){
    var sesipilihan = $('#sesipilihan').val();
    $.ajax({
        url : "<?php echo base_url('pengaturan/simpansesipilihan')?>",
        type: "POST",
        dataType: "JSON",
        data: {'sesipilihan': sesipilihan},
        success: function(data)
        {
            if (data.hasil == "sukses") {
                alert('Perubahan Sesi Pilihan berhasil disimpan.');
            }
        }
    });
}

function savetahunakademik(){
    var tahunakademik = $('#tahunakademik').val();
    $.ajax({
        url : "<?php echo base_url('pengaturan/simpantahunakademik')?>",
        type: "POST",
        dataType: "JSON",
        data: {'tahunakademik': tahunakademik},
        success: function(data)
        {
            if (data.hasil == "sukses") {
                alert('Perubahan Tahun Akademik berhasil disimpan.');
            }
        }
    });
}

function savenamarektor(){
    var namarektor = $('#namarektor').val();
    $.ajax({
        url : "<?php echo base_url('pengaturan/simpannamarektor')?>",
        type: "POST",
        dataType: "JSON",
        data: {'namarektor': namarektor},
        success: function(data)
        {
            if (data.hasil == "sukses") {
                alert('Perubahan Nama Rektor berhasil disimpan.');
            }
        }
    });
}

function saveniprektor(){
    var niprektor = $('#niprektor').val();
    $.ajax({
        url : "<?php echo base_url('pengaturan/simpanniprektor')?>",
        type: "POST",
        dataType: "JSON",
        data: {'niprektor': niprektor},
        success: function(data)
        {
            if (data.hasil == "sukses") {
                alert('Perubahan NIP Rektor berhasil disimpan.');
            }
        }
    });
}


function savestatususer(){
    var statususer = $('#statususer').val();
    $.ajax({
        url : "<?php echo base_url('pengaturan/simpanstatususer')?>",
        type: "POST",
        dataType: "JSON",
        data: {'statususer': statususer},
        success: function(data)
        {
            if (data.hasil == "sukses") {
                alert('Perubahan Status User berhasil disimpan.');
            }
        }
    });
}

function savelampiransk(){
    var lampiransk = $('#lampiransk').val();
    $.ajax({
        url : "<?php echo base_url('pengaturan/simpanlampiransk')?>",
        type: "POST",
        dataType: "JSON",
        data: {'lampiransk': lampiransk},
        success: function(data)
        {
            if (data.hasil == "sukses") {
                alert('Perubahan Lampiran SK berhasil disimpan.');
            }
        }
    });
}

function savenomorsk(){
    var nomorsk = $('#nomorsk').val();
    $.ajax({
        url : "<?php echo base_url('pengaturan/simpannomorsk')?>",
        type: "POST",
        dataType: "JSON",
        data: {'nomorsk': nomorsk},
        success: function(data)
        {
            if (data.hasil == "sukses") {
                alert('Perubahan Nomor SK berhasil disimpan.');
            }
        }
    });
}

function savetentangsk(){
    var tentangsk = $('#tentangsk').val();
    $.ajax({
        url : "<?php echo base_url('pengaturan/simpantentangsk')?>",
        type: "POST",
        dataType: "JSON",
        data: {'tentangsk': tentangsk},
        success: function(data)
        {
            if (data.hasil == "sukses") {
                alert('Perubahan Tentang SK berhasil disimpan.');
            }
        }
    });
}

function savetglundangan(){
    var tglundangan = $('#tglundangan').val();
    $.ajax({
        url : "<?php echo base_url('pengaturan/simpantglundangan')?>",
        type: "POST",
        dataType: "JSON",
        data: {'tglundangan': tglundangan},
        success: function(data)
        {
            if (data.hasil == "sukses") {
                alert('Perubahan Tanggal Undangan berhasil disimpan.');
            }
        }
    });
}

function savenomorundangan(){
    var nomorundangan = $('#nomorundangan').val();
    $.ajax({
        url : "<?php echo base_url('pengaturan/simpannomorundangan')?>",
        type: "POST",
        dataType: "JSON",
        data: {'nomorundangan': nomorundangan},
        success: function(data)
        {
            if (data.hasil == "sukses") {
                alert('Perubahan Nomor Undangan berhasil disimpan.');
            }
        }
    });
}

function saveperihalundangan(){
    var perihalundangan = $('#perihalundangan').val();
    $.ajax({
        url : "<?php echo base_url('pengaturan/simpanperihalundangan')?>",
        type: "POST",
        dataType: "JSON",
        data: {'perihalundangan': perihalundangan},
        success: function(data)
        {
            if (data.hasil == "sukses") {
                alert('Perubahan Perihal Undangan berhasil disimpan.');
            }
        }
    });
}

function savetglregist(){
    var tglregist = $('#tglregist').val();
    $.ajax({
        url : "<?php echo base_url('pengaturan/simpantglregist')?>",
        type: "POST",
        dataType: "JSON",
        data: {'tglregist': tglregist},
        success: function(data)
        {
            if (data.hasil == "sukses") {
                alert('Perubahan Tanggal Registrasi berhasil disimpan.');
            }
        }
    });
}
</script>
</body>
</html>