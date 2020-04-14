
<section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?=$kuotapenerimaan;?></h3>

              <p>Kuota Penerimaan</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?= base_url('prodi'); ?>" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
       <!-- ./col -->

        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?=$totalpendaftar;?></h3>

              <p>Pendaftar</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?= base_url('pendaftar'); ?>" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?=$totalterima;?></h3>

              <p>Diterima</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?= base_url('penerimaan'); ?>" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->


    <div class="row">
      <div class="col-md-12">
        <!-- Donut chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Peminatan Per Program Studi</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id ="mygraph1"></div>
            </div>
            <!-- /.box-body-->
          </div>
        </div>
</div>


    <div class="row">
      <div class="col-md-6">
        <!-- Donut chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Presentasi Jumlah Peminat Berdasarkan Suku</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="mygraph4"></div>
            </div>
            <!-- /.box-body-->
          </div>
        </div>

        <div class="col-md-6">
        <!-- Donut chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Presentasi Jumlah Peminat Berdasarkan Tahun Lulus</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="mygraph5"></div>
            </div>
            <!-- /.box-body-->
          </div>
        </div>
</div>

 <div class="row">
      <div class="col-md-6">
        <!-- Donut chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Peminatan Berdasarkan Jenjang SLTA</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id ="mygraph2"></div>
            </div>
            <!-- /.box-body-->
          </div>
        </div>

        <div class="col-md-6">
        <!-- Donut chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Peminatan Berdasarkan Jurusan SLTA</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id ="mygraph3"></div>
            </div>
            <!-- /.box-body-->
          </div>
        </div>
</div>


<!-- jQuery 3 -->
<script src="<?php echo base_url('public/bower_components/jquery/dist/jquery.min.js');?>"></script>
<!-- FastClick -->
<script src="<?php echo base_url('public/bower_components/fastclick/lib/fastclick.js');?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('public/dist/js/adminlte.min.js');?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('public/dist/js/demo.js');?>"></script>
<!-- highcharts -->
<script src="<?php echo base_url('public/chart/highcharts.js');?>"></script>
<!-- page script -->
<script>


 var chart1; 
 var chart2;
 var chart3;
 var chart4;
 var chart5;
 
        $(document).ready(function() {
          /* GRAFIK PEMINATAN PER PRODI */
              chart1 = new Highcharts.Chart(
              {
                  
                 chart: {
                    renderTo: 'mygraph1',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                 },   
                 title: {
                    text: 'Peminatan Berdasarkan Pilihan Program Studi'
                 },
                 tooltip: {
                    formatter: function() {
                        return '<b>'+
                        this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' % ';
                    }
                 },
                 
                
                 plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            color: '#000000',
                            connectorColor: 'green',
                            formatter: function() 
                            {
                                return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.percentage, 2) +' % ';
                            }
                        }
                    }
                 },
       
                    series: [{
                    type: 'pie',
                    name: 'Browser share',
                    data: [
                    <?php
                        foreach($list as $row) {
                          $prodiname = $row->namaprodi;
                          $peminat = $row->peminat;
                          ?>
                            [ 
                                '<?php echo $prodiname ?>', <?php echo $peminat; ?>
                            ],
                            <?php
                        }
                        ?>
             
                    ]
                }]
              });



            /* GRAFIK PEMINATAN BERDASARKAN JENJANG SLTA */
              chart2 = new Highcharts.Chart(
              {
                  
                 chart: {
                    renderTo: 'mygraph2',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                 },   
                 title: {
                    text: 'Peminatan Berdasarkan Jenjang SLTA '
                 },
                 tooltip: {
                    formatter: function() {
                        return '<b>'+
                        this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' % ';
                    }
                 },
                 
                
                 plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            color: '#000000',
                            connectorColor: 'green',
                            formatter: function() 
                            {
                                return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.percentage, 2) +' % ';
                            }
                        }
                    }
                 },
       
                    series: [{
                    type: 'pie',
                    name: 'Browser share',
                    data: [
                    <?php
                        foreach($jumlahjenjangslta as $row) {
                          $jenjangslta = $row->jenjangslta;
                          $jumlah = $row->jumlah;
                          ?>
                            [ 
                                '<?php echo $jenjangslta ?>', <?php echo $jumlah; ?>
                            ],
                            <?php
                        }
                        ?>
             
                    ]
                }]
              });

              /* GRAFIK PEMINATAN BERDASARKAN JURUSAN SLTA */
              chart3 = new Highcharts.Chart(
              {
                  
                 chart: {
                    renderTo: 'mygraph3',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                 },   
                 title: {
                    text: 'Peminatan Berdasarkan Jurusan SLTA'
                 },
                 tooltip: {
                    formatter: function() {
                        return '<b>'+
                        this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' % ';
                    }
                 },
                 
                
                 plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            color: '#000000',
                            connectorColor: 'green',
                            formatter: function() 
                            {
                                return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.percentage, 2) +' % ';
                            }
                        }
                    }
                 },
       
                    series: [{
                    type: 'pie',
                    name: 'Browser share',
                    data: [
                    <?php
                        foreach($jumlahjurusanslta as $row) {
                          $jurusanslta = $row->jurusanslta;
                          $jumlah = $row->jumlah;
                          ?>
                            [ 
                                '<?php echo $jurusanslta ?>', <?php echo $jumlah; ?>
                            ],
                            <?php
                        }
                        ?>
             
                    ]
                }]
              });

              /* GRAFIK PEMINATAN BERDASARKAN SUKU */
              chart4 = new Highcharts.Chart(
              {
                  
                 chart: {
                    renderTo: 'mygraph4',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                 },   
                 title: {
                    text: 'Presentasi Jumlah Peminat Berdasarkan Suku'
                 },
                 tooltip: {
                    formatter: function() {
                        return '<b>'+
                        this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' % ';
                    }
                 },
                 
                
                 plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            color: '#000000',
                            connectorColor: 'green',
                            formatter: function() 
                            {
                                return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.percentage, 2) +' % ';
                            }
                        }
                    }
                 },
       
                    series: [{
                    type: 'pie',
                    name: 'Browser share',
                    data: [
                    <?php
                        foreach($jumlahsuku as $row) {
                          $suku = $row->suku;
                          $jumlah = $row->jumlah;
                          ?>
                            [ 
                                '<?php echo $suku ?>', <?php echo $jumlah; ?>
                            ],
                            <?php
                        }
                        ?>
             
                    ]
                }]
              });

              /* GRAFIK PEMINATAN BERDASARKAN TAHUN LULUS */
              chart5 = new Highcharts.Chart(
              {
                  
                 chart: {
                    renderTo: 'mygraph5',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                 },   
                 title: {
                    text: 'Presentasi Jumlah Peminat Berdasarkan Tahun Lulus'
                 },
                 tooltip: {
                    formatter: function() {
                        return '<b>'+
                        this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' % ';
                    }
                 },
                 
                
                 plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            color: '#000000',
                            connectorColor: 'green',
                            formatter: function() 
                            {
                                return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.percentage, 2) +' % ';
                            }
                        }
                    }
                 },
       
                    series: [{
                    type: 'pie',
                    name: 'Browser share',
                    data: [
                    <?php
                        foreach($jumlahtahunlulus as $row) {
                          $tahunlulus = $row->tahunlulus;
                          $jumlah = $row->jumlah;
                          ?>
                            [ 
                                '<?php echo $tahunlulus ?>', <?php echo $jumlah; ?>
                            ],
                            <?php
                        }
                        ?>
             
                    ]
                }]
              });
        }); 


</script>