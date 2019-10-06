<div class="col-xl-12 main">
    <div class="row">
        <div class="col-xl-6">
            <div class="top-block">Задачи</div>
        </div>
        <div class="col-xl-6">
            <div class="right-block">
                <a href="/site/addtask" class="btn add-task">Добавить задачу</a>
                <?if(!$_SESSION['admin']){?>
                    <a href="/user/login" class="btn btn-login-top">Войти</a>
                <?}else{?>
                    <a href="/user/logout" class="btn btn-login-top">Выйти</a>
                <?}?>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row_main">
    <div class="col-xl-12">
        <div class="row">
            <?if($_SESSION['admin']){?>
            <div class="col-xl-2 sort" data-sort="username">Пользователь</div>
            <div class="col-xl-2 sort" data-sort="email">E-mail</div>
            <div class="col-xl-4">Текст</div>
            <div class="col-xl-2 sort" data-sort="status">Статусы</div>
            <div class="col-xl-2 sort" data-sort="status">Редактировать</div>
            <?}else{?>
                <div class="col-xl-3 sort" data-sort="username">Пользователь</div>
                <div class="col-xl-3 sort" data-sort="email">E-mail</div>
                <div class="col-xl-4">Текст</div>
                <div class="col-xl-2 sort" data-sort="status">Статусы</div>
            <?}?>
        </div>
    </div>
    <div class="main-sort">
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
    </div>
</div>
<div class="pagination">
    <nav>
        <ul class="pagination">
            <li class="page-item <?if($_SESSION['page'] == 1) echo 'active'?>"><a class="page-link" href="/">1</a></li>
            <?$inc = 2;for($i = 1; $i <= $_SESSION['counttasks']; $i++){?>
                <?if($i != 1 && ($i - 1) % \app\models\Tasks::$limit == 0){?>
                    <li class="page-item <?if($_SESSION['page'] == $inc) echo 'active'?>"><a class="page-link" href="/site/index/?page=<?=$inc?>"><?=$inc?></a></li>
                <?$inc++;}?>
            <?}?>
        </ul>
    </nav>
</div>