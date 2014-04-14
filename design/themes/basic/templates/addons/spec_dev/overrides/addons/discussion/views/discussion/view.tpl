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
    <h2 class="mainbox-title"><span>{__("ratings")}</span></h2>
    <div id="merchant_rating_distribution">
    <div class="column-head">{__("overall_ratings")}</div>
	<h3>{__("merchant_rating_distribution")}</h3>
	{*assign var="average_rating" value=$object_id|fn_get_average_rating:$object_type}

	{if $average_rating}
	<div style="display: inline-block;">
	{include file="addons/discussion/views/discussion/components/stars.tpl" stars=$average_rating|fn_get_discussion_rating is_link=true}
	</div>
	{/if*}
	
	<div id="block_company_ratings">
	    <div>
	    {foreach from=$discussion.ratings item="r_data" key="star"}
		<div>{$star}&nbsp;{__("star")} : {include file="addons/spec_dev/components/progress_bar.tpl" value_width=$r_data.percent star=$star}{$r_data.total}({$r_data.percent}%)</div>
	    {/foreach}
	    </div>
	</div>
    </div>
    
    <div id="detailed_rating">
        <h3>{__("detailed_merchant_rating")}</h3>
        <div class="detailed-rating" id="block_company_detailed_rating">
            {foreach from=$discussion.detailed_rating item="r_data" key="metric"}
            <div class="dr-metric"><span class="metric">{__($metric)} : </span>{include file="addons/discussion/views/discussion/components/stars.tpl" stars=$r_data.average|fn_get_discussion_rating} {$r_data.average}</div>
            {/foreach}
        </div>
    </div>

    <div id="merchant_rating_history">
	<h3>{__("merchant_rating_history")}</h3>
	<div id="block_company_reviews_summary">
	    <table class="merchant-rating table-width">
	    <th>
		<td>{__("this_month")}</td>
		<td>{__("last_90_days")}</td>
		<td>{__("last_year")}</td>
		<td>{__("lifetime")}</td>
	    </th>
	    {foreach from=$discussion.history item="periods" key="state"}
		<tr>
		    <td>{__($state)}</td>
		    {foreach from=$periods item="percentage" key="period"}
			<td>{$percentage}{if $state != 'total_count'}%{/if}</td>
		    {/foreach}
		</tr>
	    {/foreach}
	    </table>
	</div>
    </div>
    

    <h2 class="mainbox-title"><span>{__("reviews_summary")}</span></h2>
    <div id="most_recent">
	<h3>{__("most_recent")}</h3>
	{$_tmp = $discussion.posts}
	<div id="block_company_reviews_summary">
	    {$most_recent = $_tmp|array_splice:0:3}
	    {include file="addons/spec_dev/components/posts.tpl" posts=$most_recent}
	</div>
    </div>
    <div id="most_recent" style="padding-bottom: 50px;">
	<div>
	    <h2 class="mainbox-title"><span>{__("most_useful")}</span></h2>
	    <div class="useful-col1">
		<h3>{__("positive")}</h3>
		<div id="block_company_reviews_summary">
		    {include file="addons/spec_dev/components/posts.tpl" posts=$discussion.most_positive}
		</div>
	    </div>

	    <div class="useful-col2">
		<h3>{__("negative")}</h3>
		<div id="block_company_reviews_summary">
		    {include file="addons/spec_dev/components/posts.tpl" posts=$discussion.most_negative}
		</div>
	    </div>
	</div>
    </div>
{/if}



<div id="posts_list">
    {if $detailed}<h2 class="mainbox-title"><span>{__("detailed_reviews")}</span></h2>{/if}
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

{if !$product}
<div class="microsite-buttons">
    <span class="view-all-services"><a href="">{__("view_all_services")}</a></span>
    <span class="request-quote"><a href="">{__("request_quote")}</a></span>
</div>
{/if}

{if $wrap == true}
    {/capture}
    {$smarty.capture.content nofilter}
{else}
    {capture name="mainbox_title"}{$title}{/capture}
{/if}
</div>
{/if}
