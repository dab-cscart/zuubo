<div id="content_badges" class="hidden">
	<input type="hidden" name="company_data[badge_ids]" value="" />
	{foreach from=$company_data.all_badges item="badge"}
		<label class="checkbox inline" for="elm_badges_{$badge.badge_id}">
		<input type="checkbox" name="company_data[badge_ids][{$badge.badge_id}]" id="elm_badges_{$badge.badge_id}" {if $badge.badge_id|in_array:$company_data.badge_ids}checked="checked"{/if} value="{$badge.badge_id}" />{$badge.badge}</label>
	{foreachelse}
		&ndash;
	{/foreach}
</div>