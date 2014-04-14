{assign var="obj_id" value=$company_data.company_id}
{assign var="obj_id_prefix" value="`$obj_prefix``$obj_id`"}
{assign var="th_size" value="125"} 
{assign var="th_scroll_size" value="175"} 
{include file="common/company_data.tpl" company=$company_data show_name=true show_descr=true show_rating=true show_logo=true hide_links=true}
<div class="company-page clearfix">

    <div class="company-page-info company-storefront-page clearfix" id="block_company_{$company_data.company_id}">
        <div class="company-logo">
            {assign var="capture_name" value="logo_`$obj_id`"}
            {$smarty.capture.$capture_name nofilter}
        </div>
        <div class="company-information">
            <div class="company-name">{$company_data.company}</div>
            <div class="company-location">{$company_data.city}, {$company_data.state}</div>
            <div class="company-serving">{__("serving_since")}&nbsp;{$company_data.service_since}</div>
            {* {__("total_services_sold")}:&nbsp;{$company_data.total_services_sold} *}
        
            <div class="company-page-top-links clearfix">
                {hook name="companies:top_links"}
                <div id="company_products">
                    <a href="{"companies.view?company_id=`$company_data.company_id`"|fn_url}">{__("view")} {__("microsite")}</a>
                </div>
                {/hook}
            </div>
            {if $company_data.top_rated}
                <div class="top-rated">
                {include file="common/image.tpl" show_detailed_link=false images=$company_data.top_rated.icon no_ids=true image_id="badge_image"}
                </div>
            {/if}
        </div>
    </div>
    
    <div id="company_products">
	{if $products}
	{assign var="layouts" value=""|fn_get_products_views:false:0}
	{assign var="product_columns" value=$settings.Appearance.columns_in_products_list}

	{if $layouts.$selected_layout.template}
	    {include file="`$layouts.$selected_layout.template`" columns=$product_columns}
	{/if}

	{elseif $show_no_products_block}
	<p class="no-items cm-pagination-container">{__("text_no_products")}</p>
	{else}
	<div class="cm-pagination-container"></div>
	{/if}
    <!--company_products--></div>
    
</div>