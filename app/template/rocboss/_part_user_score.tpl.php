<?php die('Access Denied');?>
{if $RequestType == 'score'}
<ul>
    {loop $scoreList $t}
    <li class="topic-list">
    <p class="score">
        <strong class="text-green">{$t.detail}</strong> {if $t['changed'] < 0}вычет{else}добавлен{/if} <strong class="text-green">{:abs($t['changed'])}</strong> балл, итого <strong class="text-green">{$t.remain}</strong>, время {$t.time}</p>
    </li>
    {/loop}
</ul>
<div id="pager">
    {if $scoreList == array() }
        Нет данных
    {else}
        {$page}
    {/if}
</div>
{/if}
