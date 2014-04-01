{if $product}
{assign var="obj_id" value=$obj_id|default:$product.product_id}
{include file="common/product_data.tpl" obj_id=$obj_id product=$product}
<div class="product-container clearfix">
    {assign var="form_open" value="form_open_`$obj_id`"}
    {$smarty.capture.$form_open nofilter}
        {if $item_number == "Y"}<strong>{$smarty.foreach.products.iteration}.&nbsp;</strong>{/if}
        {if $prod_scroller}<p class="product-name">{/if}{assign var="name" value="name_$obj_id"}{$smarty.capture.$name nofilter}{if $prod_scroller}</p>{/if}
        {assign var="sku" value="sku_$obj_id"}{$smarty.capture.$sku nofilter}
        {assign var="rating" value="rating_`$obj_id`"}{$smarty.capture.$rating nofilter}
        
        {if $prod_scroller}
        <p class="product-location">12 Service Providers<br />Near San Jose</p>
        
        <div class="clearfix">
            <div class="float-left rating">{assign var="rating" value="rating_$obj_id"}
                    {$smarty.capture.$rating nofilter}</div>
            <div class="price-wrap float-right right">
        {/if}
        {if !$hide_price}
            <div class="prices-container clearfix">
            {if $show_old_price || $show_clean_price || $show_list_discount}
                <div class="float-left product-prices">
                    {assign var="old_price" value="old_price_`$obj_id`"}
                    {if $smarty.capture.$old_price|trim}{$smarty.capture.$old_price nofilter}&nbsp;{/if}
            {/if}
            
            {if !$smarty.capture.$old_price|trim || $details_page}<p>{/if}
                    {assign var="price" value="price_`$obj_id`"}
                    {$smarty.capture.$price nofilter}
            {if !$smarty.capture.$old_price|trim || $details_page}</p>{/if}

            {if $show_old_price || $show_clean_price || $show_list_discount}
                    {assign var="clean_price" value="clean_price_`$obj_id`"}
                    {$smarty.capture.$clean_price nofilter}
                    
                    {assign var="list_discount" value="list_discount_`$obj_id`"}
                    {$smarty.capture.$list_discount nofilter}
                </div>
            {/if}
            {if $show_discount_label}
                <div class="float-left">
                    {assign var="discount_label" value="discount_label_`$obj_id`"}
                    {$smarty.capture.$discount_label nofilter}
                </div>
            {/if}
            </div>
        {/if}
        {if $prod_scroller}
                    </div>
                </div>
        {/if}

        {if $capture_options_vs_qty}{capture name="product_options"}{/if}
        {assign var="product_amount" value="product_amount_`$obj_id`"}
        {$smarty.capture.$product_amount nofilter}
        
        {if $show_features || $show_descr}
            <p class="product-descr"><strong>{assign var="product_features" value="product_features_`$obj_id`"}{$smarty.capture.$product_features nofilter}</strong>{assign var="prod_descr" value="prod_descr_`$obj_id`"}{$smarty.capture.$prod_descr nofilter}</p>
        {/if}
        
        {assign var="product_options" value="product_options_`$obj_id`"}
        {$smarty.capture.$product_options nofilter}
        
        {if !$hide_qty}
            {assign var="qty" value="qty_`$obj_id`"}
            {$smarty.capture.$qty nofilter}
        {/if}
        
        {assign var="advanced_options" value="advanced_options_`$obj_id`"}
        {$smarty.capture.$advanced_options nofilter}
        {if $capture_options_vs_qty}{/capture}{/if}
        
        {assign var="min_qty" value="min_qty_`$obj_id`"}
        {$smarty.capture.$min_qty nofilter}
        
        {assign var="product_edp" value="product_edp_`$obj_id`"}
        {$smarty.capture.$product_edp nofilter}

        {if $capture_buttons}{capture name="buttons"}{/if}
        {if $show_add_to_cart}
            <div class="buttons-container">
                {assign var="add_to_cart" value="add_to_cart_`$obj_id`"}
                {$smarty.capture.$add_to_cart nofilter}

                {assign var="list_buttons" value="list_buttons_`$obj_id`"}
                {$smarty.capture.$list_buttons nofilter}
            </div>
        {/if}
        {if $capture_buttons}{/capture}{/if}
    {assign var="form_close" value="form_close_`$obj_id`"}
    {$smarty.capture.$form_close nofilter}
</div>

{/if}