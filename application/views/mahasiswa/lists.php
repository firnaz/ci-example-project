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
                    <h1 class="page-header">Mahasiswa</h1>
                    <div class="panel">
                        <?php
                            if($msg){
                        ?>
                        <div class="alert alert-<?=$msg["type"];?>"><?=$msg["text"];?></div>
                        <?php        
                            }
                        ?>
                        <div class="dataTable_wrapper">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>Tahun Masuk</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($results as $key=>$result){ $cls =($key%2==0)?"even":"odd";?>
                                        <tr class="<?=$cls;?>">
                                            <td><?=$result->NIM;?></td>
                                            <td><?=$result->nama;?></td>
                                            <td><?=$result->tahun_masuk;?></td>
                                            <td class="center"><a href="<?=site_url("mahasiswa/edit?id=$result->ID");?>" class="fa fa-edit"></a> <a href="<?=site_url("mahasiswa/delete?id=$result->ID");?>" class="fa fa-trash-o" onclick="return confirm('Apakah anda yakin ingin menghapus mahasiswa ini?');"></a></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php $this->load->view("global/pagination"); ?>
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

