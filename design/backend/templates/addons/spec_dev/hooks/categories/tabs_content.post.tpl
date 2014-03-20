<div id="content_location" class="hidden">
    <div class="control-group">
	<label for="elm_category_metro_cities" class="control-label">{__("metro_cities")}</label>
	<div class="controls">
	    <select multiple size="10" name="category_data[metro_city_ids][]" id="elm_category_metro_cities">
		{foreach from=$category_data.all_metro_cities item="m_city"}
			<option value="{$m_city.metro_city_id}" {if $m_city.metro_city_id|in_array:$category_data.metro_city_ids}selected="selected"{/if}>{$m_city.metro_city}</option>
		{/foreach}
	    </select>
	</div>
    </div>
</div>