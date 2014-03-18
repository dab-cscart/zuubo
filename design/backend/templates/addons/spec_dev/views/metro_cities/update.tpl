{if $metro_city.metro_city_id}
    {assign var="id" value=$metro_city.metro_city_id}
{else}
    {assign var="id" value=0}
{/if}


<div id="content_group{$id}">
<form action="{""|fn_url}" method="post" name="update_metro_cities_form_{$id}" class="form-horizontal form-edit">

    <input type="hidden" name="metro_city_data[country_code]" value="{$country_code}" />
    <input type="hidden" name="metro_city_data[state_code]" value="{$state_code}" />
    <input type="hidden" name="country_code" value="{$country_code}" />
    <input type="hidden" name="state_code" value="{$state_code}" />
    <input type="hidden" name="metro_city_id" value="{$id}" />

    <fieldset>
	<div class="control-group">
	    <label class="control-label cm-required" for="elm_metro_city_name_{$id}">{__("metro_city")}:</label>
	    <div class="controls">
		<input type="text" id="elm_metro_city_name_{$id}" name="metro_city_data[metro_city]" size="55" value="{$metro_city.metro_city}" />
	    </div>
	</div>
	
	{if $runtime.company_id && "ULTIMATE"|fn_allowed_for || "MULTIVENDOR"|fn_allowed_for}
	    <div class="control-group">
		<label class="control-label" for="seo_name">{__("seo_name")}:</label>
		<div class="controls">
		    <input type="text" name="metro_city_data[seo_name]" id="seo_name" size="55" value="{$metro_city.seo_name}" class="input-large" />
		</div>
	    </div>
	{/if}

	{include file="common/select_status.tpl" input_name="metro_city_data[status]" id="metro_city_data_`$id`" obj=$metro_city}
    </fieldset>

    <div class="buttons-container">
	{include file="buttons/save_cancel.tpl" but_name="dispatch[metro_cities.update]" cancel_action="close" save=$id}
    </div>
</form>
<!--content_group{$id}--></div>
