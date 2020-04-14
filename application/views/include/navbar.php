

  <header class="main-header">
    <!-- Logo -->
    <a href="<?= base_url('dashboard');?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?= base_url() ?>public/dist/img/logo.png" width="30" height="30" alt="Sistem Admisi Unipa"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?= base_url() ?>public/dist/img/logo.png" width="45" height="45" alt="Sistem Admisi Unipa"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu"  role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= base_url() ?>public/dist/img/dosen.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?= $this->session->userdata('identity'); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= base_url() ?>public/dist/img/dosen.png" class="img-circle" alt="User Image">
                <?php
                  if($this->ion_auth->user()->row()->company=='ADMIN'){
                    echo '<p>ADMINISTRATOR</p>';
                  } else {
                    echo '<p class="font-size:10px;">'.$this->ion_auth->get_fakultas()->namafakultas.'</p>';
                  }
                ?>              
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?= site_url('auth/logout'); ?>" class="btn btn-default btn-flat">Log Out</a>
                </div>
                <div class="pull-left">
                  <a href="#" onclick="edit_password(<?=$this->ion_auth->user()->row()->id;?>)" class="btn btn-default btn-flat">Ubah Password</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav> 
  </header>
