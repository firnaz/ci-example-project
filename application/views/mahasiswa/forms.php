<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view("global/header");
if(!$form){
    $form = ["nama"=> "", "NIM"=> "", "tahun_masuk"=>""];
}
?>
<div id="wrapper">
	<?php $this->load->view("global/navigation"); ?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?=($action=="add")?"Tambah":"Edit";?> Mahasiswa</h1>
                    <div class="panel">
                        <?php
                            if($msg){
                        ?>
                        <div class="alert alert-<?=$msg["type"];?>"><?=$msg["text"];?></div>
                        <?php        
                            }
                        ?>
                        <div class="col-md-6">
                            <form role="form" method="post" enctype="multipart/form-data" <?php if($action=="add") { ?>  action="mahasiswa/add"; <?php } else { ?> action="mahasiswa/update"; <?php } ?> >
                                <div class="form-group" method="post">
                                    <label>NIM</label>
                                    <input class="form-control" type="text" name="NIM" value="<?=$form["NIM"]?>">
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input class="form-control" type="text" name="nama" value="<?=$form["nama"]?>">
                                </div>
                                <div class="form-group">
                                    <label>Tahun Masuk</label>
                                    <input class="form-control" type="text" name="tahun_masuk" value="<?=$form["tahun_masuk"]?>">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="password" name="password">
                                    <?php if($action=="update") { ?> 
                                        <p class="help-block">Jika password tidak diisi, password tidak akan diubah.</p>
                                    <?php } ?>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <?php if($action=="update") { ?> 
                                    <input class="form-control" type="hidden" name="ID" value="<?=$form['ID'];?>">
                                <?php } ?>
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

