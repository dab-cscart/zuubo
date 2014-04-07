{*if $product.discussion_type && $product.discussion_type != 'D'}
    <div class="rating-wrapper clearfix" id="average_rating_product_{$obj_prefix}{$obj_id}">
        {assign var="rating" value="rating_`$obj_id`"}{$smarty.capture.$rating nofilter}

        {if $product.discussion.posts}
        <a  href="{"products.view?product_id=`$product.product_id`&selected_section=discussion#discussion"|fn_url}">{$product.discussion.posts|count} {__("reviews", [$product.discussion.posts|count])}</a>
        {/if}
        <a class="cm-dialog-opener cm-dialog-auto-size" data-ca-target-id="new_post_dialog_{$obj_prefix}{$obj_id}" rel="nofollow">{__("write_review")}</a>
    <!--average_rating_product_{$obj_prefix}{$obj_id}--></div>
{/if*}
{if $discussion && $discussion.type != "D"}
    <span class="rating-wrapper clearfix" id="average_rating_product_{$obj_prefix}{$obj_id}">
        {assign var="rating" value="rating_`$obj_id`"}{$smarty.capture.$rating nofilter}
        {if $discussion.total_posts}
            <a onclick="Tygh.$('#discussion').click(); Tygh.$.scrollToElm(Tygh.$('#content_discussion')); return false;">{$discussion.total_posts} {__("reviews", [$discussion.total_posts])}</a>
        {/if}
        {if !$discussion.disable_adding}
            <a onclick="Tygh.$('#discussion').click(); Tygh.$('#opener_new_post a').click();  Tygh.$.scrollToElm(Tygh.$('#new_post_dialog')); return false;">{__("write_review")}</a>
        {/if}
    <!--average_rating_product_{$obj_prefix}{$obj_id}--></span>
{/if}