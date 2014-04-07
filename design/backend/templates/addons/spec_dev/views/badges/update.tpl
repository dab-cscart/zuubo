{if $badge.badge_id}
    {assign var="id" value=$badge.badge_id}
{else}
    {assign var="id" value=0}
{/if}

<div id="content_group{$id}">

<form action="{""|fn_url}" method="post" name="update_badges_form_{$id}" class="form-horizontal form-edit " enctype="multipart/form-data">
<input type="hidden" name="badge_id" value="{$id}" />

<div class="cm-j-tabs">
	<ul class="nav nav-tabs">
		<li id="tab_new_badges" class="cm-js active"><a>{__("general")}</a></li>
	</ul>
</div>

<div class="cm-tabs-content">
<fieldset>
	<div class="control-group">
		<label class="control-label" for="elm_badge_name">{__("badge")}:</label>
		<div class="controls">
		<input type="text" id="elm_badge_name" name="badge_data[badge]" size="55" value="{$badge.badge}" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="elm_notify_vendor">{__("notify_vendor")}:</label>
		<div class="controls">
			<label class="checkbox">
				<input type="hidden" name="badge_data[notify_vendor]" value="N" />
				<input type="checkbox" name="badge_data[notify_vendor]" id="elm_product_feature_comparison" value="Y" {if $badge.notify_vendor == "Y"}checked="checked"{/if}/>
			</label>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label">{__("icon")}:</label>
		<div class="controls">{include file="common/attach_images.tpl" image_name="badge_image" image_key=$id image_object_type="badge" image_pair=$badge.icon no_detailed="Y" hide_titles="Y" image_object_id=$id}</div>
	</div>

</fieldset>
</div>

<div class="buttons-container">
    {include file="buttons/save_cancel.tpl" but_name="dispatch[badges.update]" cancel_action="close" save=$id}
</div>

</form>
<!--content_group{$id}--></div>