<div class="feedback-list" id="posts_list">
<div class="feedback-head-info">
    <div class="total-reviews"> 
        <p class="subhead">{__("total_reviews")}</p>
        <p>{__("you")}: 15&nbsp;&nbsp;{__("others")}: 11</p>
    </div>
    <div class="total-pending"> 
        <p class="subhead">{__("total_pending")}</p>
        <p>{__("you")}: 6&nbsp;&nbsp;{__("others")}: 2</p>
    </div>
    <div class="average-rating"> 
        <p class="subhead">{__("average_rating")}</p>
        <p>{__("you")}: 4.5 {__("others")}: 4.6</p>
    </div>
</div>
{if $posts}

<h1 class="mainbox-title"><span>{__("my_pending_reviews")}</span></h1>

{include file="common/pagination.tpl" id="pagination_contents_comments_`$object_id`" search=$search}
{foreach from=$posts item=post}
<div class="feedback" id="post_{$post.post_id}">
{hook name="discussion:items_list_row"}
    {if $post.product_id}<p><a href="{"products.view?product_id=`$post.product_id`"|fn_url}" class="product-title">{$post.product_id|fn_get_product_name}</a></p>{/if}
    <div class="clearfix">
        <div class="float-left feedback-avatar"><img src="{$images_dir}/avatar.jpg" alt="" /></div>
        <div class="product-info form-label-left label-align-left">
            <div class="float-right">
            {if $post.status == "A"}
            <span class="label label-success">{__("approved")}</span>
            {else}
            <span class="label label-important">{__("not_approved")}</span>
            {/if}
            </div>
            <div class="control-group">
                <label>{__("service_provider")} :</label>
                eCreditAttorney
            </div>
            <div class="control-group">
                <label>{__("order_date")} :</label>
                {$post.timestamp|date_format:"`$settings.Appearance.date_format`"}
            </div>
            <div class="control-group">
                <label>{__("order_number")} :</label>
                123456
            </div>
            <div class="control-group">
                <label>{__("you_paid")} :</label>
                $384.5
            </div>
            <div class="control-group">
                <label>{__("order_status")} :</label>
                Competed
            </div>
            {if $post.type == "R" || $post.type == "B" && $post.rating_value > 0}
                <div class="service-rating clearfix">
                    {__("service_provider_rating")} : {include file="addons/discussion/views/discussion/components/stars.tpl" stars=$post.rating_value|fn_get_discussion_rating}
                </div>
            {/if}
        </div>
    </div>
    <div class="buttons-container right">
        <span class="button  button-wrap-left"><span class="button button-wrap-right"><a id="sw_write_review_{$post.post_id}" class="cm-combination">{__("write_review")}</a></span></span>&nbsp;
        {include file="buttons/button.tpl" but_text=__("view_order_details") but_href="spec_dev.feedbacks" but_id="but_id2" but_role="text"}
    </div>
    <div id="write_review_{$post.post_id}" class="vendor-feedback hidden">
        <div class="width-50">
            <h2>{__("vendor_feedback")}</h2>
            <p class="feedback-tooltip">{__("feedback_tooltip")}</p>
            <p>1. {__("rate_vendor")}</p>
            <div class="rate-vendor">
                <div><span class="metric-name">Metric : 1</span><p class="nowrap stars"><a><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i></a></p></div>
                <div><span class="metric-name">Metric : 2</span><p class="nowrap stars"><a><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i></a></p></div>
                <div><span class="metric-name">Metric : 3</span><p class="nowrap stars"><a><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i></a></p></div>
                <div><span class="metric-name">Metric : 4</span><p class="nowrap stars"><a><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i></a></p></div>
            </div>
            <p>2. {__("tell_your_experience")}</p>
            <textarea class="textarea"></textarea>
        </div>
        <p class="feedback-tooltip">{__("review_tooltip")}</p>
        <div class="buttons-container right">
            {include file="buttons/button.tpl" but_text=__("submit") but_href="spec_dev.feedbacks" but_extra_class="submit"}
        </div>
    </div>
    {* 
    {if $post.object_data} {__("by")} <a href="{"`$post.object_data.url`"|fn_url}">{$post.object_data.description}</a>{/if}
    <span class="post-author">{$post.name}</span>
    {if $post.type == "C" || $post.type == "B"}<p class="post-message">{$post.message|escape|nl2br nofilter}</p>{/if}
    *}
    
{/hook}
</div>
{/foreach}


{include file="common/pagination.tpl" id="pagination_contents_comments_`$object_id`" search=$search}
{else}
<p class="no-items">{__("no_posts_found")}</p>
{/if}
<!--posts_list--></div>
{capture name="mainbox_title"}{__("feedbacks_and_ratings")}{/capture}