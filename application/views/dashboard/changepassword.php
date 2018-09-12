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
                    <h1 class="page-header">Ubah Password</h1>
                    <div class="panel">
                        <?php
                            if($msg){
                        ?>
                        <div class="alert alert-<?=$msg["type"];?>"><?=$msg["text"];?></div>
                        <?php        
                            }
                        ?>
                        <div class="col-md-12">
                            <form role="form" method="post" enctype="multipart/form-data" action="dashboard/set-password">
                                <div class="form-group">
                                    <label>Password Lama</label>
                                    <input class="form-control" type="password" name="oldpassword" value="">
                                </div>
                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <input class="form-control" type="password" name="newpassword1" value="">
                                </div>
                                <div class="form-group">
                                    <label>Ulang Password Baru</label>
                                    <input class="form-control" type="password" name="newpassword2" value="">
                                </div>
                                <button type="submit" class="btn btn-primary">Ganti Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("global/footer"); ?>
