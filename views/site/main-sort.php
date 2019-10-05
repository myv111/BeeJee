<?foreach($params as $v){?>
    <div class="col-xl-12">
        <div class="row">
            <?if($_SESSION['admin']){?>
                <div class="col-xl-2"><?=$v['username'];?></div>
                <div class="col-xl-2"><?=$v['email'];?></div>
                <div class="col-xl-4"><?=$v['text'];?></div>
                <div class="col-xl-2">
                    <?if($v['status'] == 1) echo 'выполнено'; else echo 'выполняется';?>
                    <br />
                    <?if($v['admin_update'] == 1) echo 'отредактировано администратором';?>
                </div>
                <div class="col-xl-2 update"><a class="btn edit" href="/site/updatetask/?id=<?=$v['id']?>">Редактировать</a></div>
            <?}else{?>
                <div class="col-xl-3"><?=$v['username'];?></div>
                <div class="col-xl-3"><?=$v['email'];?></div>
                <div class="col-xl-4"><?=$v['text'];?></div>
                <div class="col-xl-2">
                    <?if($v['status'] == 1) echo 'выполнено'; else echo 'выполняется';?>
                    <br />
                    <?if($v['admin_update'] == 1) echo 'отредактировано администратором';?>
                </div>
            <?}?>
        </div>
    </div>
<?}?>