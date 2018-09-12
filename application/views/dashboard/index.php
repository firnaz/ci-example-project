<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view("global/header");
?>
<div id="wrapper">
	<?php $this->load->view("global/navigation"); ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Sistem Bimbingan Skripsi</h1>

                    <?php
                        if(isset($msg)){
                    ?>
                    <div class="alert alert-<?=$msg["type"];?>"><?=$msg["text"];?></div>
                    <?php        
                        }
                    ?>

                    <?php if ($this->_data["user"]->class=="Mahasiswa") { ?>
                    <div class="panel panel-primary">
                        <div class="panel-heading"><strong>Informasi Bimbingan</strong></div>
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>Judul Skripsi</dt>
                                <dd><?=$DosenPembimbing->judul_skripsi?></dd>
                                <dt>Tanggal Pengesahan</dt>
                                <dd><?=date("d-m-Y",strtotime($DosenPembimbing->tgl_sah))?></dd>
                                <dt>Bimbingan Selanjutnya</dt>
                                <dd>
                                    <?=$DosenPembimbing->bimbingan_selanjutnya?date("d-m-Y",strtotime($DosenPembimbing->bimbingan_selanjutnya)):""?>
                                </dd>
                            </dl>
                        </div>
                    </div>                        
                    <?php } elseif ($this->_data["user"]->class=="Dosen") { ?>
                        <h4>Daftar Bimbingan</h4>
                        <div class="dataTable_wrapper">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Judul</th>
                                            <th>Mahasiswa</th>
                                            <th>NIM</th>
                                            <th>Bimbingan Selanjutnya</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($DosenPembimbing as $key=>$result){ $cls =($key%2==0)?"even":"odd";?>
                                        <tr class="<?=$cls;?>">
                                            <td><?=$result->judul_skripsi;?></td>
                                            <td><?=$result->mahasiswa->nama;?></td>
                                            <td><?=$result->mahasiswa->NIM;?></td>
                                            <td><?=$result->bimbingan_selanjutnya?date("d-m-Y",strtotime($result->bimbingan_selanjutnya)):""?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>                        
                    <?php } else { ?>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("global/footer"); ?>

