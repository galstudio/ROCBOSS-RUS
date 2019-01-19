<?php die('Access Denied');?>
<section>
    <ol class="bz-breadcrumb">
        <li><a href="{$root}admin">Главная</a></li>
        <li class="bz-active">Управление ссылками</li>
        <a href="javascript:editLink('', '', '');" class="bz-button bz-button-primary right">Добавить ссылку</a>
    </ol>

    <table class="bz-table">
        <thead>
        <tr>
        <th width="80">Порядок</th>
        <th>Анкор</td>
        <th>Ссылка</td>
        <th width="180">Действия</td>
        </tr>
        </thead>
        <tbody>
        {loop $LinksList $link}
            <tr>
                <td align="center">{$link.position}</td>
                <td align="center">
                    {$link.text}
                </td>
                <td align="center">
                    <a href="{$link.url}" target="_blank">
                        {$link.url}
                    </a>
                </td>
                <td align="center">
                    <a href="javascript:editLink({$link.position}, '{$link.text}', '{$link.url}');" title="Правка" class="bz-button bz-button-primary"><i class="iconfont icon-edit x2"></i></a>
                    <a href="{$root}manage/del_link/{$link.position}/" onclick="if(!(confirm('Вы уверены, что хотите удалить?'))) return false;" title="Удалить" class="bz-button"><i class="iconfont icon-shanchu x2"></i></a>
                </td>
            </tr>
        {/loop}
        </tbody>
    </table>
</section>
