<div class="col-xl-12 main">
    <div class="row">
        <div class="col-xl-6">
            <a href="/">Вернуться на главную</a>
            <div class="top-block">
                <?if(!isset($params)) echo 'Добавление задачи';else echo 'Редактирование задачи';?>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="right-block edit-add">
                <input type="submit" value="Сохранить" class="btn btn-success <?if(!isset($params)) echo 'add_task';else echo 'edit_task';?>">
            </div>
        </div>
    </div>
</div>
<hr>
<div class="">
    <div class="success" style="display:none;">
        <?if(!isset($params)){?>Спасибо, задача успешно добавленна!<?}else{?>
            Спасибо, задача успешно обновлена!
        <?}?>
    </div>
    <form class="form-add-task">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-3 add-top">
                    <?if(isset($params)){?>
                        <input type="hidden" name="id" value="<?=$params['id']?>" class="model_id">
                    <?}?>
                    <div>
                        <label>Пользователь</label><input class="form_model" type="text" name="username" value="<?=$params['username']?>"><div class="error error-username"></div>
                    </div>
                    <div>
                        <label>E-mail</label><input class="form_model" type="text" name="email" value="<?=$params['email']?>"><div class="error error-email"></div>
                    </div>
                    <div>
                        <label>Текст</label><textarea class="form_model" name="text"><?=$params['text']?></textarea><div class="error error-text"></div>
                    </div>
                    <?if(isset($params)){?>
                        <label>Статус</label><input type="checkbox" name="status" value="1" <?if($params['status'] == 1) echo 'checked';?>>
                    <?}?>
                </div>
            </div>
        </div>
    </form>
</div>