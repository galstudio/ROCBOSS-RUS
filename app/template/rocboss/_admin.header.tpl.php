<?php die('Access Denied');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{$title}{$sitename}</title>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta http-equiv="Cache-control" content="no-cache, must-revalidate"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0"/>
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="{$tpl}admin/css/base.css">
    <link rel="stylesheet" type="text/css" href="{$tpl}admin/css/iconfont.css">
    <!--[if lt IE 9]>
        <script src="{$js}html5.js"></script>
    <![endif]-->
    <script type="text/javascript" src="{$js}jquery.js"></script>

    <script type="text/javascript" src="{$tpl}assets/layer/layer.js"></script>
    <script type="text/javascript" src="{$js}manage.js"></script>
    <script type="text/javascript">
        var root = '{$root}';
    </script>
</head>
<body>
<nav class="top-head">
    <ul class="bz-nav bz-nav-pills container">
        <div class="bz-logo">
            <a href="{$root}" title="На главную"><i class="iconfont icon-yingyongzhongxin x4"></i></a> ROCBOSS
        </div>
        <li{if $type == 'system'} class="bz-nav-active"{/if}>
            <a href="{$root}admin/system"><i class="iconfont icon-style"></i> Главная</a>
        </li>
        <li{if $type == 'common'} class="bz-nav-active"{/if}>
            <a href="{$root}admin/common"><i class="iconfont icon-iconfontxitongshezhi"></i> Опции</a>
        </li>
        <li{if $type == 'topic'} class="bz-nav-active"{/if}>
            <a href="{$root}admin/topic"><i class="iconfont icon-up-posts"></i> Топики</a>
        </li>
        <li{if $type == 'reply'} class="bz-nav-active"{/if}>
            <a href="{$root}admin/reply"><i class="iconfont icon-pinglunhuifu"></i> Комменты</a>
        </li>
        <li{if $type == 'user'} class="bz-nav-active"{/if}>
            <a href="{$root}admin/user"><i class="iconfont icon-login"></i> Юзеры</a>
        </li>
        <li{if $type == 'tag'} class="bz-nav-active"{/if}>
            <a href="{$root}admin/tag"><i class="iconfont icon-biaoqian"></i> Теги</a>
        </li>
        <li{if $type == 'link'} class="bz-nav-active"{/if}>
            <a href="{$root}admin/link"><i class="iconfont icon-lianjie"></i> Ссылки</a>
        </li>
        <li class="bz-nav-has-children bz-nav-allow-hover">
            <a href="" class="bz-nav-link"><i class="iconfont icon-qingchuhuancun"></i> Очистка</a>
            <ul class="bz-nav-children bz-nav">
                <li><a href="{$root}admin/ClearCache/template">Шаблон</a></li>
                <li><a href="{$root}admin/ClearCache/attachment">Вложения</a></li>
                <li><a href="{$root}admin/ClearCache/score">Разное</a></li>
            </ul>
        </li>
    </ul>
</nav>
{if isset($code)}
    <script type="text/javascript">
        layer.msg('{$code}');
    </script>
{/if}
<div class="container">
