<!DOCTYPE html>
<html xmlns:ng="http://angularjs.org" lang="{$smarty.const.CART_LANGUAGE|lower}" ng-app="app">
<head>
{if $twg_settings.companyName}
    <title>{if $twg_settings.home_page_title}{$twg_settings.home_page_title} - {/if}{$twg_settings.companyName}</title>
{else}
    <title>{$twg_settings.home_page_title}</title>
{/if}
<meta name="description" content="">
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="cleartype" content="on">
<meta content="Twigmo" name="description" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0">
<meta name="robots" content="noindex">

<base href="{$twg_settings.base_path}/"/>

<link rel="apple-touch-icon" href="{$urls.favicon}" />
<link rel="shortcut icon" href="{$urls.favicon}" />

{if $twg_state.theme_editor_mode}
    <link rel="stylesheet" type="text/css" href="{$urls.preview_css}app.css?{$repo_revision}" data-theme="Y" />
{else}
    <link rel="stylesheet" type="text/css" href="{$urls.repo}app.css?{$repo_revision}" />
{/if}

<!--[if IE]>
<link rel="stylesheet" type="text/css" href="{$urls.preview_css}/ie-compiled.css?{$repo_revision}" />
<![endif]-->

<script type="text/javascript" src="{$urls.repo}vendor.js?{$repo_revision}"></script>
<script type="text/javascript" src="{$urls.repo}twigmo.js?{$repo_revision}"></script>

{if $twg_state.theme_editor_mode}
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <script type="text/javascript" src="{$urls.repo}theme_editor.js?{$repo_revision}"></script>
{/if}

{if $twg_settings.geolocation == 'Y'}
    <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false&?v=3.7&language={$smarty.const.CART_LANGUAGE}"></script>
{/if}

<script type="text/javascript">
//<![CDATA[
    var settings = {$json_twg_settings nofilter};
//]]>
</script>

</head>

<body class="device-{$twg_state.device} browser-{$twg_state.browser}">
    <div ng-include="'/core/customer/index.html'" ng-controller="AppCtrl"></div>
    {if $addons.google_analytics.status == "A"}
        {include file="addons/google_analytics/hooks/index/footer.post.tpl"}
    {/if}

    {if $twg_state.theme_editor_mode}
        <input type="hidden" name="lazy_css_to_load" value="{$urls.preview_css}custom.css?{$repo_revision}" data-theme="Y">
    {else}
        <input type="hidden" name="lazy_css_to_load" value="{$urls.repo}custom.css?{$repo_revision}">
    {/if}
</body>
</html>
