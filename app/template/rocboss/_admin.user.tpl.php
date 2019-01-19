<?php die('Access Denied');?>
<section>
    <ol class="bz-breadcrumb">
        <li><a href="{$root}admin">Главная</a></li>
        <li class="bz-active">Управление пользователями</li>
    </ol>

    <form method="post" id="form">
        <table class="bz-table">
            <thead>
            <tr>
            <th class="text-center">Аватар</th>
            <th class="text-center">Логин</th>
            <th class="text-center">Email</th>
            <th class="text-center">Интеграция</th>
            <th class="text-center">Баланс</th>
            <th class="text-center">Последняя активность</th>
            <th class="text-center">Действия</th>
            </tr>
            </thead>
            <tbody>
            {loop $userArray $user}
            <tr id="user-{$user.uid}">
            <td align="center">
                <img src="{$user.avatar}" width="30" height="30" />
            </td>
            <td align="center">
                <a href="{$root}user/{$user.uid}/" target="_blank">
                    {$user.username}
                </a>
            </td>
            <td align="center">
                {if empty($user['email'])}
                    не указан
                {else}
                    {$user.email}
                {/if}
            </td>
            <td align="center">
                {$user.scores}
            </td>
            <td align="center">
                {$user.money}
            </td>
            <td align="center">
                {$user.lasttime}
            </td>
            <td align="center">
                {if $user['groupid'] == 1}
                <a class="bz-button bz-button-primary" onclick="javascript:ban({$user.uid}, this, 0);" title="Лишить права голоса">Забанить</a>
                {elseif $user['groupid'] == 0}
                <a class="bz-button danger" onclick="javascript:ban({$user.uid}, this, 1);" title="Вернуть право голоса">Разбанить</a>
                {/if}
                {if $user['groupid'] == 9}
                <a class="bz-button bz-button-primary" onclick="javascript:ban({$user.uid}, this, 1);" title="Разжаловать до обыкновенного пользователя">Расжаловать</a>
                {else}
                <a class="bz-button bz-button-sm" onclick="javascript:ban({$user.uid}, this, 9);" title="Повысить до администратора">Повысить</a>
                {/if}
            </td>
            </tr>
            {/loop}
            </tbody>
        </table>
    </form>
    <div class="pagination">
        {if empty($userArray)}
            Нет данных
        {else}
            {$page}
        {/if}
    </div>
</section>
