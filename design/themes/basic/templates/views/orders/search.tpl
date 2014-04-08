<div class="mainbox-container clearfix">

<div class="order-savings">
    <div class="time-savings"><span>2,345 min</span><p>{__("time_saved")}</p></div>
    <div class="money-savings"><span>$468</span><p>{__("your_savings")}</p></div>
</div>

<h1 class="mainbox-title"><span>{__("my_orders")}</span></h1>
<div class="mainbox-body">
{capture name="section"}
    {include file="views/orders/components/orders_search_form.tpl"}
{/capture}
{include file="common/section.tpl" section_title=__("search_options") section_content=$smarty.capture.section class="search-form"}

{assign var="c_url" value=$config.current_url|fn_query_remove:"sort_by":"sort_order"}
{if $search.sort_order == "asc"}
{assign var="sort_sign" value="<i class=\"icon-down-dir\"></i>"}
{else}
{assign var="sort_sign" value="<i class=\"icon-up-dir\"></i>"}
{/if}
{if !$config.tweaks.disable_dhtml}
    {assign var="ajax_class" value="cm-ajax"}

{/if}

{include file="common/pagination.tpl"}
<table class="table orders table-width">
<thead>
<tr>
    <th style="width: 12%"><a class="{$ajax_class}" href="{"`$c_url`&sort_by=date&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("date")}</a>{if $search.sort_by == "date"}{$sort_sign nofilter}{/if}</th>
    <th style="width: 12%" class="center"><a class="{$ajax_class}" href="{"`$c_url`&sort_by=order_id&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("order")} #</a>{if $search.sort_by == "order_id"}{$sort_sign nofilter}{/if}</th>
    <th style="width: 34%"><a class="{$ajax_class}" href="{"`$c_url`&sort_by=customer&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("customer")}</a>{if $search.sort_by == "customer"}{$sort_sign nofilter}{/if}</th>
    <th style="width: 15%"><a class="{$ajax_class}" href="{"`$c_url`&sort_by=total&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("amount")}</a>{if $search.sort_by == "total"}{$sort_sign nofilter}{/if}</th>
    <th style="width: 12%"><a class="{$ajax_class}" href="{"`$c_url`&sort_by=status&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("status")}</a>{if $search.sort_by == "status"}{$sort_sign nofilter}{/if}</th>
    <th style="width: 15%"><a>{__("action")}</a></th>
</tr>
</thead>
{foreach from=$orders item="o"}
<tr {cycle values=",class=\"table-row\""}>
    <td><a href="{"orders.details?order_id=`$o.order_id`"|fn_url}">{$o.timestamp|date_format:"`$settings.Appearance.date_format`, `$settings.Appearance.time_format`"}</a></td>
    <td class="center"><a href="{"orders.details?order_id=`$o.order_id`"|fn_url}" class="color">{$o.order_id}</strong></td>
    <td>
        <ul class="no-markers">
            <li>{$o.firstname} {$o.lastname}</li>
            <li><a href="mailto:{$o.email|escape:url}">{$o.email}</a></li>
        </ul>
    </td>
    <td>{include file="common/price.tpl" value=$o.total}</td>
    <td>{include file="common/status.tpl" status=$o.status display="view"}</td>
    <td>Action</td>
</tr>
{foreachelse}
<tr>
    <td colspan="7"><p class="no-items">{__("text_no_orders")}</p></td>
</tr>
{/foreach}
</table>

{include file="common/pagination.tpl"}
</div>
</div>
{* capture name="mainbox_title"}{__("my_orders")}{/capture *}