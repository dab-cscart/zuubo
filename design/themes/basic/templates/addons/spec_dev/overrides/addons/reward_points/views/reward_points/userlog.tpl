<div class="zbucks-content">

{assign var="c_url" value=$config.current_url|fn_query_remove:"sort_by":"sort_order"}

<div class="zbucks-head-info">
    <div class="zb-zbucks"><p class="subhead">{$user_info.points|default:"0"}</p><p>{__("available")}</p></div>
    <div class="zbucks-expiring-30"><p class="subhead">359</p><p>{__("expiring_in_30")}</p></div>
    <div class="zbucks-expiring-60"><p class="subhead">478</p><p>{__("expiring_in_30")}</p></div>
</div>

<h1 class="mainbox-title"><span>{__("my_zbucks")}</span> <span class="additional-title-info">({$user_info.points|default:"0"} {__("available")})</span></h1>

{if $search.sort_order == "asc"}
{assign var="sort_sign" value="<i class=\"icon-down-dir\"></i>"}
{else}
{assign var="sort_sign" value="<i class=\"icon-up-dir\"></i>"}
{/if}
{include file="common/pagination.tpl"}
<table class="table table-width">
<tr>
    <th style="width: 15%"><a class="cm-ajax" href="{"`$c_url`&sort_by=timestamp&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("grant")}/{__("deduction_date")}</a>{if $search.sort_by == "timestamp"}{$sort_sign nofilter}{/if}</th>
    <th style="width: 10%"><a class="cm-ajax" href="{"`$c_url`&sort_by=amount&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("amount")}</a>{if $search.sort_by == "amount"}{$sort_sign nofilter}{/if}</th>
    <th style="width: 55%">{__("grant")}/{__("deduction_reason")}</th>
    <th style="width: 20%">{__("expiration_date")}</th>
</tr>
{foreach from=$userlog item="ul"}
<tr {cycle values=",class=\"table-row\""}>
    <td class="valign-top">{$ul.timestamp|date_format:"`$settings.Appearance.date_format`, `$settings.Appearance.time_format`"}</td>
    <td class="center valign-top">{$ul.amount}</td>
    <td class="valign-top">
        {if $ul.action == $smarty.const.CHANGE_DUE_ORDER}
            {assign var="statuses" value=$smarty.const.STATUSES_ORDER|fn_get_simple_statuses:true:true}
            {assign var="reason" value=$ul.reason|unserialize}
            {assign var="order_exist" value=$reason.order_id|fn_get_order_name}
            {assign var="product_exist" value=$reason.product_id|fn_get_product_name}
            {if $product_exist}{__("product")}&nbsp;<a href="{"products.view?product_id=`$reason.product_id`"|fn_url}" class="underlined"><span>{$product_exist}</span></a>{/if}:&nbsp;{$statuses[$reason.from]}&nbsp;&#8212;&#8250;&nbsp;{$statuses[$reason.to]}{if $reason.text}&nbsp;({__($reason.text) nofilter}){/if}
            <div>{__("order_number")}&nbsp;:&nbsp;{if $order_exist}<a href="{"orders.details?order_id=`$reason.order_id`"|fn_url}" class="color">{/if}{$reason.order_id}{if $order_exist}</a>{/if}</div>
        {elseif $ul.action == $smarty.const.CHANGE_DUE_USE}
            {assign var="order_exist" value=$ul.reason|fn_get_order_name}
            {__("text_points_used_in_order")}: {if $order_exist}<a href="{"orders.details?order_id=`$ul.reason`"|fn_url}">{/if}<strong>#{$ul.reason}</strong>{if $order_exist}</a>{/if}
        {elseif $ul.action == $smarty.const.CHANGE_DUE_ORDER_DELETE}
            {assign var="reason" value=$ul.reason|unserialize}
            {if $product_exist}{__("product")}&nbsp;<a href="{"products.view?product_id=`$reason.product_id`"|fn_url}" class="underlined"><span>{$product_exist}</span></a>{/if}: {__("deleted")}
            <div>{__("order_number")}&nbsp;:&nbsp;{$reason.order_id}</div>
        {elseif $ul.action == $smarty.const.CHANGE_DUE_ORDER_PLACE}
            {assign var="reason" value=$ul.reason|unserialize}
            {assign var="order_exist" value=$reason.order_id|fn_get_order_name}
            {if $product_exist}{__("product")}&nbsp;<a href="{"products.view?product_id=`$reason.product_id`"|fn_url}" class="underlined"><span>{$product_exist}</span></a>{/if}: {__("placed")}
            <div>{__("order")}&nbsp;:&nbsp;{if $order_exist}<a href="{"orders.details?order_id=`$reason.order_id`"|fn_url}" class="color">{/if}{$reason.order_id}{if $order_exist}</a>{/if}</div>
        {else}
            {hook name="reward_points:userlog"}
            {$ul.reason}
            {/hook}
        {/if}
    </td>
    <td class="valign-top">{if $ul.expiration_date}{$ul.expiration_date|date_format:"`$settings.Appearance.date_format`"}{else}{__("na")}{/if}</td>
</tr>
{foreachelse}
<tr>
    <td colspan="3"><p class="no-items">{__("no_items")}</p></td>
</tr>
{/foreach}
</table>
{include file="common/pagination.tpl"}
{** / userlog description section **}

{capture name="mainbox_title"}{__("my_zbucks")}{/capture}
</div>