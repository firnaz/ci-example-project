<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view("global/header");
if(!$form){
    $form = ["judul_skripsi"=> "", "ID"=> "", "tgl_sah"=>"", "Dosen1ID"=>"", "Dosen2ID"=>"", "MahasiswaID"=>"", "tanggal"=>""];
}
?>
<div id="wrapper">
	<?php $this->load->view("global/navigation"); ?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?=($action=="add")?"Tambah":"Edit";?> Bimbingan</h1>
                    <div class="panel">
                        <?php
                            if($msg){
                        ?>
                        <div class="alert alert-<?=$msg["type"];?>"><?=$msg["text"];?></div>
                        <?php        
                            }
                        ?>
                        <div class="col-md-12">
                            <form role="form" method="post" enctype="multipart/form-data" id="frmUpdateBimbingan" <?php if($action=="add") { ?>  action="bimbingan/add"; <?php } else { ?> action="bimbingan/update"; <?php } ?> >
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Judul Skripsi</label>
                                        <input class="form-control" name="judul" value="<?=$form['judul_skripsi']?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Sah</label>
                                        <div class="form-group">
                                            <div class='input-group date datepicker'>
                                                <input type='text' class="form-control" name="tanggal" value="<?=$form['tanggal'];?>"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">  
                                        <label>Dokumen SK</label>
                                        <input type="file" name="filesk">
                                        <?php if($action=="update" && isset($form['filename'])) { ?> 
                                            <p class="help-block"><i class="fa fa-paperclip"></i> <a href="<?=site_url('download/filesk/'.$form['ID'].'/'.$form['filename']);?>"><?=$form['filename']?></a></p>
                                            <p class="help-block">Upload file baru untuk mengubah Dokumen SK.</p>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="col-md-10">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Mahasiswa</div>
                                        <div class="panel-body">
                                            <?php if($action=="add"){?>
                                            <div class="form-group">
                                                <div class='input-group'>
                                                    <input class="form-control" type="text" name="NIM" value="" placeholder="NIM">
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-search search-button-nim"></span>
                                                        <span class="spinner hide"><i class="fa fa-spin fa-refresh"></i></span>
                                                    </span>
                                                </div>   
                                            </div>
                                            <?php } ?>
                                            <div class="form-group col-md-10">
                                                <label class="col-md-4">NIM</label>
                                                <div class="nimmahasiswa col-md-4">
                                                    <?php if($action=="update"){?>
                                                        <?=$form["mahasiswa"]["NIM"]?>
                                                    <?php } ?> 
                                                </div>
                                            </div>
                                            <div class="form-group col-md-10">
                                                <label class="col-md-4">Nama</label>
                                                <div class="col-md-4 namamahasiswa">
                                                    <?php if($action=="update"){?>
                                                        <?=$form["mahasiswa"]["nama"]?>
                                                    <?php } ?> 
                                                </div>
                                            </div>
                                            <div class="form-group col-md-10">
                                                <label class="col-md-4">Tahun Masuk</label>
                                                <div class="col-md-4 tahunmasukmahasiswa">
                                                    <?php if($action=="update"){?>
                                                        <?=$form["mahasiswa"]["tahun_masuk"]?>
                                                    <?php } ?> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-10">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Dosen Pembimbing</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class='input-group  col-md-12'>
                                                    <div class="col-md-6">
                                                        <select class="form-control" name="dosen">
                                                            <option value="" selected="selected">Pilih Dosen</option>
                                                            <?php foreach($Dosens as $dosen){ ?>
                                                                <option value="<?=$dosen->ID?>"><?=$dosen->nama?></option>
                                                            <?php } ?>                                            
                                                        </select>
                                                    </div>
                                                <!-- </div> -->
                                                <!-- <div class='input-group'> -->
                                                    <label class="radio-inline">
                                                        <input type="radio" name="dosenpembimbing" value="1" checked="true"> Pembimbing 1
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="dosenpembimbing" value="2"> Pembimbing 2
                                                    </label>
                                                </div>
                                            </div>
                                            <div class='input-group pull-right'>
                                                <button type="button" class="btn btn-choose-dosen">Pilih Dosen</button>
                                                <div>&nbsp;</div>
                                            </div>

                                            <div class="form-group col-md-10">
                                                <label class="col-md-6">Dosen Pembimbing 1</label>
                                                <div class="col-md-4 dosen1">
                                                    <?php if($action=="update"){?>
                                                            <?=$form["dosen1"]["nama"]?>
                                                    <?php } ?> 
                                                </div>
                                            </div>
                                            <div class="form-group col-md-10">                                            
                                                <label class="col-md-6">Dosen Pembimbing 2</label>
                                                <div class="col-md-4 dosen2">
                                                    <?php if($action=="update" && $form["dosen2"]){?>
                                                            <?=$form["dosen2"]["nama"]?>
                                                    <?php } ?> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <input type="hidden" name="tgl_sah" value="<?=$form['tgl_sah'];?>">
                                    <input type="hidden" name="ID" value="<?=$form['ID'];?>">
                                    <input type="hidden" name="MahasiswaID" value="<?=$form['MahasiswaID'];?>">
                                    <input type="hidden" name="Dosen1ID" value="<?=$form['Dosen1ID'];?>">
                                    <input type="hidden" name="Dosen2ID" value="<?=$form['Dosen2ID'];?>">
                                </div>
                            </form>
                        </div>
                    </div>
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

