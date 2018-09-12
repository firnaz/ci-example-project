<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Login</h3>
                </div>
                <div class="panel-body">
                    <?php
                        if($msg){
                    ?>
                    <div class="alert alert-<?=$msg["type"];?>"><?=$msg["text"];?></div>
                    <?php        
                        }
                    ?>
                    <form role="form" method="post" enctype="multipart/form-data" action="login/otentikasi">
                        <fieldset>
                            <!-- <div class="form-group">
                            	<select class="form-control" name="user_type">
                            		<option value="" selected="selected">Pilih tipe user</option>
                            		<option value="Mahasiswa">Mahasiswa</option>
                            		<option value="Dosen">Dosen</option>
                            		<option value="User">Pengelola</option>
                            	</select>
                            </div> -->
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
							<button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                            <p>Download <a href="<?=$this->_settings["pedoman_skripsi"];?>">Pedoman Penulisan Skripsi</p></div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
