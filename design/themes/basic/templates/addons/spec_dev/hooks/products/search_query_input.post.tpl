{$cities = ['metro_city_id' => $smarty.const.METRO_CITY_ID]|fn_get_cities}
{if $cities[0]}
<div class="control-group">
    <label>{__("search_in_cities", ['[metro_city]' => $smarty.const.METRO_CITY_ID|fn_get_metro_city_name])}</label>
    <div class="select-field">
	{foreach from=$cities[0] item="city"}
	    {$city_id = $city.city_id}
	    <label for="{$city_id}">
		<input type="checkbox" value="Y" {if $search.cities.$city_id == 'Y'}checked="checked"{/if} name="cities[{$city_id}]" id="{$city_id}" class="checkbox" />{$city.city}
	    </label>
	{/foreach}
    </div>
</div>
{/if}