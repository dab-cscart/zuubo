{hook name="products:notification_items"}
    {if $added_products}
        {foreach from=$added_products item=product key="key"}
            {hook name="products:notification_product"}
            <div class="product-notification-item clearfix">
                {include file="common/image.tpl" image_width="50" image_height="50" images=$product.main_pair no_ids=true class="product-notification-image"}
                <div class="product-notification-content clearfix">
                    <a href="{"products.view?product_id=`$product.product_id`"|fn_url}" class="product-notification-product-name">{$product.product_id|fn_get_product_name nofilter}</a>
                    <div class="product-notification-price">
                    {if !$hide_amount}
                    <span class="none">{$product.amount}</span>&nbsp;x&nbsp;{include file="common/price.tpl" value=$product.display_price span_id="price_`$key`" class="none"}
                    {/if}
                    </div>
                    {if $product.product_option_data}
                    {include file="common/options_info.tpl" product_options=$product.product_option_data}
                    {/if}    
                </div>
            </div>
            {/hook}
        {/foreach}
    {else}
    {$empty_text}
    {/if}
{/hook}