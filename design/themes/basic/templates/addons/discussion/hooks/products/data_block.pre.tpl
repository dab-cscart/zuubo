{*if $show_rating}
{include file="addons/discussion/views/discussion/components/average_rating.tpl" object_id=$product.product_id object_type="P"}
{/if*}
{if $show_rating}
{include file="addons/discussion/views/discussion/components/average_rating.tpl" object_id=$product.company_id object_type="M"}
{/if}