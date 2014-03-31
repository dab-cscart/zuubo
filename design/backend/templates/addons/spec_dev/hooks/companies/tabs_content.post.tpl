<div id="content_badges" class="hidden">
	<input type="hidden" name="company_data[badge_ids]" value="" />
	{foreach from=$company_data.all_badges item="badge"}
		<label class="checkbox inline" for="elm_badges_{$badge.badge_id}">
		<input type="checkbox" name="company_data[badge_ids][{$badge.badge_id}]" id="elm_badges_{$badge.badge_id}" {if $badge.badge_id|in_array:$company_data.badge_ids}checked="checked"{/if} value="{$badge.badge_id}" />{$badge.badge}</label>
	{foreachelse}
		&ndash;
	{/foreach}
</div>
<div id="content_images" class="hidden clearfix">
    {include file="common/subheader.tpl" title=__("additional_images")}
    {if $company_data.image_pairs}
	<div class="cm-sortable sortable-box" data-ca-sortable-table="images_links" data-ca-sortable-id-name="pair_id" id="additional_images">
	    {assign var="new_image_position" value="0"}
	    {foreach from=$company_data.image_pairs item=pair name="detailed_images"}
		<div class="cm-row-item cm-sortable-id-{$pair.pair_id} cm-sortable-box">
		    <div class="cm-sortable-handle sortable-bar"><img src="{$images_dir}/icon_sort_bar.gif" width="26" height="25" border="0" title="{__("sort_images")}" alt="{__("sort")}" class="valign" /></div>
		    <div class="sortable-item">
			{include file="common/attach_images.tpl" image_name="company_additional" image_object_type="company" image_key=$pair.pair_id image_type="A" image_pair=$pair icon_title=__("additional_thumbnail") detailed_title=__("additional_popup_larger_image") icon_text=__("text_additional_thumbnail") detailed_text=__("text_additional_detailed_image") delete_pair=true no_thumbnail=true}
		    </div>
		    <div class="clear"></div>
		</div>
		{if $new_image_position <= $pair.position}
		    {assign var="new_image_position" value=$pair.position}
		{/if}
	    {/foreach}
	</div>
    {/if}

    <div id="box_new_image">
	<div class="clear cm-row-item">
	    <input type="hidden" name="company_add_additional_image_data[0][position]" value="{$new_image_position}" class="cm-image-field" />
	    <div class="image-upload-wrap pull-left">{include file="common/attach_images.tpl" image_name="company_add_additional" image_object_type="company" image_type="A" icon_title=__("additional_thumbnail") detailed_title=__("additional_popup_larger_image") icon_text=__("text_additional_thumbnail") detailed_text=__("text_additional_detailed_image") no_thumbnail=true}</div>
	    <div class="pull-right">{include file="buttons/multiple_buttons.tpl" item_id="new_image"}</div>
	</div>
    </div>

</div>
