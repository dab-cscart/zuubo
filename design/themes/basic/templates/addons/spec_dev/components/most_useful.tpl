{assign var="posts" value=$object_id|fn_get_most_useful_posts:$object_type}
{if $posts}
    {if $discussion && $discussion.type != "D"}
    <div id="content_discussion" class="discussion-block">
    {if $wrap == true}
    {capture name="content"}
    {include file="common/subheader.tpl" title=$title}
    {/if}

    {if $subheader}
	<h4>{$subheader}</h4>
    {/if}

    <div id="posts_list">

    {foreach from=$posts item=post}
    <div class="posts{cycle values=", manage-post"}" id="post_{$post.post_id}">
	    <span class="caret"> <span class="caret-outer"></span> <span class="caret-inner"></span></span>
	    <span class="post-author">{$post.name}</span>
	    <span class="post-date">{$post.timestamp|date_format:"`$settings.Appearance.date_format`, `$settings.Appearance.time_format`"}</span>

	    {if $post.product_id}
		<div>{$post.product_id|fn_get_product_name}</div>
	    {/if}
	    {if $discussion.type == "R" || $discussion.type == "B" && $post.rating_value > 0}
		<div class="clearfix">
		    {*<span style="float: left;"><b>{__("value")}</b></span>*}{include file="addons/discussion/views/discussion/components/stars.tpl" stars=$post.rating_value|fn_get_discussion_rating}
		</div>
		{*<div class="clearfix">
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
		</div>*}
	    {/if}
	    
	
	{if $discussion.type == "C" || $discussion.type == "B"}<p class="post-message">{$post.message|escape|nl2br nofilter}</p>{/if}
	{include file="addons/spec_dev/components/post_vote.tpl" post_id=$post.post_id value=$post.value}
    </div>
    {/foreach}
    <!--posts_list--></div>

    {if $wrap == true}
	{/capture}
	{$smarty.capture.content nofilter}
    {else}
	{capture name="mainbox_title"}{$title}{/capture}
    {/if}
    </div>
    {/if}
{/if}