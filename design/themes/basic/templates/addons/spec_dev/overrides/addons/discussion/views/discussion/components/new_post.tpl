<div class="hidden" id="new_post_dialog_{$obj_prefix}{$obj_id}" title="{$new_post_title}">
<form action="{""|fn_url}" method="post" class="{if !$post_redirect_url}cm-ajax cm-form-dialog-closer{/if} posts-form" name="add_post_form" id="add_post_form_{$obj_prefix}{$obj_id}">
<input type="hidden" name="result_ids" value="posts_list,new_post,average_rating*">
<input type ="hidden" name="post_data[thread_id]" value="{$discussion.thread_id}" />
<input type ="hidden" name="redirect_url" value="{$post_redirect_url|default:$config.current_url}" />
<input type="hidden" name="selected_section" value="" />

<div id="new_post_{$obj_prefix}{$obj_id}">

<div class="control-group">
    <label for="dsc_name_{$obj_prefix}{$obj_id}" class="cm-required">{__("your_name")}</label>
    <input type="text" id="dsc_name_{$obj_prefix}{$obj_id}" name="post_data[name]" value="{if $auth.user_id}{$user_info.firstname} {$user_info.lastname}{elseif $discussion.post_data.name}{$discussion.post_data.name}{/if}" size="50" class="input-text" />
</div>

{if $discussion.type == "R" || $discussion.type == "B"}
<div class="control-group">
    {$rate_id = "value_`$obj_prefix``$obj_id`"}
    <label for="{$rate_id}" class="cm-required cm-multiple-radios">{__("value")}</label>
    {include file="addons/discussion/views/discussion/components/rate.tpl" rate_id=$rate_id rate_name="post_data[rating_value]"}
</div>
<div class="control-group">
    {$rate_id = "time_`$obj_prefix``$obj_id`"}
    <label for="{$rate_id}" class="cm-required cm-multiple-radios">{__("time")}</label>
    {include file="addons/discussion/views/discussion/components/rate.tpl" rate_id=$rate_id rate_name="post_data[time]"}
</div>
<div class="control-group">
    {$rate_id = "quality_`$obj_prefix``$obj_id`"}
    <label for="{$rate_id}" class="cm-required cm-multiple-radios">{__("quality")}</label>
    {include file="addons/discussion/views/discussion/components/rate.tpl" rate_id=$rate_id rate_name="post_data[quality]"}
</div>
<div class="control-group">
    {$rate_id = "accuracy_`$obj_prefix``$obj_id`"}
    <label for="{$rate_id}" class="cm-required cm-multiple-radios">{__("accuracy")}</label>
    {include file="addons/discussion/views/discussion/components/rate.tpl" rate_id=$rate_id rate_name="post_data[accuracy]"}
</div>
<div class="control-group">
    {$rate_id = "communication_`$obj_prefix``$obj_id`"}
    <label for="{$rate_id}" class="cm-required cm-multiple-radios">{__("communication")}</label>
    {include file="addons/discussion/views/discussion/components/rate.tpl" rate_id=$rate_id rate_name="post_data[communication]"}
</div>
<div class="control-group">
    {$rate_id = "professionalism_`$obj_prefix``$obj_id`"}
    <label for="{$rate_id}" class="cm-required cm-multiple-radios">{__("professionalism")}</label>
    {include file="addons/discussion/views/discussion/components/rate.tpl" rate_id=$rate_id rate_name="post_data[professionalism]"}
</div>
{/if}

{if $discussion.object_type == "M"}
<div class="control-group">
    {$rate_id = "product_`$obj_prefix``$obj_id`"}
    <label for="{$rate_id}" class="cm-required cm-multiple-radios">{__("your_product")}</label>
    {if $smarty.request.product_id}
	{$smarty.request.product_id|fn_get_product_name}
	<input type="hidden" name="post_data[product_id]" value="{$smarty.request.product_id}" />
    {else}
	<select id="elm_{$element.element_id}" name="post_data[product_id]">
	    {foreach from=$discussion.customer_products item=product_id}
	    <option value="{$product_id}">{$product_id|fn_get_product_name}</option>
	    {/foreach}
	</select>
    {/if}
</div>
{/if}

{hook name="discussion:add_post"}
{if $discussion.type == "C" || $discussion.type == "B"}
<div class="control-group">
    <label for="dsc_message_{$obj_prefix}{$obj_id}" class="cm-required">{__("your_message")}</label>
    <textarea id="dsc_message_{$obj_prefix}{$obj_id}" name="post_data[message]" class="input-textarea" rows="5" cols="72">{$discussion.post_data.message}</textarea>
</div>
{/if}
{/hook}

{include file="common/image_verification.tpl" option="use_for_discussion"}

<!--new_post_{$obj_prefix}{$obj_id}--></div>

<div class="buttons-container">
    {include file="buttons/button.tpl" but_text=__("submit") but_role="submit" but_name="dispatch[discussion.add]"}
</div>

</form>
</div>
