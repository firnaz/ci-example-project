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
                        if(isset($msg)){
                    ?>
                    <div class="alert alert-<?=$msg["type"];?>"><?=$msg["text"];?></div>
                    <?php        
                        }
                    ?>

                    <div class="panel <?php if ($Dosen1->tgl_proposal && $Dosen2->tgl_proposal){ ?>panel-default<?php }else{ ?>panel-red<?php } ?>">
                        <div class="panel-heading"><strong>Lembar Persetujuan Seminar Proposal</strong></div>
                        <div class="panel-body">
                            <?php if ($Dosen1->tgl_proposal && $Dosen2->tgl_proposal){ ?>
                                <a class="btn btn-primary" onclick='window.open("catatan/cetak-lembar-proposal","_blank","toolbar=no, scrollbars=yes, resizable=yes, width=850, height=1024")'><i class="fa fa-print"></i> Cetak Lembar Persetujuan Seminar Proposal</a>
                            <?php }else{ ?>
                                Seminar Proposal belum disetujui oleh dosen pembimbing.
                            <?php }?>
                        </div>
                    </div>
                    <div class="panel <?php if ($Dosen1->tgl_seminar && $Dosen1->tgl_seminar){ ?>panel-default<?php }else{ ?>panel-red<?php } ?>">
                        <div class="panel-heading"><strong>Lembar Persetujuan Seminar Hasil</strong></div>
                        <div class="panel-body">
                            <?php if ($Dosen1->tgl_seminar && $Dosen1->tgl_seminar){ ?>
                                <a class="btn btn-primary" onclick='window.open("catatan/cetak-lembar-seminar","_blank","toolbar=no, scrollbars=yes, resizable=yes, width=850, height=1024")'><i class="fa fa-print"></i> Cetak Lembar Persetujuan Seminar Hasil</a>
                            <?php }else{ ?>
                                Seminar Hasil belum disetujui oleh dosen pembimbing.
                            <?php }?>
                        </div>
                    </div>
                    <div class="panel <?php if ($Dosen1->tgl_sidang && $Dosen1->tgl_sidang){ ?>panel-default<?php }else{ ?>panel-red<?php } ?>">
                        <div class="panel-heading"><strong>Lembar Persetujuan Sidang Ujian Skripsi</strong></div>
                        <div class="panel-body">
                            <?php if ($Dosen1->tgl_sidang && $Dosen1->tgl_sidang){ ?>
                                <a class="btn btn-primary"><i class="fa fa-print"></i> Cetak Lembar Persetujuan Seminar Proposal</a>
                            <?php }else{ ?>
                                Sidang Ujian Skripsi belum disetujui oleh dosen pembimbing.
                            <?php }?>
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
