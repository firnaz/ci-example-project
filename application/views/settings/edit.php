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
                    <h1 class="page-header">Settings</h1>
                    <div class="panel">
                        <?php
                            if($msg){
                        ?>
                        <div class="alert alert-<?=$msg["type"];?>"><?=$msg["text"];?></div>
                        <?php        
                            }
                        ?>
                        <div class="col-md-6">
                            <form role="form" method="post" enctype="multipart/form-data" action="settings/update">
                                <?php foreach($results as $result){ ?>
                                    <div class="form-group" method="post">
                                        <label><?=$result->name?></label>
                                        <input class="form-control" type="text" name="settings[<?=$result->ID?>]" value="<?=$result->value?>">
                                    </div>
                                <?php } ?>
                                <button type="submit" class="btn btn-primary">Simpan</button>
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

