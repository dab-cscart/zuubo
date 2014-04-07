
{script src="js/tygh/exceptions.js"}
{if $product}
    {assign var="obj_id" value=$product.product_id}
    {include file="common/product_data.tpl" product=$product separate_buttons=true but_role="big" but_text=__("buy_it_now")}
<div class="product-details">
<div class="product-vendor-info">
    {capture name="sb_content"}
        <div class="pd-vendor-info">
            <h3>FrontPoint Security Systems</h3>
            <p class="location">San Jose, CA</p>
            <div class="vendor-rating">
                <p class="nowrap stars"><a><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star-empty"></i></a></p>
                <a>(301) Reviews</a>
            </div>
            <div class="rated-block top-rated">
                <span>98%</span><br />Positive<br />Reviews
            </div>
            <h4>Detailed Merchant Rating</h4>
            <p>Overall Rating:  4.10 / 5.00</p>
            <table width="100%" class="detailed-rating">
            <tr>
                <td>Metric : 1</td>
                <td><p class="nowrap stars"><a><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star-empty"></i></a></p></td>
                <td>3.8</td>
            </tr>
            <tr>
                <td>Metric : 2</td>
                <td><p class="nowrap stars"><a><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star-empty"></i></a></p></td>
                <td>4.2</td>
            </tr>
            <tr>
                <td>Metric : 3</td>
                <td><p class="nowrap stars"><a><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star-empty"></i></a></p></td>
                <td>4.1</td>
            </tr>
            <tr>
                <td>Metric : 4</td>
                <td><p class="nowrap stars"><a><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star-empty"></i></a></p></td>
                <td>4.4</td>
            </tr>
            <tr>
                <td>Metric : 5</td>
                <td><p class="nowrap stars"><a><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star-empty"></i></a></p></td>
                <td>4.0</td>
            </tr>
            </table>
            <p class="view-all"><a>View All Services</a></p>
        </div>
    {/capture}
    {include file="blocks/wrappers/sidebox_general.tpl" content=$smarty.capture.sb_content title=__("service_provider_details")}
</div>
<div class="product-main-info">
    {hook name="products:main_info_title"}
    {if !$hide_title}<h1 class="mainbox-title">{$product.product nofilter}</h1>{/if}
    {*
    <div class="brand-wrapper">
        {include file="views/products/components/product_features_short_list.tpl" features=$product.header_features}
    </div>
    *}
    {/hook}
    
    <div class="share-buttons">
    {__("share")} : 
    <!-- AddThis Button BEGIN -->
    <div class="addthis_toolbox">
    <a class="addthis_button_facebook"><img src={$images_dir}/pd_facebook.png width="32" height="32" alt="Facebook" /></a>
    <a class="addthis_button_twitter"><img src={$images_dir}/pd_twitter.png width="32" height="32" alt="Twitter" /></a>
    <a class="addthis_button_pinterest_share"><img src={$images_dir}/pd_pinterest.png width="32" height="32" alt="Pinterest" /></a>
    <a class="addthis_button_google_plusone_share"><img src={$images_dir}/pd_google.png width="32" height="32" alt="Google+" /></a>
    </div>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-533d5f3926d2f44e"></script>
    <!-- AddThis Button END -->
    </div>
{hook name="products:view_main_info"}

        <div class="image-wrap float-left">
            {hook name="products:image_wrap"}
                {if !$no_images}
                    <div class="image-border center cm-reload-{$product.product_id}" id="product_images_{$product.product_id}_update">

                        {assign var="discount_label" value="discount_label_`$obj_prefix``$obj_id`"}
                        {$smarty.capture.$discount_label nofilter}

                        {include file="views/products/components/product_images.tpl" product=$product show_detailed_link="Y" image_width=$settings.Thumbnails.product_details_thumbnail_width image_height=$settings.Thumbnails.product_details_thumbnail_height}
                    <!--product_images_{$product.product_id}_update--></div>
                {/if}
            {/hook}
        </div>
        <div class="product-info">
            {assign var="form_open" value="form_open_`$obj_id`"}
            {$smarty.capture.$form_open nofilter}

            {assign var="old_price" value="old_price_`$obj_id`"}
            {assign var="price" value="price_`$obj_id`"}
            {assign var="clean_price" value="clean_price_`$obj_id`"}
            {assign var="list_discount" value="list_discount_`$obj_id`"}
            {assign var="discount_label" value="discount_label_`$obj_id`"}

            {*
            <div class="product-note">
                {$product.promo_text nofilter}
            </div>
            *}

            {if $smarty.capture.$old_price|trim || $smarty.capture.$clean_price|trim || $smarty.capture.$list_discount|trim}
            <div class="dsc-info">
                <div class="di-list-price">{__("list")}<p>{$smarty.capture.$old_price nofilter}</p></div>
                
                {$smarty.capture.$clean_price nofilter}
                {$smarty.capture.$list_discount nofilter}
            </div>
            {/if}
            <div class="price-wrap">

            {__("for")}
            <p>{$smarty.capture.$price nofilter}</p>

            </div>

            {if $capture_options_vs_qty}{capture name="product_options"}{$smarty.capture.product_options nofilter}{/if}
            <div class="options-wrapper indented">
                {assign var="product_options" value="product_options_`$obj_id`"}
                {$smarty.capture.$product_options nofilter}
            </div>
            {if $capture_options_vs_qty}{/capture}{/if}

            <div class="advanced-options-wrapper indented">
                {if $capture_options_vs_qty}{capture name="product_options"}{$smarty.capture.product_options nofilter}{/if}
                {assign var="advanced_options" value="advanced_options_`$obj_id`"}
                {$smarty.capture.$advanced_options nofilter}
                {if $capture_options_vs_qty}{/capture}{/if}
            </div>

            <div class="sku-options-wrapper indented">
                {assign var="sku" value="sku_`$obj_id`"}
                {$smarty.capture.$sku nofilter}
            </div>

            {if $capture_options_vs_qty}{capture name="product_options"}{$smarty.capture.product_options nofilter}{/if}
            <div class="product-fields-wrapper indented">
                <div class="product-fields-group">
                    {assign var="product_amount" value="product_amount_`$obj_id`"}
                    {$smarty.capture.$product_amount nofilter}

                    {assign var="qty" value="qty_`$obj_id`"}
                    {$smarty.capture.$qty nofilter}

                    {assign var="min_qty" value="min_qty_`$obj_id`"}
                    {$smarty.capture.$min_qty nofilter}
                </div>
            </div>
            {if $capture_options_vs_qty}{/capture}{/if}

            {assign var="product_edp" value="product_edp_`$obj_id`"}
            {$smarty.capture.$product_edp nofilter}

            {if $show_descr}
            {assign var="prod_descr" value="prod_descr_`$obj_id`"}
            <h2 class="description-title">{__("description")}</h2>
            <p class="product-description">{$smarty.capture.$prod_descr nofilter}</p>
            {/if}

            {if $capture_buttons}{capture name="buttons"}{/if}
                <div class="buttons-container">

                    {if $show_details_button}
                        {include file="buttons/button.tpl" but_href="products.view?product_id=`$product.product_id`" but_text=__("view_details") but_role="submit"}
                    {/if}

                    {assign var="add_to_cart" value="add_to_cart_`$obj_id`"}
                    {$smarty.capture.$add_to_cart nofilter}

                    {assign var="list_buttons" value="list_buttons_`$obj_id`"}
                    {$smarty.capture.$list_buttons nofilter}

                </div>
            {if $capture_buttons}{/capture}{/if}
            
            <div class="info-for-customers">
                <ul>
                    <li class="clearfix">{__("money_back_guarantee")}</li>
                    <li class="clearfix">{__("service_warranty")}</li>
                    <li class="clearfix">{__("insurance_coverage")}</li>
                </ul>
            </div>

            {assign var="form_close" value="form_close_`$obj_id`"}
            {$smarty.capture.$form_close nofilter}

            {if $show_product_tabs}
            {include file="views/tabs/components/product_popup_tabs.tpl"}
            {$smarty.capture.popupsbox_content nofilter}
            {/if}
        </div>

{/hook}

{if $smarty.capture.hide_form_changed == "Y"}
    {assign var="hide_form" value=$smarty.capture.orig_val_hide_form}
{/if}
</div>

{if $show_product_tabs}

{include file="views/tabs/components/product_tabs.tpl"}

{if $blocks.$tabs_block_id.properties.wrapper}
    {include file=$blocks.$tabs_block_id.properties.wrapper content=$smarty.capture.tabsbox_content title=$blocks.$tabs_block_id.description}
{else}
    {$smarty.capture.tabsbox_content nofilter}
{/if}

{/if}

</div>
{/if}

{capture name="mainbox_title"}{assign var="details_page" value=true}{/capture}
