<?php die('Access Denied');?>
{if $RequestType == 'fans'}
<ul>
    {loop $fansList $t}
    <li class="topic-list">
        <div class="topic">
                <div class="topic-head">
                    <a href="{$root}user/{$t.uid}" class="topic-avatar">
                        <img src="{$t.avatar}" alt="{$t.username}">
                    </a>
                    <a class="nickname" href="{$root}user/{$t.uid}">
                        {$t.username}
                    </a>
                </div>
                <p class="topic-content">
                    {if $t['signature'] != ''}Подпись: {$t.signature}
                    {else}Этот кадр ленивый, даже подпись себе не добавил!
                    {/if}
                </p>
        </div>
    </li>
    {/loop}
</ul>
<div id="pager">
    {if $fansList == array()}
        Нет данных
    {else}
        {$page}
    {/if}
</div>
{/if}
