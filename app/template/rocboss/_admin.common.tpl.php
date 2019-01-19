<?php die('Access Denied');?>
<section>
    <ol class="bz-breadcrumb">
        <li><a href="{$root}admin">Главная</a></li>
        <li class="bz-active">Опции</li>
    </ol>
    <div class="bz-panel bz-panel-default">
        <div class="bz-panel-hd">
            <h3 class="bz-panel-title">Настройки сайта</h3>
        </div>
        <div class="bz-panel-bd">
            <form method="post" class="bz-form bz-form-aligned">
                <fieldset>
                    <div class="bz-control-group">
                        <label>Название сайта:</label>
                        <input type="text" name="sitename" placeholder="название сайта" value="{$sys.sitename}" size="40">
                    </div>
                    <div class="bz-control-group">
                        <label>Ключевые слова:</label>
                        <input type="text" name="keywords" placeholder="ключевые слова сайта через пробел" value="{$sys.keywords}" size="40">
                    </div>
                    <div class="bz-control-group">
                        <label>Описание сайта:</label>
                        <textarea name="description" rows="4" cols="60">{$sys.description}</textarea>
                    </div>
                    <div class="bz-control-group">
                        <label>Секретный ключ:</label>
                        <input type="text" name="rockey" value="{$sys.rockey}" size="40"/> <em>иногда его меняйте, не менее 14 знаков</em>
                    </div>
                    <div class="bz-control-group">
                        <label>Регистрация:</label>
                        <select id="join_switch" name="join_switch">
                            <option value="1"{if $sys['join_switch'] == 1} selected{/if}>разрешена</option>
                            <option value="0"{if $sys['join_switch'] == 0} selected{/if}>запрещена</option>
                        </select>
                    </div>
                    <div class="bz-control-group">
                        <label>Шаблон:</label>
                        <select id="theme" name="theme">
                            {loop $tplName $name}
                            <option value="{$name}"{if $sys['theme'] == $name} selected{/if}>{$name}</option>
                            {/loop}
                        </select>
                    </div>

                    <div class="bz-control-group">
                        <label>За регистрацию:</label>
                        <input type="text" name="register" value="{$sys.scores_register}" size="4"/>
                            (начисление баллов за регистрацию- целое положительное число)
                    </div>
                    <div class="bz-control-group">
                        <label>За топик:</label>
                        <input type="text" name="topic" value="{$sys.scores_topic}" size="4"/>
                            (начисление баллов за создание топика - целое положительное число)
                    </div>
                    <div class="bz-control-group">
                        <label>За комментарий:</label>
                        <input type="text" name="reply" value="{$sys.scores_reply}" size="4"/>
                           (начисление баллов за добавление комментария - целое положительное число)
                    </div>
                    <div class="bz-control-group">
                        <label>За лайки:</label>
                        <input type="text" name="praise" value="{$sys.scores_praise}" size="4"/>
                             (начисление баллов за лайки - целое положительное число)
                    </div>
                    <div class="bz-control-group">
                        <label>За сообщения</label>
                        <input type="text" name="whisper" value="{$sys.scores_whisper}" size="4"/>
                           (начисление баллов за персональные сообщения - целое положительное число)
                    </div>
                    <div class="bz-control-group">
                        <label>QQ APPID：</label>
                        <input type="text" name="appid" value="{$sys.appid}" size="40"/> <em>для получения перейдите на <a href="http://connect.qq.com" target="_blank">http://connect.qq.com</a></em>
                    </div>
                    <div class="bz-control-group">
                        <label>QQ APPKEY：</label>
                        <input type="text" name="appkey" value="{$sys.appkey}" size="40"/>
                    </div>
                    <div class="bz-control-group">
                        <label>Код рекламы:</label>
                        <textarea name="ad" rows="6" cols="60">{$sys.ad}</textarea>
                    </div>
                    <input type="hidden" name="hash" value="{:md5($_COOKIE['roc_secure'])}"/>
                    <div class="bz-controls">
                        <button type="submit" class="bz-button bz-button-primary"><i class="iconfont icon-queren2"></i> Сохранить</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</section>
<div class="bz-panel bz-panel-default">
    <div class="bz-panel-hd">
        <h3 class="bz-panel-title">Параметры email <em>(для восстановления пароля пользователя)</em></h3>
    </div>
    <div class="bz-panel-bd">
        <form method="post" class="bz-form bz-form-stacked">
            <fieldset>
                <label>Сервер smtp:</label>
                <input type="text" name="smtp_server" placeholder="" class="bz-input-1" value="{$sys.smtp_server}">

                <label>Порт <em>(по умолчанию 25)</em>:</label>
                <input type="text" name="smtp_port" placeholder="" class="bz-input-1" value="{$sys.smtp_port}">

                <label>Логин <em>(от почтового ящика)</em>:</label>
                <input type="text" name="smtp_user" placeholder="" class="bz-input-1" value="{$sys.smtp_user}">

                <label>Пароль:</label>
                <input type="text" name="smtp_password" placeholder="" class="bz-input-1" value="{$sys.smtp_password}">

                <input type="hidden" name="hash" value="{:md5($_COOKIE['roc_secure'])}">
            </fieldset>
            <button type="submit" class="bz-button bz-button-primary"><i class="iconfont icon-queren2"></i> Сохранить</button>
        </form>
    </div>
</div>
