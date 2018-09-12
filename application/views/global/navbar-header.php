        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="dashboard">Sistem Bimbingan Skripsi v1.0</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li><?=$this->session->userdata("user")["nama"];?></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <?php if($this->_data['user']->class=="User") { ?>
                        <li><a href="<?=site_url('settings/edit');?>"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                        <li class="divider"></li>
                    <?php } ?>
                    <li><a href="<?=site_url('dashboard/change-password');?>"><i class="fa fa-key fa-fw"></i> Ubah Password</a>
                    </li>
                    <li><a href="<?=site_url('dashboard/pedoman-skripsi');?>"><i class="fa fa-file-o fa-fw"></i> Pedoman Skripsi</a>
                    </li>
                    <li><a href="<?=site_url('login/logout');?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->
