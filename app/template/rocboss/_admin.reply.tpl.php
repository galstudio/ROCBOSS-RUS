<?php die('Access Denied');?>
<link rel="stylesheet" type="text/css" href="{$css}simditor.css" />
<script type="text/javascript" src="{$js}module.js"></script>
<script type="text/javascript" src="{$js}hotkeys.js"></script>
<script type="text/javascript" src="{$js}simditor.js"></script>

<section>
    <ol class="bz-breadcrumb">
        <li><a href="{$root}admin">Главная</a></li>
        <li class="bz-active">Управление комментариями</li>
    </ol>

    <form method="post" id="form">
        <table class="bz-table">
            <thead>
            <tr>
            <th width="30">ID</th>
            <th>Комментарий</td>
            <th>Автор</td>
            <th>Время публикации</td>
            <th width="140">Действия</td>
            </tr>
            </thead>
            <tbody>
            {loop $replyArray $reply}
                <tr id="reply-{$reply.pid}">
                    <td align="center">
                        <input type="checkbox" class="checkbox" name="pid[]" value="{$reply.pid}" />
                    </td>
                    <td align="left">
                        <a href="{$root}read/{$reply.tid}#reply-{$reply.pid}" target="_blank" style="white-space:nowrap; text-overflow:ellipsis; -o-text-overflow:ellipsis; overflow: hidden; max-width:600px; display:block;">
                            {$reply.content}
                        </a>
                    </td>
                    <td align="left">
                        <a href="{$root}user/{$reply.uid}" title="{$reply.username}" target="_blank" style="white-space:nowrap; text-overflow:ellipsis; -o-text-overflow:ellipsis; overflow: hidden;">
                            {$reply.username}
                        </a>
                    </td>
                    <td align="center">
                        {$reply.posttime}
                    </td>
                    <td align="center">
                        <a href="javascript:editReplyForm({$reply.pid});" class="bz-button bz-button-primary" title="Правка"><i class="iconfont icon-edit x2"></i></a>
                        <a href="javascript:delReply({$reply.pid});" onclick="if(!(confirm('Вы уверены, что хотите удалить?'))) return false;" class="bz-button bz-button-sm" title="Удалить" id="delReply-{$reply.pid}"><i class="iconfont icon-shanchu x2"></i></a>
                    </td>
                </tr>
            {/loop}
            </tbody>
            <tfoot>
            <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th><a href="javascript:void(delAllReply());" onclick="if(!(confirm('Вы уверены, что хотите удалить выбранное?'))) return false;" class="bz-button bz-button-sm" style="font-weight: normal;"><i class="iconfont icon-shanchu x2"></i>Удалить выбранное</a></th>
            </tr>
            </tfoot>
        </table>
    </form>
    <div class="pagination">
        {if empty($replyArray)}
            Нет данных
        {else}
            {$page}
        {/if}
    </div>
</section>
