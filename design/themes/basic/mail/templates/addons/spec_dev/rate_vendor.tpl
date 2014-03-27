{include file="common/letter_header.tpl"}

{__("dear")} {$order_info.firstname},<br /><br />

{__("submit_vendor_review")}<br /><br />

{foreach from=$order_products item="product_id"}
    <a href="{"products.view?product_id=`$product_id`&selected_section=discussion#content_discussion"|fn_url:"C"}">{$product_id|fn_get_product_name}</a><br /><br />
{/foreach}

{include file="common/letter_footer.tpl"}