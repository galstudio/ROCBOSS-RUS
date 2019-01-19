<?php die('Access Denied');?>
<li class="topic-view reply-bg">
    {if $loginInfo['uid'] > 0}
        {if $topicInfo['islock'] == 0}
        <form id="reply-add" class="add-post">
            <h3 class="reply-t">Коммеентировать</h3>
            <fieldset>
                <input type="text" name="pictureString" id="pictureString" value="" style="display:none;"/>
                <input type="text" name="tid" id="tid" value="{$topicInfo.tid}" style="display:none;"/>
                <div class="textarea">
                    <textarea id="subject" name="subject"></textarea>
                </div>
                <a class="right btn btn-default" id="create" href="javascript:postNewReply();">Отправить</a>
                <div class="upload-image">
                    <i class="icon icon-camerafill x6"></i>
                    <input type="file" name="upfile" id="post-pictures-file" accept="image/*" style="opacity: 0; left: 0;top: 0;bottom: 0;margin: 0; position: absolute; width: 35px;cursor: pointer;" />
                </div>

                <div class="clear"></div>
                <div class="showLine"></div>
            </fieldset>
        </form>
        <script type="text/javascript">
            var editor = new Simditor({
              textarea: $('#subject'),
              defaultImage: '{$tpl}assets/img/default.jpg'
            });
        </script>
        <div class="clear"></div>
        {else}
            <span id="login-tip">
                К сожалению, комментарии к этому топику отключены
            </span>
        {/if}
    {else}
        <span id="login-tip">
            Для комментирования топика，<a href="{$root}login">авторизуйтесь</a> на сайте
        </span>
    {/if}
</li>
