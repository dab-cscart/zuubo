{hook name="companies:view"}

{assign var="obj_id" value=$company_data.company_id}
{assign var="obj_id_prefix" value="`$obj_prefix``$obj_id`"}
{assign var="th_size" value="125"} 
{assign var="th_scroll_size" value="175"} 
{include file="common/company_data.tpl" company=$company_data show_name=true show_descr=true show_rating=true show_logo=true hide_links=true}
<div class="company-page clearfix">

    <div class="company-page-info clearfix" id="block_company_{$company_data.company_id}">
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
                    <a href="{"products.search?company_id=`$company_data.company_id`&search_performed=Y"|fn_url}">{__("view_all_services")}</a>
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
    
    <h2 class="mainbox-title"><span>{__("description")}</span></h2>
    <div id="block_company_description">
	{if $company_data.company_description}
	    <div class="wysiwyg-content">
		{$company_data.company_description nofilter}
	    </div>
	{/if}
    </div>

    {if $company_data.badges}
	<h2 class="mainbox-title"><span>{__("badges")}</span></h2>
	<div id="block_company_badges">
	    {assign var="columns" value="4"}
	    {if $company_data.badges|sizeof < $columns}
		{assign var="columns" value=$company_data.badges|@sizeof}
	    {/if}
	    {split data=$company_data.badges size=$columns assign="splitted_badges"}
	    {math equation="100 / x" x=$columns|default:"3" assign="cell_width"}
	    {if $item_number == "Y"}
		{assign var="cur_number" value=1}
	    {/if}
	    <table class="fixed-layout table-width">
	    {foreach from=$splitted_badges item="sbadges" name="sprod"}
	    <tr>
	    {foreach from=$sbadges item="badge" name="sbadges"}
		{if $badge}
		    <td class="{if !$smarty.foreach.sprod.last && !$show_add_to_cart} border-bottom{/if}" style="width: {$cell_width}%">
			{include file="common/image.tpl" show_detailed_link=false images=$badge.icon no_ids=true image_id="badge_image" image_width=$th_size image_height=$th_size}
		    </td>
		    {if !$smarty.foreach.sbadges.last}<td class="product-spacer">&nbsp;</td>{/if}
		{/if}
	    {/foreach}
	    </tr>
	    {/foreach}
	    </table>
	</div>
    {/if}

    {if $company_data.image_pairs}
    <h2 class="mainbox-title"><span>{__("photos")}</span></h2>
    <div class="scroller-box" id="block_company_images">
	<div id="scroll_list_company_images" class="owl-carousel">
	    {foreach from=$company_data.image_pairs item="image" key="img_id"}
		<div class="jscroll-item"> 
		    <div class="scroll-image">
			{include file="common/image.tpl" show_detailed_link=false images=$image no_ids=true image_id="badge_image_`$img_id`" image_width=$th_scroll_size image_height=$th_scroll_size}
		    </div>
		</div>              
	    {/foreach}
	</div>
    </div>
    {include file="addons/spec_dev/components/scroller_init.tpl"}
    {/if}

    {hook name="companies:tabs"}
    {/hook}
    
</div>

{/hook}