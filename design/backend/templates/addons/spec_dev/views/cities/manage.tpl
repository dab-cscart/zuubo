{capture name="mainbox"}

<form action="{""|fn_url}" method="post" name="cities_form" class="{if $runtime.company_id} cm-hide-inputs{/if}">
<input type="hidden" name="country_code" value="{$search.country}" />

{include file="common/pagination.tpl" save_current_page=true save_current_url=true}

{if $cities}
<table width="100%" class="table table-middle">
<thead>
<tr>
    <th width="1%">{include file="common/check_items.tpl"}</th>
    <th width="10%">{__("code")}</th>
    <th width="60%">{__("city")}</th>
    <th width="5%">&nbsp;</th>
    <th class="right" width="10%">{__("status")}</th>
</tr>
</thead>
{foreach from=$cities item=city}
<tr class="cm-row-status-{$city.status|lower}">
    <td>
        <input type="checkbox" name="city_ids[]" value="{$city.city_id}" class="checkbox cm-item" /></td>
    <td class="left nowrap row-status">
        <span>{$city.code}</span>
        {*<input type="text" name="cities[{$city.city_id}][code]" size="8" value="{$city.code}" class="input-text" />*}</td>
    <td>
        <input type="text" name="cities[{$city.city_id}][city]" size="55" value="{$city.city}" class="input-hidden span8"/></td>
    <td class="nowrap">
        {capture name="tools_list"}
            <li>{btn type="list" class="cm-confirm" text=__("delete") href="cities.delete?city_id=`$city.city_id`&country_code=`$search.country`"}</li>
        {/capture}
        <div class="hidden-tools">
            {dropdown content=$smarty.capture.tools_list}
        </div>
    </td>
    <td class="right">
        {include file="common/select_popup.tpl" id=$city.city_id status=$city.status hidden="" object_id_name="city_id" table="cities"}
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

    <form action="{""|fn_url}" method="post" name="add_cities_form" class="form-horizontal form-edit">
    <input type="hidden" name="city_data[country_code]" value="{$search.country_code}" />
    <input type="hidden" name="country_code" value="{$search.country_code}" />
    <input type="hidden" name="city_id" value="0" />

    {foreach from=$countries item="country" key="code"}
        {if $code == $search.country_code}
            {assign var="title" value="{__("new_cities")} (`$country`)"}
        {/if}
    {/foreach}

    <div class="cm-j-tabs">
        <ul class="nav nav-tabs">
            <li id="tab_new_cities" class="cm-js active"><a>{__("general")}</a></li>
        </ul>
    </div>

    <div class="cm-tabs-content">
    <fieldset>
        <div class="control-group">
            <label class="cm-required control-label" for="elm_city_code">{__("code")}:</label>
            <div class="controls">
            <input type="text" id="elm_city_code" name="city_data[code]" size="8" value="" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="elm_city_name">{__("city")}:</label>
            <div class="controls">
            <input type="text" id="elm_city_name" name="city_data[city]" size="55" value="" />
            </div>
        </div>

        {include file="common/select_status.tpl" input_name="city_data[status]" id="elm_city_status"}
    </fieldset>
    </div>

    <div class="buttons-container">
        {include file="buttons/save_cancel.tpl" create=true but_name="dispatch[cities.update]" cancel_action="close"}
    </div>

</form>

{/capture}
{/capture}

{capture name="buttons"}
    {capture name="tools_list"}
        {hook name="cities:manage_tools_list"}
            {if $cities}
                <li>{btn type="delete_selected" dispatch="dispatch[cities.m_delete]" form="cities_form"}</li>
            {/if}
        {/hook}
    {/capture}
    {dropdown content=$smarty.capture.tools_list}

    {if $cities}
        {include file="buttons/save.tpl" but_name="dispatch[cities.m_update]" but_role="submit-link" but_target_form="cities_form"}
    {/if}
{/capture}

{capture name="adv_buttons"}
    {include file="common/popupbox.tpl" id="new_city" action="cities.add" text=$title content=$smarty.capture.add_new_picker title=__("add_city") act="general" icon="icon-plus"}
{/capture}

{capture name="sidebar"}
<div class="sidebar-row">
<h6>{__("search")}</h6>
<form action="{""|fn_url}" name="cities_filter_form" method="get">
<div class="sidebar-field">
    <label>{__("country")}:</label>
        <select name="country_code">
            {foreach from=$countries item="country" key="code"}
                <option {if $code == $search.country_code}selected="selected"{/if} value="{$code}">{$country}</option>
            {/foreach}
        </select>
</div>
    {include file="buttons/search.tpl" but_name="dispatch[cities.manage]"}
</form>
</div>
{/capture}


{/capture}
{include file="common/mainbox.tpl" title=__("cities") content=$smarty.capture.mainbox adv_buttons=$smarty.capture.adv_buttons buttons=$smarty.capture.buttons sidebar=$smarty.capture.sidebar select_languages=true}