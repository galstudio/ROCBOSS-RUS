<?php die('Access Denied');?>

{include('_part_header.tpl.php')}
<div id="container">
  <div class="main-outlet container">
    <div class="side">
      <div class="box">
        <ul class="list-topic">
          <li{if $settingType == 'avatar'} class="active"{/if}>
            <a href="{$root}setting/avatar">Аватар</a>
          </li>

          <li{if $settingType == 'signature'} class="active"{/if}>
            <a href="{$root}setting/signature">Подпись</a>
          </li>

          <li{if $settingType == 'email'} class="active"{/if}>
            <a href="{$root}setting/email">Email</a>
          </li>

          <li{if $settingType == 'password'} class="active"{/if}>
            <a href="{$root}setting/password">Пароль</a>
          </li>
        </ul>
      </div>
    </div>
    <ol class="breadcrumb">
        <li><a href="/">Главная</a></li>
        {if $settingType == 'password'}
          <li class="active">Пароль</li>
        {/if}
        {if $settingType == 'signature'}
          <li class="active">Подпись</li>
        {/if}
        {if $settingType == 'email'}
          <li class="active">Email</li>
        {/if}
        {if $settingType == 'avatar'}
          <li class="active">Аватар (рекомендуемый размер 200х200)</li>
        {/if}
    </ol>
    <div class="content">
      {if $settingType == 'password'}
      <form id="password-form">
        <dl class="set-form">
          <dt class="input-group">
            <p class="input">Текущий пароль:<input type="password"  id="password" name="password" placeholder="если не изменяете, то оставьте поле пустым"></p>
            <p class="input">Новый пароль:<input type="password"  id="newPassword" name="newPassword" placeholder=""></p>
            <p class="input">Подтвердить пароль:<input type="password"  id="reNewPassword" name="reNewPassword" placeholder=""></p>
            <input type="button" id="password-setting-button" class="btn btn-default mt10" onclick="javascrpit:setPassword();" value="Сохранить">
          </dt>
        </dl>
      </form>
      {/if}

      {if $settingType == 'signature'}
      <form id="signature-form">
        <dl class="set-form">
          <dt class="input-group">
            <p class="form-control">
              <textarea id="signature" name="signature">{$userInfo.signature}</textarea>
            </p>
            <input type="button" id="signature-setting-button" class="btn btn-default mt10" onclick="javascrpit:setSignature();" value="Сохранить">
          </dt>
        </dl>
      </form>
      {/if}

      {if $settingType == 'email'}
      <form id="email-form">
        <dl class="set-form">
          <dt class="input-group">
            {if $userInfo['password'] == ""}
            <p class="set-tip">Укажите <a href="{$root}setting/password">текущий пароль</a>!</p>
            {else}
            <p class="input">Email:
            <input type="text" id="email" name="email" placeholder="не будет отображаться публично"  value="{$userInfo.email}">
            </p>
            <p class="input">Текущий пароль:
            <input type="password" id="password" name="password" placeholder="">
            </p>
            <p>
            <input type="button" id="email-setting-button" class="btn btn-default mt10" onclick="javascrpit:setEmail();" value="Сохранить">
            </p>
            {/if}
          </dt>
        </dl>
      </form>
      {/if}

      {if $settingType == 'avatar'}
      <form id="avatar-form" style="text-align:center">
        <dl class="set-form">
          <dt class="input-group">
            <p>
              <img src="{$userInfo.avatar}" class="avatar-now" width="100" height="100" style="border-radius: 5%;">
            </p>
            <div class="upload-avatar">
              <i class="icon icon-camerafill x6"></i>
              <input type="file" id="post-avatar" accept="image/*" style="opacity: 0; left: 0;top: 0;bottom: 0;margin: 0; position: absolute; width: 35px;"/>
            </div>
          </dt>
        </dl>
      </form>
      {/if}
    </div>
  </div>
  <div class="clear"></div>
</div>
{include('_part_footer.tpl.php')}
