<?php die('Access Denied');?>
{include('_part_header.tpl.php')}
<link rel="stylesheet" type="text/css" href="{$css}rebox.css">
<script src="{$js}rebox.js"></script>
<div id="container">
    <div class="main-outlet container">
    <div class="side">
        <div class="box">
          <ul class="list-topic">
            <li{if $whisperStatus == '0'} class="active"{/if}><a href="{$root}whisper/0/">Непрочитанные сообщения</a></li>
            <li{if $whisperStatus == '1'} class="active"{/if}><a href="{$root}whisper/1/">Прочитанные сообщения</a></li>
            <li{if $whisperStatus == '2'} class="active"{/if}><a href="{$root}whisper/2/">Отправленные сообщения</a></li>
          </ul>
        </div>
    </div>
    <ol class="breadcrumb">
        <li><a href="/">Главная</a></li>
        <li class="active">{if $whisperStatus == '0'}Непрочитанные сообщения{elseif $whisperStatus == '1'}Прочитанные сообщения{else}Отправленные сообщения{/if}</li>
    </ol>
    <div class="content">
        <ul>
            {loop $whisperList $t}
            <li class="topic-list" id="whisper-{$t.id}">
                <div class="topic">
                    <div class="topic-head">
                        <a href="{$root}user/{$t.uid}/" class="topic-avatar">
                            <img src="{if $whisperStatus == 2}{$loginInfo.avatar}{else}{$t.avatar}{/if}" alt="{if $whisperStatus == 2}{$loginInfo.username}{else}{$t.username}{/if}">
                        </a>
                        {if $whisperStatus == 2}
                        отправил
                        <a class="nickname" href="{$root}user/{$t.atuid}">
                            <img src="{$t.avatar}" class="talk-avatar-tiny">{$t.username}
                        </a>
                        {if $t['isread'] == 0}[непрочитано]{else}[прочитано]{/if}
                        {else}
                        <a class="nickname" href="{$root}user/{$t.uid}">
                            {$t.username}
                        </a>
                        {/if}
                        <span class="time">
                            {$t.posttime}
                        </span>
                    </div>
                    <span class="topic-content">
                        {if $whisperStatus == 2}
                            <a href="javascript:showWhisper({$t.atuid}, '{$t.username}', 0);" class="btn-circle btn-right" tip-title="Написать" style="right: 28px;">
                                <i class="icon icon-message x2"></i>
                            </a>
                        {/if}
                        {if $whisperStatus == 1}
                            <a href="javascript:showWhisper({$t.uid}, '{$t.username}', 0);" class="btn-circle btn-right" tip-title="Написать" style="right: 28px;">
                                <i class="icon icon-message x2"></i>
                            </a>
                        {/if}
                        {if $whisperStatus == 0}
                            <a href="javascript:readWhisper({$t.id}, true);" class="btn-circle btn-right" tip-title="Отметить как прочитанное" style="right: 58px;">
                                <i class="icon icon-squarecheck x2"></i>
                            </a>
                            <a href="javascript:showWhisper({$t.uid}, '{$t.username}', {$t.id});" class="btn-circle btn-right" tip-title="Ответиить и пометить как прочитанное" style="right: 28px;">
                                <i class="icon icon-message x2"></i>
                            </a>
                        {/if}
                        <a href="javascript:deleteWhisper({$t.id});" class="delWhisper-btn-{$t.id} btn-circle btn-right" tip-title="Удалить">
                            <i class="icon icon-delete x2"></i>
                        </a>
                        {$t.content}
                    </span>
                    <div class="clear"></div>
                </div>
            </li>
            {/loop}
        </ul>

        <div id="pager">
          {if $whisperList == array() }
            Пока ничего нет
          {else}
            {$page}
          {/if}
        </div>
    </div>
    <div class="clear"></div>
    </div>
</div>
{include('_part_footer.tpl.php')}
