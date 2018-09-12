<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    $routerclass = $this->router->class;
    $segment = $this->router->class."/".$this->router->method;

    // print_r($this->_data['user']);exit;
?>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a <?php if($segment=="dashboard/index") { ?> class="active" <?php } ?> href="<?=site_url('/dashboard');?>">
                    <i class="fa fa-dashboard fa-fw"></i> Dashboard
                </a>
            </li>
            <?php if($this->_data['user']->class=="User"){ ?>
                <li <?php if($routerclass=="mahasiswa") { ?> class="active" <?php } ?> >
                    <a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Mahasiswa<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="mahasiswa/lists" <?php if($segment=="mahasiswa/lists") { ?> class="active" <?php } ?> >Daftar Mahasiswa</a>
                        </li>
                        <li>
                            <a href="mahasiswa/create" <?php if($segment=="mahasiswa/create") { ?> class="active" <?php } ?> >Tambah Mahasiswa</a>
                        </li>
                    </ul>
                </li>
                <li <?php if($routerclass=="dosen-pembimbing") { ?> class="active" <?php } ?> >
                    <a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Dosen Pembimbing<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="dosen-pembimbing/lists" <?php if($segment=="dosen-pembimbing/lists") { ?> class="active" <?php } ?> >Daftar Dosen Pembimbing</a>
                        </li>
                        <li>
                            <a href="dosen-pembimbing/create" <?php if($segment=="dosen-pembimbing/create") { ?> class="active" <?php } ?> >Tambah Dosen Pembimbing</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php if($this->_data['user']->class!="Mahasiswa"){ ?>
                <li <?php if($routerclass=="bimbingan") { ?> class="active" <?php } ?> >
                    <a href="#"><i class="fa fa-book fa-fw"></i> Bimbingan<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="bimbingan/lists" <?php if($segment=="bimbingan/lists") { ?> class="active" <?php } ?> >Daftar bimbingan</a>
                        </li>
                        <?php if($this->_data['user']->class=="User"){ ?>
                            <li>
                                <a href="bimbingan/create" <?php if($segment=="bimbingan/create") { ?> class="active" <?php } ?> >Tambah bimbingan</a>
                            </li>
                        <?php } ?>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
            <?php } elseif($this->_data['user']->class=="Mahasiswa") { ?>
                <li>
                    <a <?php if($segment=="catatan/lists") { ?> class="active" <?php } ?> href="<?=site_url('/catatan/lists');?>">
                        <i class="fa fa-calendar fa-fw"></i> Catatan Bimbingan
                    </a>
                </li>
                <li>
                    <a <?php if($segment=="catatan/cetaksurat") { ?> class="active" <?php } ?> href="<?=site_url('/catatan/cetaksurat');?>">
                        <i class="fa fa-print fa-fw"></i> Cetak Lembar Persetujuan
                    </a>
                </li>
            <?php  } ?>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->