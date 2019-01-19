<?php die('Access Denied');?>
{include('_part_header.tpl.php')}
<div class="member-bg">
{if $currentStatus == 'login'}
<div id="container">
    <form id="loginform" class="mem">
        <div class="mem-put">
            <div class="mem-t">
                <h3 class="mem-t-head">Авторизация на сайте</h3>
                <label>Логин или email:</label>
                <input type="text" name="email" id="email" class="input" id="email"/>
                <label>Пароль:</label>
                <input type="password" name="password" class="input" id="password"/>
                <div class="mem-put-bottom">
                <input type="button" name="submit" value="Войти" id="login-submit" class="right btn btn-default"/>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="mem-tab">
            <div class="mem-t">
                <p>Или <a href="{$root}register">зарегистрироваться</a></p>
                <br>
                <p>Восстановить <a href="{$root}resetPassword">пароль</a></p>
                <br></br>
                <p>Войти через QQ</p><br>
                <a href="{$root}qqlogin" class="btn btn-default"><i class="icon icon-qq x2"></i> QQ</a>
            </div>
        </div>
        <div class="clear"></div>
    </form>
</div>
{/if}

{if $currentStatus == 'register'}
<div id="container">
    <form id="joinform" class="mem">
        <div class="mem-put">
            <div class="mem-t">
                <h3 class="mem-t-head">Регистрация{if $join_switch == 0}<em>(временно закрыта)</em>{/if}</h3>
                <label>Email</label>
                <input type="text" name="email" id="email" class="input" />
                <label>Логин</label>
                <input type="text" name="nickname" id="nickname" class="input" />
                <label>Пароль</label>
                <input type="password" name="password" class="input" id="password" />
                <label>Еще раз пароль</label>
                <input type="password" name="repassword" class="input" id="repassword" />
                <label>Проверочный код</label>
                <input type="text" name="verify" id="verify" class="input" />
                <div class="mem-put-bottom">
                <input type="button" name="submit" value="Отправить" id="reg-submit" class="right btn btn-default"/>
                <img src="#" alt="" id="verify_image" title="Обновить код">
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="mem-tab">
            <div class="mem-t">
                <p>Или <a href="{$root}login">авторизоваться</a></p></br>
                <p>Восстановить <a href="{$root}resetPassword">пароль</a></p>
                <br></br>
                <p>Войти через QQ</p><br>
                <a href="{$root}qqlogin" class="btn btn-default"><i class="fa fa-qq"></i> QQ</a>
            </div>

        </div>
        <div class="clear"></div>
    </form>
</div>
{/if}

{if $currentStatus == 'qqjoin'}
<div id="container">
    <form id="qqjoinform" class="mem">
        <div class="mem-put">
            <div class="mem-t">
                <h3 class="mem-t-head">Связать с QQ</h3>
                <div class="text-center avatar-layout">
                    <img src="{$QQArray.avatar}">
                </div>
                <label>Логин</label>
                <input type="text" class="input" id="username" name="username" autocomplete="off" value="{$QQArray.username}">
                <div class="mem-put-bottom">
                <input type="button" id="qqjoin_submit" class="right btn btn-default" value="Определить логин">
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
    </form>
</div>
{/if}

{if $currentStatus == 'resetPassword'}
<div id="container">
    <form id="resetform" class="mem">
        <div class="mem-put">
            <div class="mem-t">
                <h3 class="mem-t-head">Восстановление пароля</h3>
                <label>Ваш Email (действующий)</label>
                <input type="text" name="email" id="email" class="input" id="email"/>
                <label>Проверочный код</label>
                <input type="text" name="verify" id="verify" class="input" />
                <div class="mem-put-bottom">
                <input type="button" name="submit" value="Отправить" id="reset-submit" class="right btn btn-default"/>
                <img src="#" alt="" id="verify_image" title="Обновить код">
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="mem-tab">
            <div class="mem-t">
                <p>Есть код? <a href="{$root}doReset">Сбросить</a></p>
            </div>
        </div>
        <div class="clear"></div>
    </form>
</div>
{/if}

{if $currentStatus == 'doReset'}
<div id="container">
    <form id="resetform" class="mem">
        <div class="mem-put">
            <div class="mem-t">
                <h3 class="mem-t-head">Сброс пароля</h3>
                <label>Ваш Email (действующий)</label>
                <input type="text" name="email" class="input" id="email">
                <label>Новый пароль</label>
                <input type="password" name="password" class="input" id="password" />
                <label>Новый пароль еще раз</label>
                <input type="password" name="repassword" class="input" id="repassword" />
                <label>Проверочный код</label>
                <input type="text" name="code" class="input" id="code-reset">
                <div class="mem-put-bottom">
                <input type="button" name="submit" value="Отправить" id="doreset-submit" class="right btn btn-default"/>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="mem-tab">
            <div class="mem-t">
                <p>Уже есть код подтверждения? <a href="{$root}resetPassword">Назад</a></p>
            </div>
        </div>
        <div class="clear"></div>
    </form>
</div>
{/if}
</div>
<script type="text/javascript">
$(document).ready(function(){
    $("#verify_image").attr("src", root+"identifyImage/"+Math.random()).click(function(){
        $(this).attr("src", root+"identifyImage/"+Math.random());
    });

    $("#reg-submit").click(function() {
        if( $('#joinform #password').val() != $('#joinform #repassword').val() ){
            layer.msg("Пароли не совпадают");
            $("#joinform #repassword").focus();
            return false;
        }
        $('#reg-submit').attr("disabled", "disabled");
        $.post(root+"register", {
                "do": "register",
                "email": $('#joinform #email').val(),
                "nickname": $('#joinform #nickname').val(),
                "password": $('#joinform #password').val(),
                "verify": $('#joinform #verify').val(),
            }, function(data) {
                data = eval("(" + data + ")");
                if (data.result == "success") {
                    layer.msg("Регистрация прошла успешно! Переадресация на авторизацию...");
                    window.setTimeout("window.location='"+root+"login'",1500);
                } else {
                    layer.msg(data.message);
                    $('#reg-submit').removeAttr("disabled");
                    if( data.position == 1 ){
                        $("#joinform #email").focus();
                    }
                    if( data.position == 2 ){
                        $("#joinform #nickname").focus();
                    }
                    if( data.position == 3 ){
                        $("#joinform #password").focus();
                    }
                    if( data.position == 4 ){
                        $("#joinform #verify").focus();
                        $("#joinform #verify").val('');
                        $("#joinform #verify_image").click();
                    }
                }
            });
    });

    $("#joinform").keyup(function(event){
       if(event.keyCode == 13){
         $("#reg-submit").trigger("click");
       }
    });

    $("#loginform").keyup(function(event){
       if(event.keyCode == 13){
         $("#login-submit").trigger("click");
       }
    });
    $("#resetform").keyup(function(event){
       if(event.keyCode == 13){
         $("#reset-submit").trigger("click");
       }
    });
    $("#login-submit").click(function() {
        var as = ($.trim($("#loginform input[name=email]").val()).length >= 2) ? true : false;
        var ps = ($("#loginform input[name=password]").val().length >= 6) ? true : false;

        if( as && ps ){
            $('#login-submit').attr("disabled", "disabled");
            $.post(root+"login", {
                    "do": "login",
                    "email": $('#loginform #email').val(),
                    "password": $('#loginform #password').val(),
                }, function(data) {
                    data = eval("(" + data + ")");
                    if (data.result == "success") {
                        layer.msg("Авторизация проршла успешно! Переадресация на главную страницу…");
                        window.setTimeout("window.location='"+root+"'",1200);
                    } else {
                        layer.msg(data.message);
                        $('#login-submit').removeAttr("disabled");
                        if( data.position == 1 ){
                            $("#email").focus();
                        }
                        if( data.position == 2 ){
                            $("#password").focus();
                        }
                    }
            });
        }else{
            if(!as){
                layer.msg("Не указан email");
                $("#email").focus();
            } else if(!ps){
                layer.msg("Не указан пароль");
                $("#password").focus();
            }
        }

    });
    $("#reset-submit").click(function() {
        $('#reset-submit').attr("disabled", "disabled");
        $.post(root+"resetPassword", {
                "do": "resetPassword",
                "email":  $('#resetform #email').val(),
                "verify": $('#resetform #verify').val(),
            }, function(data) {
                data = eval("(" + data + ")");
                if (data.result == "success") {
                    layer.msg(data.message);
                    window.setTimeout("window.location='"+root+"doReset';",1000);
                } else {
                    layer.msg(data.message);
                    $('#reset-submit').removeAttr("disabled");
                    if( data.position == 1 ){
                        $("#email").focus();
                    }
                    if( data.position == 2 ){
                        $("#verify").focus();
                    }
                }
        });
    });
    $("#doreset-submit").click(function() {
        $('#doreset-submit').attr("disabled", "disabled");
        $.post(root+"doReset", {
                "email": $('#resetform #email').val(),
                "code": $('#resetform #code-reset').val(),
                "password":  $('#resetform #password').val(),
                "repassword": $('#resetform #repassword').val(),
            }, function(data) {
                data = eval("(" + data + ")");
                if (data.result == "success") {
                    layer.msg(data.message);
                    window.setTimeout("window.location='"+root+"login';",1000);
                } else {
                    layer.msg(data.message);
                    $('#doreset-submit').removeAttr("disabled");
                }
        });
    });
    $("#qqjoin_submit").click(function (){
        $("#qqjoin_submit").val('Представление...');
        $("#qqjoin_submit").attr("disabled", "disabled");
        $.post(root+"qqjoin", {
            "username": $("#qqjoinform #username").val(),
        }, function(data) {
            data = eval("(" + data + ")");
            if (data.result == "success") {
                layer.msg(data.message);
                window.setTimeout("window.location='"+root+"';",1000);
            } else {
                layer.msg(data.message);
                $("#qqjoinform #username").focus();
                $("#qqjoin_submit").val('Определение логина');
                $("#qqjoin_submit").removeAttr("disabled");
            }
        });
    });

});
function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}
</script>
{include('_part_footer.tpl.php')}
