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
                    <h1 class="page-header">Bimbingan</h1>
                    <div class="panel">
                        <div class="dataTable_wrapper">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>NIM / Mahasiswa</th>
                                            <th>Dosen Pembimbing 1</th>
                                            <th>Dosen Pembimbing 2</th>
                                            <th>Judul Skripsi</th>
                                            <th>Tanggal Sah</th>
                                            <th>Tanggal Berakhir</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 

                                            foreach($results as $key=>$result){ 
                                                $cls =($key%2==0)?"even":"odd";
                                                
                                                $tgl_skr = time();
                                                $tgl_berakhir = strtotime($result->tgl_berakhir);
                                                $selisih_tanggal = floor(($tgl_berakhir-$tgl_skr)/(60*60*24));
                                                
                                                if ($selisih_tanggal<=7){
                                                    $cls = "alert danger";
                                                }else if ($selisih_tanggal<=30){
                                                    $cls = "alert warning";                                                    
                                                }
                                        ?>
                                        <tr class="<?=$cls;?>">
                                            <td><?=$result->mahasiswa->NIM." / ".$result->mahasiswa->nama;?></td>
                                            <td><?=$result->dosen1->nama;?></td>
                                            <td><?=$result->dosen2->nama;?></td>
                                            <td><?=$result->judul_skripsi;?></td>
                                            <td><?=$result->tgl_sah;?></td>
                                            <td><?=$result->tgl_berakhir;?></td>
                                            <td class="center">
                                                <a href="<?=site_url("catatan/lists?id=$result->ID");?>" class="fa fa-calendar"></a> 
                                                <?php if($this->_data['user']->class=="User"){ ?>
                                                    <a href="<?=site_url("bimbingan/edit?id=$result->ID");?>" class="fa fa-edit"></a> 
                                                    <a href="<?=site_url("bimbingan/delete?id=$result->ID");?>" class="fa fa-trash-o" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');"></a>
                                                <?php } ?>
                                            </td>
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

