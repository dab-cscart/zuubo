{** block-description:discussion_title_home_page **}

{assign var="discussion" value=0|fn_get_discussion:"E":true:$block.properties}

{if $discussion && $discussion.type != "D" && $discussion.posts}

{foreach from=$discussion.posts item=post}
<div class="testimonial">
<p class="avatar"><img src="{$images_dir}/avatar.jpg" /></p>
{if $discussion.type == "C" || $discussion.type == "B"}
    <p class="post-message"><a href="{"discussion.view?thread_id=`$discussion.thread_id`&post_id=`$post.post_id`"|fn_url}#post_{$post.post_id}">"{$post.message|truncate:100|nl2br}"</a></p>
{/if}

<p class="post-author">{$post.name}{hook name="discussion:block_items_list_row"}{* if $block.properties.positions != "left" && $block.properties.positions != "right"}, <em>{$post.timestamp|date_format:"`$settings.Appearance.date_format`"}</em>{/if *}{/hook}</p>
<p class="author-service">Jane Styling, Palo Alto</p>

{if $block.properties.positions != "left" && $block.properties.positions != "right"}
<div class="clearfix">
    <div class="right"></div>
    {if $discussion.type == "R" || $discussion.type == "B"}
        <div class="right">{include file="addons/discussion/views/discussion/components/stars.tpl" stars=$post.rating_value|fn_get_discussion_rating}</div>
    {/if}
</div>
{/if}
</div>
{/foreach}
{*
<div class="right">
    <a href="{"discussion.view?thread_id=`$discussion.thread_id`"|fn_url}">{__("more_w_ellipsis")}</a>
</div>
*}
{/if}
