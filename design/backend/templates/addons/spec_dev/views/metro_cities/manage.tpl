{capture name="mainbox"}

<form action="{""|fn_url}" method="post" name="metro_cities_form" class="{if $runtime.company_id} cm-hide-inputs{/if}">
<input type="hidden" name="country_code" value="{$search.country}" />

{include file="common/pagination.tpl" save_current_page=true save_current_url=true}

{if $metro_cities}
<table width="100%" class="table table-middle">
<thead>
<tr>
    <th width="1%">{include file="common/check_items.tpl"}</th>
    <th width="10%">{__("code")}</th>
    <th width="60%">{__("metro_city")}</th>
    <th width="5%">&nbsp;</th>
    <th class="right" width="10%">{__("status")}</th>
</tr>
</thead>
{foreach from=$metro_cities item=metro_city}
<tr class="cm-row-status-{$metro_city.status|lower}">
    <td>
        <input type="checkbox" name="metro_city_ids[]" value="{$metro_city.metro_city_id}" class="checkbox cm-item" /></td>
    <td class="left nowrap row-status">
        <span>{$metro_city.code}</span>
        {*<input type="text" name="metro_cities[{$metro_city.metro_city_id}][code]" size="8" value="{$metro_city.code}" class="input-text" />*}</td>
    <td>
        <input type="text" name="metro_cities[{$metro_city.metro_city_id}][metro_city]" size="55" value="{$metro_city.metro_city}" class="input-hidden span8"/></td>
    <td class="nowrap">
        {capture name="tools_list"}
            <li>{btn type="list" class="cm-confirm" text=__("delete") href="metro_cities.delete?metro_city_id=`$metro_city.metro_city_id`&country_code=`$search.country`"}</li>
        {/capture}
        <div class="hidden-tools">
            {dropdown content=$smarty.capture.tools_list}
        </div>
    </td>
    <td class="right">
        {include file="common/select_popup.tpl" id=$metro_city.metro_city_id status=$metro_city.status hidden="" object_id_name="metro_city_id" table="metro_cities"}
    </td>
</tr>
{/foreach}
</table>
{else}
    <p class="no-items">{__("no_data")}</p>
{/if}

{include file="common/pagination.tpl"}

</form>

{capture name="tools"}
    {capture name="add_new_picker"}

    <form action="{""|fn_url}" method="post" name="add_metro_cities_form" class="form-horizontal form-edit">
    <input type="hidden" name="metro_city_data[country_code]" value="{$search.country_code}" />
    <input type="hidden" name="country_code" value="{$search.country_code}" />
    <input type="hidden" name="metro_city_id" value="0" />

    {foreach from=$countries item="country" key="code"}
        {if $code == $search.country_code}
            {assign var="title" value="{__("new_metro_cities")} (`$country`)"}
        {/if}
    {/foreach}

    <div class="cm-j-tabs">
        <ul class="nav nav-tabs">
            <li id="tab_new_metro_cities" class="cm-js active"><a>{__("general")}</a></li>
        </ul>
    </div>

    <div class="cm-tabs-content">
    <fieldset>
        <div class="control-group">
            <label class="cm-required control-label" for="elm_metro_city_code">{__("code")}:</label>
            <div class="controls">
            <input type="text" id="elm_metro_city_code" name="metro_city_data[code]" size="8" value="" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="elm_metro_city_name">{__("metro_city")}:</label>
            <div class="controls">
            <input type="text" id="elm_metro_city_name" name="metro_city_data[metro_city]" size="55" value="" />
            </div>
        </div>

        {include file="common/select_status.tpl" input_name="metro_city_data[status]" id="elm_metro_city_status"}
    </fieldset>
    </div>

    <div class="buttons-container">
        {include file="buttons/save_cancel.tpl" create=true but_name="dispatch[metro_cities.update]" cancel_action="close"}
    </div>

</form>

{/capture}
{/capture}

{capture name="buttons"}
    {capture name="tools_list"}
        {hook name="metro_cities:manage_tools_list"}
            {if $metro_cities}
                <li>{btn type="delete_selected" dispatch="dispatch[metro_cities.m_delete]" form="metro_cities_form"}</li>
            {/if}
        {/hook}
    {/capture}
    {dropdown content=$smarty.capture.tools_list}

    {if $metro_cities}
        {include file="buttons/save.tpl" but_name="dispatch[metro_cities.m_update]" but_role="submit-link" but_target_form="metro_cities_form"}
    {/if}
{/capture}

{capture name="adv_buttons"}
    {include file="common/popupbox.tpl" id="new_metro_city" action="metro_cities.add" text=$title content=$smarty.capture.add_new_picker title=__("add_metro_city") act="general" icon="icon-plus"}
{/capture}

{capture name="sidebar"}
<div class="sidebar-row">
<h6>{__("search")}</h6>
<form action="{""|fn_url}" name="metro_cities_filter_form" method="get">
<div class="sidebar-field">
    <label>{__("country")}:</label>
        <select name="country_code">
            {foreach from=$countries item="country" key="code"}
                <option {if $code == $search.country_code}selected="selected"{/if} value="{$code}">{$country}</option>
            {/foreach}
        </select>
</div>
    {include file="buttons/search.tpl" but_name="dispatch[metro_cities.manage]"}
</form>
</div>
{/capture}


{/capture}
{include file="common/mainbox.tpl" title=__("metro_cities") content=$smarty.capture.mainbox adv_buttons=$smarty.capture.adv_buttons buttons=$smarty.capture.buttons sidebar=$smarty.capture.sidebar select_languages=true}