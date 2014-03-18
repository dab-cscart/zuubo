{capture name="mainbox"}
<script type="text/javascript">
//<![CDATA[
(function(_, $) {

    /* Do not put this code to document.ready, because it should be
       initialized first
    */
    $.ceRebuildStates('init', {
        default_country: '{$settings.General.default_country|escape:javascript}',
        states: {$states|json_encode nofilter}
    });

}(Tygh, Tygh.$));
//]]>
</script>

<form action="{""|fn_url}" method="post" name="metro_cities_form" class="{if $runtime.company_id} cm-hide-inputs{/if}">
<input type="hidden" name="country_code" value="{$search.country}" />

{include file="common/pagination.tpl" save_current_page=true save_current_url=true}

{if $metro_cities}
<table width="100%" class="table table-middle">
<thead>
<tr>
    <th width="1%">{include file="common/check_items.tpl"}</th>
    <th width="60%">{__("metro_city")}</th>
    <th width="5%">&nbsp;</th>
    <th class="right" width="10%">{__("status")}</th>
</tr>
</thead>
{foreach from=$metro_cities item=metro_city}
<tr class="cm-row-status-{$metro_city.status|lower}">
    <td>
        <input type="checkbox" name="metro_city_ids[]" value="{$metro_city.metro_city_id}" class="checkbox cm-item" /></td>
    <td>
	<a class="row-status cm-external-click" data-ca-external-click-id="{"opener_group`$metro_city.metro_city_id`"}">{$metro_city.metro_city}</a></td>
    <td class="nowrap">
        {capture name="tools_list"}
            <li>{include file="common/popupbox.tpl" id="group`$metro_city.metro_city_id`" text=__("editing_metro_city") link_text=__("edit") act="link" href="metro_cities.update?metro_city_id=`$metro_city.metro_city_id`&search=`$search`"}</li>
            <li>{btn type="list" class="cm-confirm" text=__("delete") href="metro_cities.delete?metro_city_id=`$metro_city.metro_city_id`"}</li>
        {/capture}
        <div class="hidden-tools cm-hide-with-inputs">
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

{if $search.country_code && $search.state_code}
{capture name="adv_buttons"}
    {if "metro_cities.update"|fn_check_view_permissions}
        {capture name="add_new_picker"}
            {include file="addons/spec_dev/views/metro_cities/update.tpl" metro_city=[] country_code=$search.country_code state_code=$search.state_code}
        {/capture}
	{assign var="title" value="{__("new_metro_city")} (`$search.country_code|fn_get_country_name`, `$search.state_code|fn_get_state_name:$search.country_code`)"}
        {include file="common/popupbox.tpl" id="add_new_usergroups" text=$title title=$title content=$smarty.capture.add_new_picker act="general" icon="icon-plus"}
    {/if}
{/capture}
{/if}

{capture name="sidebar"}
<div class="sidebar-row">
<h6>{__("search")}</h6>
<form action="{""|fn_url}" name="metro_cities_filter_form" method="get">
	{$_country = $search.country_code|default:$settings.General.default_country}
	{$_state = $search.state_code}
	<div class="sidebar-field">
		<label for="elm_country_code" class="control-label cm-profile-field cm-location-shipping">{__("country")}:</label>
		<select class="cm-country cm-location-shipping" name="country_code" id="elm_country_code">
			<option value="">- {__("select_country")} -</option>
			{foreach from=$countries item="country" key="code"}
			<option {if $_country == $code}selected="selected"{/if} value="{$code}">{$country}</option>
			{/foreach}
		</select>
	</div>
	<div class="sidebar-field">
		<label for="elm_state_code" class="control-label cm-profile-field cm-location-shipping">{__("state")}:</label>
		<select class="cm-state cm-location-shipping" name="state_code" id="elm_state_code">
		<option value="">- {__("select_state")} -</option>
		{if $states && $states.$_country}
			{foreach from=$states.$_country item=state}
			<option {if $_state == $state.code}selected="selected"{/if} value="{$state.code}">{$state.state}</option>
			{/foreach}
		{/if}
		</select><input type="text" id="elm_state_code_d" name="state_code" size="32" maxlength="64" value="{$_state}" disabled="disabled" class="cm-state cm-location-shipping input-large hidden cm-skip-avail-switch" />
	</div>

    {include file="buttons/search.tpl" but_name="dispatch[metro_cities.manage]"}
</form>
</div>
{/capture}


{/capture}
{include file="common/mainbox.tpl" title=__("metro_cities") content=$smarty.capture.mainbox adv_buttons=$smarty.capture.adv_buttons buttons=$smarty.capture.buttons sidebar=$smarty.capture.sidebar select_languages=true}