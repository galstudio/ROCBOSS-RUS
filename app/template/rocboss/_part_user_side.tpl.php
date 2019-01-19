<?php die('Access Denied');?>
<div class="side">
    <div class="box">
      <div class="side-user">
        <div class="side-avatar">
          <img src="{$userInfo.avatar}" alt="{$userInfo.username}" class="avatar">
        </div>
        <div class="side-info">
          <h4>{$userInfo.username}</h4>
          <div class="asmall"> {$userInfo.groupname}</div>
          <p>Баллы: {$userInfo.scores}</p>
          <p>Дата регистрации: {$userInfo.regtime}</p>
          <p>Последний раз был: {$userInfo.lasttime}</p>
          <p>
              {if $userInfo['signature'] != ''}Подпись: {$userInfo.signature}
              {else}Этот кадр ленивый, даже подпись себе не добавил!
              {/if}
          </p>
        </div>
      </div>
    {if $userInfo['uid'] != $loginInfo['uid'] && $loginInfo['uid'] != 0}
      <div class="side-profile">
        {if $userInfo['groupid'] < 9 && $loginInfo['groupid'] == 9}
            <a href="javascript:ban({$userInfo.uid}, {:1-$userInfo['groupid']});" class="btn" id="ban">
                {if $userInfo['groupid'] == 0}
                  <i class="icon icon-roundclosefill x2"></i> Разбанить
                {else}
                  <i class="icon icon-roundclose x2"></i> Забанить
                {/if}
            </a>
        {/if}
        <a href="javascript:follow({$userInfo.uid});" class="btn" id="follow">
            {if $isFollow > 0}
              <i class="icon icon-likefill x2"></i> Отписаться
            {else}
              <i class="icon icon-like x2"></i> Читать
            {/if}
        </a>
        <a href="javascript:showWhisper({$userInfo.uid}, '{$userInfo.username}', 0);" class="btn" id="whisper"><i class="icon icon-message x2"></i> Написать</a>
      </div>
    {/if}
    </div>
    <div class="box">
      <ul class="list-topic">
          <li{if $RequestType == 'topic'} class="active"{/if}>
            <a href="{$root}user-{$userInfo.uid}-topic">
                {if $userInfo['uid'] != $loginInfo['uid']}Его{else}Мои{/if} топики
            </a>
          </li>
          <li{if $RequestType == 'reply'} class="active"{/if}>
            <a href="{$root}user-{$userInfo.uid}-reply">
                {if $userInfo['uid'] != $loginInfo['uid']}Его{else}Мои{/if} комментарии
            </a>
          </li>
          <li{if $RequestType == 'follow'} class="active"{/if}>
            <a href="{$root}user-{$userInfo.uid}-follow">
                {if $userInfo['uid'] != $loginInfo['uid']}Его{else}Мои{/if} подписки
            </a>
          </li>
          <li{if $RequestType == 'fans'} class="active"{/if}>
            <a href="{$root}user-{$userInfo.uid}-fans">
                {if $userInfo['uid'] != $loginInfo['uid']}Его{else}Мои{/if} подписчики
            </a>
          </li>
          {if $loginInfo['uid'] == $userInfo['uid'] }
              <li{if $RequestType == 'favorite'} class="active"{/if}>
                <a href="{$root}my/favorite">
                    Избранное
                </a>
              </li>
              <li{if $RequestType == 'score'} class="active"{/if}>
                <a href="{$root}my/score">
                    Интеграция
                </a>
              </li>
          {/if}
      </ul>
    </div>
</div>
