<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view("global/header");
?>
<div id="wrapper">
    <?php $this->load->view("global/navigation"); ?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Catatan Bimbingan</h1>
                    <?php
                        if($msg){
                    ?>
                    <div class="alert alert-<?=$msg["type"];?>"><?=$msg["text"];?></div>
                    <?php        
                        }

                        $cls = "panel-primary";
                        
                        $tgl_skr = time();
                        $tgl_berakhir = strtotime($Bimbingan->tgl_berakhir);
                        $selisih_tanggal = floor(($tgl_berakhir-$tgl_skr)/(60*60*24));
                        
                        if ($selisih_tanggal<=7){
                            $cls = "panel-danger";
                        }else if ($selisih_tanggal<=30){
                            $cls = "panel-warning";                                                    
                        }
                    ?>

                    <div class="panel <?=$cls;?>">
                        <div class="panel-heading"><strong>Informasi Bimbingan</strong></div>
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>NIM</dt>
                                <dd><?=$Mahasiswa->NIM?></dd>
                                <dt>Nama Mahasiswa</dt>
                                <dd><?=$Mahasiswa->nama?></dd>
                                <dt>Tahun Masuk</dt>
                                <dd><?=$Mahasiswa->tahun_masuk?></dd>
                                <dt>Judul Skripsi</dt>
                                <dd><?=$Bimbingan->judul_skripsi?></dd>
                                <dt>Tanggal Pengesahan</dt>
                                <dd><?=date("d-m-Y",strtotime($Bimbingan->tgl_sah))?></dd>
                                <dt>Tanggal Berakhir</dt>
                                <dd><?=date("d-m-Y",strtotime($Bimbingan->tgl_berakhir))?></dd>
                            </dl>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Dosen Pembimbing</th>
                                        <th>Seminar Proposal</th>
                                        <th>Seminar Hasil</th>
                                        <th>Sidang Skripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?=$Dosen1->nama?></td>
                                        <?php if($this->_data['user']->class=="Dosen" && $Dosen1->DosenID==$this->_data['user']->ID) { ?>
                                            <td align="center">
                                                <?php if($Dosen1->tgl_proposal) { ?>
                                                    <i class="fa fa-check"></i>
                                                <?php } else { ?>
                                                    <a class="btn btn-success" onclick="return confirm('Apakah anda setuju agar mahasiswa ini melaksanakan seminar proposal?');" href="catatan/proposal">Setujui seminar proposal</a>
                                                <?php } ?>
                                            </td>
                                            <td align="center">
                                                <?php if($Dosen1->tgl_proposal && $Dosen2->tgl_proposal) { 
                                                        if($Dosen1->tgl_seminar){ ?>
                                                            <i class="fa fa-check"></i>   
                                                <?php   } else { ?>
                                                           <a class="btn btn-success" onclick="return confirm('Apakah anda setuju agar mahasiswa ini melaksanakan seminar hasil?');" href="catatan/seminar">Setujui seminar hasil</a>
                                                <?php   }
                                                    } else { ?>
                                                    <i class="fa fa-times"></i>
                                                <?php } ?>
                                            </td>
                                            <td align="center">
                                                <?php if($Dosen1->tgl_seminar && $Dosen2->tgl_seminar) { 
                                                        if($Dosen1->tgl_sidang){ ?>
                                                            <i class="fa fa-check"></i>   
                                                <?php   } else { ?>
                                                           <a class="btn btn-success" onclick="return confirm('Apakah anda setuju agar mahasiswa ini melaksanakan sidang?');" href="catatan/sidang">Setujui sidang</a>
                                                <?php   }
                                                    } else { ?>
                                                    <i class="fa fa-times"></i>
                                                <?php } ?>
                                            </td>
                                        <?php }else{ ?> 
                                            <td align="center">
                                                <?=($Dosen1->tgl_proposal)?'<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>';?>
                                            </td>
                                            <td align="center">
                                                <?=($Dosen1->tgl_seminar)?'<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>';?>
                                            </td>
                                            <td align="center">
                                                <?=($Dosen1->tgl_sidang)?'<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>';?>
                                            </td>
                                        <?php }?>
                                    </tr>
                                    <tr>
                                        <td><?=$Dosen2->nama?></td>
                                        <?php if($this->_data['user']->class=="Dosen" && $Dosen2->DosenID==$this->_data['user']->ID) { ?>
                                            <td align="center">
                                                <?php if($Dosen2->tgl_proposal) { ?>
                                                    <i class="fa fa-check"></i>
                                                <?php } else { ?>
                                                    <a class="btn btn-success" onclick="return confirm('Apakah anda setuju agar mahasiswa ini melaksanakan seminar proposal?');" href="catatan/proposal">Setujui seminar proposal</a>
                                                <?php } ?>
                                            </td>
                                            <td align="center">
                                                <?php if($Dosen1->tgl_proposal && $Dosen2->tgl_proposal) { 
                                                        if($Dosen2->tgl_seminar){ ?>
                                                            <i class="fa fa-check"></i>   
                                                <?php   } else { ?>
                                                           <a class="btn btn-success" onclick="return confirm('Apakah anda setuju agar mahasiswa ini melaksanakan seminar hasil?');" href="catatan/seminar">Setujui seminar hasil</a>
                                                <?php   }
                                                    } else { ?>
                                                    <i class="fa fa-times"></i>
                                                <?php } ?>
                                            </td>
                                            <td align="center">
                                                <?php if($Dosen1->tgl_seminar && $Dosen2->tgl_seminar) { 
                                                        if($Dosen2->tgl_sidang){ ?>
                                                            <i class="fa fa-check"></i>   
                                                <?php   } else { ?>
                                                           <a class="btn btn-success" onclick="return confirm('Apakah anda setuju agar mahasiswa ini melaksanakan sidang?');" href="catatan/sidang">Setujui sidang</a>
                                                <?php   }
                                                    } else { ?>
                                                    <i class="fa fa-times"></i>
                                                <?php } ?>
                                            </td>
                                        <?php }else{ ?> 
                                            <td align="center">
                                                <?=($Dosen2->tgl_proposal)?'<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>';?>
                                            </td>
                                            <td align="center">
                                                <?=($Dosen2->tgl_seminar)?'<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>';?>
                                            </td>
                                            <td align="center">
                                                <?=($Dosen2->tgl_sidang)?'<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>';?>
                                            </td>
                                        <?php }?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php if ($this->_data['user']->class=="Dosen"){ ?>
                        <div class="pull-right">
                            <a class="btn btn-default" href="<?=site_url("catatan/lists")?>#tambah">Tambah Catatan</a>
                        </div>
                    <?php } ?>
                    <h2 class="page-header">Daftar Catatan</h2>

                    <?php if (count($Pertemuan)>0){ ?>
                        <?php if($this->_data['user']->class=="User"){ ?>
                            <div class="dataTable_wrapper">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Judul</th>
                                                <th>Tanggal Bimbingan</th>
                                                <th>Dosen Pembimbing</th>
                                                <th>Arahan</th>
                                                <th>Konsultasi Berikutnya</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                        <?php } ?>                    
                        <?php foreach($Pertemuan as $bimbingan) { ?>
                            <?php if($this->_data['user']->class=="User"){ ?>
                                <tr>
                                    <td><?=$bimbingan->judul?></td>
                                    <td><?=date("d-m-Y",strtotime($bimbingan->tgl_bimbingan))?></td>
                                    <td><?=$bimbingan->dosen->nama?></td>
                                    <td><?=$bimbingan->arahan?></td>
                                    <td><?php if ($bimbingan->tgl_berikut) { echo date("d-m-Y", strtotime($bimbingan->tgl_berikut)); }?></td>
                                </tr>
                            <?php } else{ ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="pull-right">
                                            <?php if ($bimbingan->DosenID==$this->_data['user']->ID && $this->_data['user']->class=="Dosen") { ?>
                                                <?php if($bimbingan->readonly){ ?>
                                                    <a href="<?=site_url("catatan/unlock?id=$bimbingan->ID");?>" class="fa fa-lock"></a>
                                                <?php }else{ ?>
                                                    <a href="<?=site_url("catatan/lock?id=$bimbingan->ID");?>" class="fa fa-unlock"></a>
                                                <?php } ?>
                                                <a href="<?=site_url("catatan/delete?id=$bimbingan->ID");?>" class="fa fa-trash-o" onclick="return confirm('Apakah anda yakin ingin menghapus catatan ini?');"></a>
                                            <?php } ?>
                                        </div>
                                        <h4><strong><?=$bimbingan->judul?></strong></h4>
                                        <div class="pull-right">Dibuat pada: <?=date("d-m-Y", strtotime($bimbingan->tgl_bimbingan))?></div>
                                        <?php if ($bimbingan->DosenID){ ?>
                                            <div class="pull-left"><i class="glyphicon glyphicon-user"></i> <?=$bimbingan->dosen->nama?></div>
                                        <?php }else{ ?>
                                            <div class="pull-left"><i class="glyphicon glyphicon-user"></i> <?=$Mahasiswa->nama?></div>
                                        <?php } ?>
                                        <div>&nbsp;</div>
                                    </div>
                                    <div class="panel-body">
                                        <?=$bimbingan->arahan?>
                                        <?php if ($bimbingan->file){ ?> 
                                        <blockquote>
                                            <small>
                                            <i class="fa fa-paperclip"></i> <a href="<?=site_url('download/filebimbingan/'.$bimbingan->file->ID.'/'.$bimbingan->file->filename);?>"><?=$bimbingan->file->filename?> (<?=number_format($bimbingan->file->ukuran_file/1024)." Kb"?>)</a>
                                            </small>
                                        </blockquote>
                                        <?php } ?>
                                        <?php if ($bimbingan->tgl_berikut) { ?>
                                            <small>
                                                **Tanggal bimbingan berikutnya: <strong><?=date("d-m-Y", strtotime($bimbingan->tgl_berikut))?></strong>
                                            </small>
                                        <?php } ?>
                                        <p>

                                        <?php if ($bimbingan->balasan){ 
                                            foreach($bimbingan->balasan as $t){
                                        ?>
                                            <div 
                                                <?php if($t->DosenID) { ?>
                                                    class="panel panel-info"
                                                <?php } else{ ?>
                                                    class="panel panel-red"
                                                <?php } ?>
                                            >
                                                <div class="panel-heading">
                                                    <div class="pull-right">Dibuat pada: <?=date("d-m-Y", strtotime($t->tgl_bimbingan))?></div>
                                                    <?php if ($t->DosenID){ ?>
                                                        <div class="pull-left"><i class="glyphicon glyphicon-user"></i> <?=$t->dosen->nama?></div>
                                                    <?php }else{ ?>
                                                        <div class="pull-left"><i class="glyphicon glyphicon-user"></i> <?=$Mahasiswa->nama?></div>
                                                    <?php } ?>
                                                    <div>&nbsp;</div>
                                                </div>
                                                <div class="panel-body">
                                                    <?=$t->tanggapan?>
                                                    <?php if ($t->file){ ?> 
                                                    <blockquote>
                                                        <small>
                                                            <i class="fa fa-paperclip"></i> <a href="<?=site_url('download/filebimbingan/'.$t->file->ID.'/'.$t->file->filename);?>"><?=$t->file->filename?> (<?=number_format($t->file->ukuran_file/1024)." Kb"?>)</a>
                                                        </small>
                                                    </blockquote>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                    <?php 
                                            } 
                                        } 
                                    ?>
                                        </p>
                                    </div>
                                    <?php if (!$bimbingan->readonly && $this->_data['user']->class!="User"){ ?>
                                        <div class="panel-footer">
                                            <div class="col-lg-12">
                                            <form method="post" enctype="multipart/form-data" action="catatan/tanggapan" class="frmBalasan">
                                                <div class="form-group">  
                                                    <label>Tanggapan</label>
                                                    <textarea class="form-control" name="tanggapan" rows="4"></textarea>
                                                </div>
                                                <div class="form-group">  
                                                    <label>Upload File</label>
                                                    <input type="file" name="lampiran">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Balas</button>
                                                <input type="hidden" name="RefID" value="<?=$bimbingan->ID?>">
                                            </form>
                                            </div>
                                            <p>&nbsp;</p>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php }?>
                        <?php } ?>
                        <?php if($this->_data['user']->class=="User"){ ?>
                                </tbody>
                            </table>
                        <?php } ?>                    

                        <div class="dataTable_wrapper">
                            <?php $this->load->view("global/pagination"); ?>&nbsp;
                        </div>
                    <?php } else {?>
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading"><strong>Catatan</strong></div> -->
                            <div class="panel-body">
                                Belum terdapat catatan pada bimbingan ini.
                            </div>
                        </div>
                    <?php } ?>
                <?php if ($this->_data['user']->class=="Dosen") { ?>
                    <div class="panel panel-default">
                        <div class="panel-heading"><a name="tambah"><strong>Tambah Catatan Bimbingan</strong></a></div>
                        <div class="panel-body">
                            <form role="form" method="post" enctype="multipart/form-data" action="catatan/add" id="frmCatatanAdd">
                                <div class="form-group col-md-12">
                                    <label class="col-md-4">Tanggal</label>
                                    <div class="col-md-8">
                                        <?=date("d-m-Y")?>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-md-4">Judul Catatan</label>
                                    <div class="col-md-8">
                                    <input class="form-control" type="text" name="judul" value="">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-md-4">Arahan</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="arahan"></textarea>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-md-4">Tanggal Bimbingan Berikutnya</label>
                                    <div class="col-md-4">
                                        <div class='input-group date datepicker'>
                                            <input type='text' class="form-control" name="tanggal" value=""/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-md-4">Tidak dapat ditanggapi</label>
                                    <div class="col-md-4">
                                        <label class="checkbox-inline col-md-4">
                                            <input type="checkbox" value="1" name="readonly">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">  
                                    <label class="col-md-4">Upload File</label>
                                    <div class="col-md-4">
                                        <input type="file" name="lampiran">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                    <input type="hidden" name="DosenID" value="<?=$this->_data['user']->ID?>">
                                    <input type="hidden" name="tgl_berikut" value="">
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>

                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php $this->load->view("global/footer"); ?>
