{foreach from=$posts item=post}
<div class="posts{cycle values=", manage-post"}" id="post_{$post.post_id}">
    {hook name="discussion:items_list_row"}
	<div class="post-author-wrp"><span class="post-author">{$post.name}</span><span class="certified-buyer">{__("certified_buyer")}</span></div>
    <div class="post-rating">
        {if $discussion.type == "R" || $discussion.type == "B" && $post.rating_value > 0}{include file="addons/discussion/views/discussion/components/stars.tpl" stars=$post.rating_value|fn_get_discussion_rating}{/if}
        <span class="post-date">{$post.timestamp|date_format:"`$settings.Appearance.date_format`, `$settings.Appearance.time_format`"}</span>
    </div>
	{if $post.product_id}
	    <div class="product-name">{$post.product_id|fn_get_product_name}</div>
	{/if}
	{* if $discussion.type == "R" || $discussion.type == "B" && $post.rating_value > 0}
	    <div class="clearfix">
		<span style="float: left;"><b>{__("value")}</b></span>{include file="addons/discussion/views/discussion/components/stars.tpl" stars=$post.rating_value|fn_get_discussion_rating}
	    </div>
	    <div class="clearfix">
		<span style="float: left;"><b>{__("time")}</b></span>&nbsp;{include file="addons/discussion/views/discussion/components/stars.tpl" stars=$post.time|fn_get_discussion_rating}
	    </div>
	    <div class="clearfix">
		<span style="float: left;"><b>{__("accuracy")}</b></span>&nbsp;{include file="addons/discussion/views/discussion/components/stars.tpl" stars=$post.accuracy|fn_get_discussion_rating}
	    </div>
	    <div class="clearfix">
		<span style="float: left;"><b>{__("quality")}</b></span>&nbsp;{include file="addons/discussion/views/discussion/components/stars.tpl" stars=$post.quality|fn_get_discussion_rating}
	    </div>
	    <div class="clearfix">
		<span style="float: left;"><b>{__("communication")}</b></span>&nbsp;{include file="addons/discussion/views/discussion/components/stars.tpl" stars=$post.communication|fn_get_discussion_rating}
	    </div>
	    <div class="clearfix">
		<span style="float: left;"><b>{__("professionalism")}</b></span>&nbsp;{include file="addons/discussion/views/discussion/components/stars.tpl" stars=$post.professionalism|fn_get_discussion_rating}
	    </div>
	{/if *}
	
    
    {if $discussion.type == "C" || $discussion.type == "B"}<p class="post-message">{$post.message|escape|nl2br nofilter}</p>{/if}
    {if $allow_vote}
	{include file="addons/spec_dev/components/post_vote.tpl" post_id=$post.post_id value=$post.value}
    {/if}
    {/hook}
</div>
{/foreach}
