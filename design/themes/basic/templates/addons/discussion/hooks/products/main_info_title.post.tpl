{*if $product.discussion_type && $product.discussion_type != 'D'}
    <div class="rating-wrapper clearfix" id="average_rating_product">
        {assign var="rating" value="rating_`$obj_id`"}{$smarty.capture.$rating nofilter}

        {if $product.discussion.posts}
        <a class="cm-external-click" data-ca-scroll="content_discussion" data-ca-external-click-id="discussion">{$product.discussion.posts|count} {__("reviews", [$product.discussion.posts|count])}</a>
        {/if}
        <a class="cm-external-click cm-dialog-opener cm-dialog-auto-size" data-ca-external-click-id="discussion" data-ca-target-id="new_post_dialog_{$obj_id}" rel="nofollow">{__("write_review")}</a>
    <!--average_rating_product--></div>
{/if*}
{if $discussion && $discussion.type != "D"}
    <span class="rating-wrapper clearfix" id="average_rating_product">
        {assign var="rating" value="rating_`$obj_id`"}{$smarty.capture.$rating nofilter}
        {if $discussion.total_posts}
            <a onclick="Tygh.$('#discussion').click(); Tygh.$.scrollToElm(Tygh.$('#content_discussion')); return false;">{$discussion.total_posts} {__("reviews", [$discussion.total_posts])}</a>
        {/if}
        {if !$discussion.disable_adding}
            <a onclick="Tygh.$('#discussion').click(); Tygh.$('#opener_new_post a').click();  Tygh.$.scrollToElm(Tygh.$('#new_post_dialog')); return false;">{__("write_review")}</a>
        {/if}
    <!--average_rating_product--></span>
{/if}