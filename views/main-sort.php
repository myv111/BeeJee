<?foreach($params as $v){?>
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-3"><?=$v['username'];?></div>
            <div class="col-xl-3"><?=$v['email'];?></div>
            <div class="col-xl-3"><?=$v['text'];?></div>
            <div class="col-xl-3"><?=$v['status'];?><br /><?=$v['admin_update'];?></div>
        </div>
    </div>
<?}?>