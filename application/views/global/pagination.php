<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$segment = $this->router->class."/".$this->router->method;
?>
<div class="col-md-6">
    <div class="pagination">
        Menampilkan data ke <?=$pagination["currentrecord"]?> hingga <?=$pagination["lastrecord"];?> dari total <?=$pagination["totalrecord"];?>
    </div>
</div>
<div class="col-md-6">
    <div class="paging_simple_numbers text-right">
        <ul class="pagination">
            <?php if($pagination["currentpage"]>1){ $prevpage=$pagination["currentpage"]-1; ?> 
            <li class="paginate_button previous" tabindex="0">
                <a href="<?=site_url($segment."?page=$prevpage")?>">Previous</a>
            </li>
            <?php } ?>
            <?php for($i=1; $i<=$pagination["totalpage"];$i++){ ?>
            <li class="paginate_button <?php if($pagination["currentpage"]==$i){ ?> active <?php } ?>" tabindex="0">
                <a href="<?=site_url($segment."?page=$i")?>"><?=$i;?></a>
            </li>
            <?php } ?>
            <?php if($pagination["currentpage"]<$pagination["totalpage"]){ $nextpage=$pagination["currentpage"]+1; ?> 
            <li class="paginate_button next" tabindex="0">
                <a href="<?=site_url($segment."?page=$nextpage")?>">Next</a>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
