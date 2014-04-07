<div id="posts_list">
{if $posts}
{include file="common/pagination.tpl" id="pagination_contents_comments_`$object_id`" search=$search}
{foreach from=$posts item=post}
<div class="posts{cycle values=", manage-post"}" id="post_{$post.post_id}">
{hook name="discussion:items_list_row"}
        <span class="caret"> <span class="caret-outer"></span> <span class="caret-inner"></span></span>
        <span class="post-author">{$post.name}</span>
        <span class="post-date">{$post.timestamp|date_format:"`$settings.Appearance.date_format`, `$settings.Appearance.time_format`"}</span>

        {if $post.type == "R" || $post.type == "B" && $post.rating_value > 0}
            <div class="clearfix">
                {include file="addons/discussion/views/discussion/components/stars.tpl" stars=$post.rating_value|fn_get_discussion_rating}
            </div>
        {/if}
        
    
    {if $post.type == "C" || $post.type == "B"}<p class="post-message">{$post.message|escape|nl2br nofilter}</p>{/if}

{/hook}
</div>
{/foreach}


{include file="common/pagination.tpl" id="pagination_contents_comments_`$object_id`" extra_url="&selected_section=discussion" search=$discussion.search}
{else}
<p class="no-items">{__("no_posts_found")}</p>
{/if}
<!--posts_list--></div>
{capture name="mainbox_title"}{__("feedbacks_and_ratings")}{/capture}