{assign var="discussion" value=$object_id|fn_get_discussion:$object_type:true:$smarty.request}
{if $object_type == "P"}
{$new_post_title = __("write_review")}
{else}
{$new_post_title = __("new_post")}
{/if}
{if $discussion && $discussion.type != "D"}
<div id="content_discussion" class="discussion-block">
{if $wrap == true}
{capture name="content"}
{include file="common/subheader.tpl" title=$title}
{/if}

{if $subheader}
    <h4>{$subheader}</h4>
{/if}

{if $discussion.posts}
{if $detailed}
    <div id="reviews_summary">
	<h1 class="mainbox-title"><span>{__("most_recent")}</span></h1>
	{$_tmp = $discussion.posts}
	<div id="block_company_reviews_summary">
	    {$most_recent = $_tmp|array_splice:0:3}
	    {include file="addons/spec_dev/components/posts.tpl" posts=$most_recent}
	</div>
	
	<div style="display: inline-block;width: 101%;">
	    <h1 class="mainbox-title"><span>{__("most_useful")}</span></h1>
	    <div style="display: inline-block;width: 49%;">
		<h1>{__("positive")}</h1>
		<div id="block_company_reviews_summary">
		    {include file="addons/spec_dev/components/posts.tpl" posts=$discussion.most_positive}
		</div>
	    </div>

	    <div style="display: inline-block;width: 49%;">
		<h1>{__("negative")}</h1>
		<div id="block_company_reviews_summary">
		    {include file="addons/spec_dev/components/posts.tpl" posts=$discussion.most_negative}
		</div>
	    </div>
	</div>

    </div>
{/if}



<div id="posts_list">
    <h1 class="mainbox-title"><span>{__("detailed_reviews")}</span></h1>
    {include file="common/pagination.tpl" id="pagination_contents_comments_`$object_id`" extra_url="&selected_section=discussion" search=$discussion.search}
    {include file="addons/spec_dev/components/posts.tpl" posts=$discussion.posts allow_vote=true}


    {include file="common/pagination.tpl" id="pagination_contents_comments_`$object_id`" extra_url="&selected_section=discussion" search=$discussion.search}
<!--posts_list--></div>
{else}
<p class="no-items">{__("no_posts_found")}</p>
{/if}


{if "CRB"|strpos:$discussion.type !== false && !$discussion.disable_adding}
<div class="buttons-container">
    {if !$hide_add}
	{include file="buttons/button.tpl" but_id="opener_new_post" but_text=$new_post_title but_role="submit" but_target_id="new_post_dialog_`$obj_id`" but_meta="cm-dialog-opener cm-dialog-auto-size" but_rel="nofollow"}
    {else}
	{include file="buttons/button.tpl" but_id="opener_new_post" but_text=$new_post_title but_role="submit" but_target_id="new_post_dialog_`$obj_id`" but_meta="cm-dialog-opener cm-dialog-auto-size" but_extra_class="hidden" but_rel="nofollow"}
    {/if}
</div>

{include file="addons/discussion/views/discussion/components/new_post.tpl" new_post_title=$new_post_title}
{/if}

{if $wrap == true}
    {/capture}
    {$smarty.capture.content nofilter}
{else}
    {capture name="mainbox_title"}{$title}{/capture}
{/if}
</div>
{/if}
