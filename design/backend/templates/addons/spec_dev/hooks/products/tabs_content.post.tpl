<div id="content_location" class="hidden">
    <div style="display: inline-block;">
    <div class="control-group">
	<label for="elm_product_metro_cities" class="control-label cm-required">{__("metro_cities")}</label>
	<div class="controls">
	    <select multiple size="10" name="product_data[metro_city_ids][]" id="elm_product_metro_cities">
		{foreach from=$product_data.all_metro_cities item="m_city"}
			<option value="{$m_city.metro_city_id}" {if $m_city.metro_city_id|in_array:$product_data.metro_city_ids}selected="selected"{/if}>{$m_city.metro_city}</option>
		{/foreach}
	    </select>
	</div>
    </div>
    <div class="control-group">
	<label for="elm_product_city_ids" class="control-label">{__("cities")}</label>
	<div class="controls">
	    <select multiple size="10" name="product_data[city_ids][]" id="elm_product_city_ids">
		{foreach from=$product_data.all_cities item="city"}
			<option value="{$city.city_id}" {if $city.city_id|in_array:$product_data.city_ids}selected="selected"{/if}>{$city.city}</option>
		{/foreach}
	    </select>
	</div>
    </div>
    </div>
</div>